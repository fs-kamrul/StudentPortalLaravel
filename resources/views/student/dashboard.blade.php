@extends('layouts.student')

@section('title', 'Dashboard - StudentPortal')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h1 class="h3 text-primary mb-2">Welcome back, {{ $student->name ?? 'Student' }}! 👋</h1>
            <p class="text-muted mb-0">You have successfully logged into the Student Portal. Access your information, courses, and grades from your personalized dashboard.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h3>Student ID</h3>
                <div class="stat-value">{{ $student->id }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-left-color: #f093fb;">
                <h3>Account Status</h3>
                <div class="stat-value" style="color: #f093fb; font-size: 20px;">✓ Active</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-left-color: #4facfe;">
                <h3>Portal Access</h3>
                <div class="stat-value" style="color: #4facfe; font-size: 20px;">Full Access</div>
            </div>
        </div>
    </div>
</div>
@endsection
