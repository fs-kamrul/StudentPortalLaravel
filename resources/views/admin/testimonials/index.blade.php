@extends('layouts.admin')

@section('title', 'All Testimonials')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>All Testimonials</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.testimonials.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Testimonial Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ $filterStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $filterStatus == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $filterStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-select">
                        <option value="">All Payments</option>
                        <option value="paid" {{ $filterPaymentStatus == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ $filterPaymentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="unpaid" {{ $filterPaymentStatus == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                
                @if($filterStatus || $filterPaymentStatus)
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary w-100">Clear Filters</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="card">
        <div class="card-body">
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>GPA</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Amount</th>
                                <th>Bkash TrxID</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $testimonial->testimonial_id }}</td>
                                    <td>{{ $testimonial->student->name ?? 'N/A' }}</td>
                                    <td>{{ $testimonial->student_id }}</td>
                                    <td>{{ $testimonial->gpa }}</td>
                                    <td>
                                        @if($testimonial->status == 'approved')
                                            <span class="badge bg-success">✓ Approved</span>
                                        @elseif($testimonial->status == 'pending')
                                            <span class="badge bg-warning">⏳ Pending</span>
                                        @else
                                            <span class="badge bg-danger">✗ {{ ucfirst($testimonial->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($testimonial->payment_status == 'paid')
                                            <span class="badge bg-success">✓ Paid</span>
                                        @elseif($testimonial->payment_status == 'pending')
                                            <span class="badge bg-warning">⏳ Pending</span>
                                        @else
                                            <span class="badge bg-danger">✗ Unpaid</span>
                                        @endif
                                    </td>
                                    <td>৳{{ number_format($testimonial->payment_amount ?? 0, 2) }}</td>
                                    <td>{{ $testimonial->bkash_transaction_id ?? '-' }}</td>
                                    <td>{{ $testimonial->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $testimonials->firstItem() ?? 0 }} to {{ $testimonials->lastItem() ?? 0 }} 
                        of {{ $testimonials->total() }} testimonials
                    </div>
                    <div>
                        {{ $testimonials->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.3;">📜</div>
                    <p class="text-muted mt-3">No testimonials found</p>
                    @if($filterStatus || $filterPaymentStatus)
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
