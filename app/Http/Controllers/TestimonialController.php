<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display testimonial request form
     */
    public function create()
    {
        $student = Auth::guard('student')->user();
        return view('student.testimonial.create', compact('student'));
    }

    /**
     * Store testimonial request
     */
    public function store(Request $request)
    {
        $student = Auth::guard('student')->user();

        // Validate the request
        $validated = $request->validate([
            'registration_id' => 'required|string|max:255',
            'roll' => 'required|string|max:255',
            'gpa' => 'required|numeric|min:0|max:5',
        ]);

        // Create testimonial request (payment will be done separately)
        Testimonial::create([
            'student_id' => $student->id,
            'registration_id' => $validated['registration_id'],
            'roll' => $validated['roll'],
            'gpa' => $validated['gpa'],
            'status' => 'pending',
            'payment_method' => 'bkash',
            'payment_amount' => 100.00,
            'payment_status' => 'unpaid', // Student needs to pay
        ]);

        return redirect()->route('student.testimonials.index')
            ->with('success', 'Testimonial request submitted successfully! Please complete payment.');
    }

    /**
     * Display list of testimonial requests
     */
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        // Get testimonials for the logged-in student with pagination
        $testimonials = Testimonial::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.testimonial.index', compact('testimonials', 'student'));
    }

    /**
     * Initiate Bkash payment for testimonial
     */
    public function initiatePayment($id)
    {
        $student = Auth::guard('student')->user();
        $testimonial = Testimonial::where('id', $id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        // Check if already paid
        if ($testimonial->payment_status === 'paid') {
            return redirect()->route('student.testimonials.index')
                ->with('error', 'This testimonial has already been paid.');
        }

        // In real implementation, integrate with Bkash API here
        // For now, redirect to a payment page
        return view('student.testimonial.payment', compact('testimonial', 'student'));
    }

    /**
     * Process payment callback
     */
    public function paymentCallback(Request $request, $id)
    {
        $student = Auth::guard('student')->user();
        $testimonial = Testimonial::where('id', $id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        // Validate payment details
        $validated = $request->validate([
            'bkash_transaction_id' => 'required|string|max:255',
            'bkash_phone_number' => 'required|string|max:15',
        ]);

        // Update payment status
        $testimonial->bkash_transaction_id = $validated['bkash_transaction_id'];
        $testimonial->bkash_phone_number = $validated['bkash_phone_number'];
        $testimonial->payment_status = 'pending'; // Admin will verify
        $testimonial->save();

        return redirect()->route('student.testimonials.index')
            ->with('success', 'Payment submitted successfully! Awaiting verification.');
    }
}
