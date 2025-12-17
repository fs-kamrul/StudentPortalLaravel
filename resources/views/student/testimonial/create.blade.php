@extends('layouts.student')

@section('title', 'Request Testimonial - StudentPortal')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.testimonials.index') }}" class="text-decoration-none">Testimonials</a></li>
            <li class="breadcrumb-item active" aria-current="page">Request New</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="h2 mb-2">Request Testimonial</h1>
            <p class="text-muted mb-4">Fill out the form below to request a new testimonial certificate</p>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info Box -->
            <div class="alert alert-info">
                <strong>📌 Important:</strong> Please ensure all information is accurate. Your testimonial will be processed based on the details provided.
            </div>

            <!-- Payment Info Alert -->
            <div class="alert alert-warning">
                <h5 class="alert-heading">💳 Payment Information</h5>
                <p class="mb-2"><strong>Testimonial Fee: ৳100.00</strong></p>
                <p class="mb-0">You will be able to pay via Bkash after submitting your request.</p>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('student.testimonials.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" value="{{ $student->id }}" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="registration_id" class="form-label">Registration ID *</label>
                                <input type="text" class="form-control" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" placeholder="Enter your registration ID" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="roll" class="form-label">Roll Number *</label>
                                <input type="text" class="form-control" id="roll" name="roll" value="{{ old('roll') }}" placeholder="Enter your roll number" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gpa" class="form-label">GPA *</label>
                            <input type="number" class="form-control" id="gpa" name="gpa" step="0.01" min="0" max="5" value="{{ old('gpa') }}" placeholder="Enter your GPA (e.g., 3.75)" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-gradient btn-lg">Submit Request</button>
                        </div>

                        <p class="text-center text-muted small mt-3 mb-0">
                            After submission, you'll see a "Pay Bkash" button to complete payment
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
