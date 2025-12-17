<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bkash Payment - StudentPortal</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .payment-card {
            max-width: 500px;
            width: 100%;
        }

        .bkash-logo {
            background: #E2136E;
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
        }

        .bkash-logo h2 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .amount-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .amount-display h3 {
            color: #E2136E;
            font-size: 36px;
            font-weight: 700;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="payment-card">
        <!-- Bkash Branding -->
        <div class="bkash-logo">
            <h2>bKash</h2>
            <p class="mb-0">Mobile Financial Service</p>
        </div>

        <!-- Card -->
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <h4 class="mb-3">Complete Payment</h4>

                <!-- Testimonial Info -->
                <div class="alert alert-info">
                    <strong>Testimonial Request #{{ $testimonial->id }}</strong><br>
                    <small>Student ID: {{ $student->id }}</small>
                </div>

                <!-- Amount Display -->
                <div class="amount-display">
                    <small class="text-muted d-block mb-1">Amount to Pay</small>
                    <h3>৳{{ number_format($testimonial->payment_amount, 2) }}</h3>
                </div>

                <!-- Instructions -->
                <div class="alert alert-warning">
                    <h6 class="alert-heading">💡 Payment Instructions</h6>
                    <ol class="mb-0 ps-3">
                        <li>Open your Bkash app</li>
                        <li>Select "Send Money" or "Payment"</li>
                        <li>Send ৳{{ number_format($testimonial->payment_amount, 2) }} to merchant</li>
                        <li>Enter transaction details below</li>
                    </ol>
                </div>

                <!-- Payment Form -->
                <form method="POST" action="{{ route('student.testimonials.payment.callback', $testimonial->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="bkash_transaction_id" class="form-label">Bkash Transaction ID *</label>
                        <input type="text" class="form-control @error('bkash_transaction_id') is-invalid @enderror" 
                               id="bkash_transaction_id" name="bkash_transaction_id" 
                               placeholder="e.g., 9A1B2C3D4E" required>
                        <small class="text-muted">Enter the Transaction ID from your Bkash app</small>
                        @error('bkash_transaction_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bkash_phone_number" class="form-label">Your Bkash Number *</label>
                        <input type="text" class="form-control @error('bkash_phone_number') is-invalid @enderror" 
                               id="bkash_phone_number" name="bkash_phone_number" 
                               placeholder="01XXXXXXXXX" required>
                        <small class="text-muted">Enter the phone number used for payment</small>
                        @error('bkash_phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg" style="background: #E2136E; color: white;">
                            Confirm Payment
                        </button>
                        <a href="{{ route('student.testimonials.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>

                <p class="text-center text-muted small mt-3 mb-0">
                    Your payment will be verified by admin within 24 hours
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
