@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;">
                <div class="card-body p-4">
                    <h2 class="mb-2">👋 Welcome back, {{ $admin->admin_name }}!</h2>
                    <p class="mb-0 opacity-75">Administrative Dashboard</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Students</p>
                            <h3 class="mb-0">{{ $totalStudents }}</h3>
                        </div>
                        <div style="font-size: 2rem;">👥</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Approved Testimonials</p>
                            <h3 class="mb-0">{{ $approvedTestimonials }}</h3>
                        </div>
                        <div style="font-size: 2rem;">✅</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Testimonials</p>
                            <h3 class="mb-0">{{ $pendingTestimonials }}</h3>
                        </div>
                        <div style="font-size: 2rem;">📜</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Testimonials</p>
                            <h3 class="mb-0">{{ $pendingTestimonials + $approvedTestimonials }}</h3>
                        </div>
                        <div style="font-size: 2rem;">📄</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Testimonials -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Testimonials & Payment Status</h5>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($testimonials->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student</th>
                                        <th>Student ID</th>
                                        <th>GPA</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Amount</th>
                                        <th>Date</th>
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
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($testimonial->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($testimonial->status) }}</span>
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
                                            <td>{{ $testimonial->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Mobile Card View -->
                        <div class="d-md-none">
                            @foreach($testimonials as $testimonial)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $testimonial->student->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">ID: {{ $testimonial->student_id }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $testimonial->testimonial_id }}</span>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <small class="text-muted d-block">GPA</small>
                                                <strong>{{ $testimonial->gpa }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Amount</small>
                                                <strong>৳{{ number_format($testimonial->payment_amount ?? 0, 2) }}</strong>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <small class="text-muted d-block">Status</small>
                                                @if($testimonial->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($testimonial->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($testimonial->status) }}</span>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted d-block">Payment</small>
                                                @if($testimonial->payment_status == 'paid')
                                                    <span class="badge bg-success">✓ Paid</span>
                                                @elseif($testimonial->payment_status == 'pending')
                                                    <span class="badge bg-warning">⏳ Pending</span>
                                                @else
                                                    <span class="badge bg-danger">✗ Unpaid</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <small class="text-muted">{{ $testimonial->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div style="font-size: 3rem; opacity: 0.3;">📜</div>
                            <p class="text-muted mt-3">No testimonials yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-outline-primary w-100 py-3">
                                <div>➕ Add New Student</div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-outline-primary w-100 py-3">
                                <div>📊 View Reports</div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-outline-primary w-100 py-3">
                                <div>⚙️ System Settings</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
