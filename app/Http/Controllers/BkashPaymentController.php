<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Testimonial;
use App\Models\PaymentTransaction;

class BkashPaymentController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;

    public function __construct()
    {
        // Bkash Sandbox Credentials
        $this->base_url = env('BKASH_BASE_URL', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta');
        $this->app_key = env('BKASH_APP_KEY', '4f6o0cjiki2rfm34kfdadl1eqq');
        $this->app_secret = env('BKASH_APP_SECRET', '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b');
        $this->username = env('BKASH_USERNAME', 'sandboxTokenizedUser02');
        $this->password = env('BKASH_PASSWORD', 'sandboxTokenizedUser02@12345');
    }

    /**
     * Get Bkash access token
     */
    private function getToken()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'username' => $this->username,
            'password' => $this->password,
        ])->post($this->base_url . '/tokenized/checkout/token/grant', [
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
        ]);

        if ($response->successful()) {
            return $response->json()['id_token'];
        }

        return null;
    }

    /**
     * Create Bkash payment
     */
    public function createPayment($testimonial_id)
    {
        $student = Auth::guard('student')->user();
        $testimonial = Testimonial::where('id', $testimonial_id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        // Check if already paid
        if ($testimonial->payment_status === 'paid') {
            return redirect()->route('student.testimonials.index')
                ->with('error', 'This testimonial has already been paid.');
        }

        $token = $this->getToken();

        if (!$token) {
            return redirect()->back()->with('error', 'Unable to connect to Bkash. Please try again.');
        }

        // Create payment request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $this->app_key,
        ])->post($this->base_url . '/tokenized/checkout/create', [
            'mode' => '0011',
            'payerReference' => $student->id,
            'callbackURL' => route('bkash.callback', $testimonial->id),
            'amount' => $testimonial->payment_amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => 'TEST-' . $testimonial->id . '-' . time(),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Store payment ID in session
            session([
                'bkash_payment_id' => $data['paymentID'],
                'testimonial_id' => $testimonial->id,
            ]);

            // Log payment transaction
            PaymentTransaction::create([
                'payment_id' => $data['paymentID'],
                'student_id' => $student->id,
                'testimonial_id' => $testimonial->id,
                'amount' => $testimonial->payment_amount,
                'currency' => 'BDT',
                'status' => 'pending',
            ]);

            // Redirect to Bkash payment page
            return redirect($data['bkashURL']);
        }

        return redirect()->back()->with('error', 'Payment creation failed. Please try again.');
    }

    /**
     * Handle Bkash callback
     */
    public function callback(Request $request, $testimonial_id)
    {
        $student = Auth::guard('student')->user();
        $testimonial = Testimonial::findOrFail($testimonial_id);

        $paymentID = $request->get('paymentID');
        $status = $request->get('status');

        if ($status === 'cancel' || $status === 'failure') {
            // Update transaction status
            PaymentTransaction::where('payment_id', $paymentID)
                ->update(['status' => $status === 'cancel' ? 'cancelled' : 'failed']);

            return redirect()->route('student.testimonials.index')
                ->with('error', 'Payment was cancelled or failed.');
        }

        // Execute payment
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $this->app_key,
        ])->post($this->base_url . '/tokenized/checkout/execute', [
            'paymentID' => $paymentID,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['transactionStatus']) && $data['transactionStatus'] === 'Completed') {
                // Update transaction status
                PaymentTransaction::where('payment_id', $paymentID)
                    ->update([
                        'status' => 'completed',
                        'transaction_id' => $data['trxID'],
                        'customer_msisdn' => $data['customerMsisdn'] ?? null,
                    ]);

                // Update testimonial payment status
                $testimonial->bkash_transaction_id = $data['trxID'];
                $testimonial->bkash_phone_number = $data['customerMsisdn'] ?? '';
                $testimonial->payment_status = 'paid';
                $testimonial->save();

                return redirect()->route('student.testimonials.index')
                    ->with('success', 'Payment successful! Transaction ID: ' . $data['trxID']);
            }
        }



        // Update transaction status to failed if execution fails or status is not Completed
        PaymentTransaction::where('payment_id', $paymentID)
            ->update(['status' => 'failed']);

        return redirect()->route('student.testimonials.index')
            ->with('error', 'Payment execution failed. Please contact support.');
    }

    /**
     * Query payment status
     */
    public function queryPayment($paymentID)
    {
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $this->app_key,
        ])->post($this->base_url . '/tokenized/checkout/payment/status', [
            'paymentID' => $paymentID,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
