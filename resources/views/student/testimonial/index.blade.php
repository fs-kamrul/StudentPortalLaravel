@extends('layouts.student')

@section('title', 'My Testimonials - StudentPortal')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">My Testimonials</h1>
        <a href="{{ route('student.testimonials.create') }}" class="btn btn-gradient">
            <span>+</span> Request New
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✓</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>✗</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Testimonials List -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($testimonials->count() > 0)
                <!-- Desktop Table View -->
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#ID</th>
                                <th>Registration ID</th>
                                <th>Roll</th>
                                <th>GPA</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td><strong>#{{ $testimonial->id }}</strong></td>
                                    <td>{{ $testimonial->registration_id }}</td>
                                    <td>{{ $testimonial->roll }}</td>
                                    <td>{{ number_format($testimonial->gpa, 2) }}</td>
                                    <td>
                                        <span class="status-badge" style="background-color: {{ $testimonial->status_color }}">
                                            {{ $testimonial->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($testimonial->payment_status === 'paid')
                                            <span class="badge bg-success">✓ Paid</span>
                                            @if($testimonial->bkash_transaction_id)
                                                <br><small class="text-muted">TrxID: {{ $testimonial->bkash_transaction_id }}</small>
                                            @endif
                                        @elseif($testimonial->payment_status === 'pending')
                                            <span class="badge bg-warning text-dark">⏳ Verifying</span>
                                        @else
                                            <span class="badge bg-danger">✗ Unpaid</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">৳{{ number_format($testimonial->payment_amount, 2) }}</small>
                                    </td>
                                    <td>
                                        @if($testimonial->payment_status === 'unpaid')
                                            <a href="{{ route('bkash.payment', $testimonial->id) }}" class="btn btn-sm" style="background: #E2136E; color: white;">
                                                💳 Pay with Bkash
                                            </a>
                                        @elseif($testimonial->payment_status === 'pending')
                                            <span class="text-muted small">Pending verification</span>
                                        @else
                                            <span class="text-success small">✓ Confirmed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="mobile-cards p-3">
                    @foreach($testimonials as $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-card-header">
                                <div class="testimonial-id">#{{ $testimonial->id }}</div>
                                <span class="status-badge" style="background-color: {{ $testimonial->status_color }}">
                                    {{ $testimonial->status_label }}
                                </span>
                            </div>
                            <div class="card-row">
                                <span class="card-label">Registration ID</span>
                                <span class="card-value">{{ $testimonial->registration_id }}</span>
                            </div>
                            <div class="card-row">
                                <span class="card-label">Roll Number</span>
                                <span class="card-value">{{ $testimonial->roll }}</span>
                            </div>
                            <div class="card-row">
                                <span class="card-label">GPA</span>
                                <span class="card-value">{{ number_format($testimonial->gpa, 2) }}</span>
                            </div>
                            <div class="card-row">
                                <span class="card-label">Payment Status</span>
                                <span class="card-value">
                                    @if($testimonial->payment_status === 'paid')
                                        <span class="badge bg-success">✓ Paid</span>
                                    @elseif($testimonial->payment_status === 'pending')
                                        <span class="badge bg-warning text-dark">⏳ Verifying</span>
                                    @else
                                        <span class="badge bg-danger">✗ Unpaid</span>
                                    @endif
                                </span>
                            </div>
                            <div class="card-row">
                                <span class="card-label">Amount</span>
                                <span class="card-value">৳{{ number_format($testimonial->payment_amount, 2) }}</span>
                            </div>

                            @if($testimonial->payment_status === 'unpaid')
                                <div class="mt-3">
                                    <a href="{{ route('bkash.payment', $testimonial->id) }}" class="btn w-100" style="background: #E2136E; color: white;">
                                        💳 Pay with Bkash
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center p-3 border-top">
                    {{ $testimonials->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center p-5">
                    <div style="font-size: 64px;">📄</div>
                    <h3 class="text-muted mt-3">No Testimonials Yet</h3>
                    <p class="text-muted">You haven't requested any testimonials. Click the button above to request your first one!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
