@extends('layouts.admin')

@section('title', 'All Students')

@section('styles')
<style>
    .pagination {
        margin: 0;
    }
    .pagination .page-link {
        color: #f5576c;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 5px;
    }
    .pagination .page-link:hover {
        background-color: #f093fb;
        color: white;
        border-color: #f093fb;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-color: #f5576c;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
</style>
@endsection


@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>All Students</h2>
                <div>
                    <form action="{{ route('admin.students.resetAllPasswords') }}" method="POST" class="d-inline me-2" onsubmit="return confirm('⚠️ WARNING: This will reset passwords for ALL students to their Student IDs and force password change on next login. Continue?');">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <span>🔒</span> Reset All Passwords
                        </button>
                    </form>
                    <a href="#" class="btn btn-primary">
                        <span>➕</span> Add New Student
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.students.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="class" class="form-label">Class</label>
                    <select name="class" id="class" class="form-select">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class }}" {{ $filterClass == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="section" class="form-label">Section</label>
                    <select name="section" id="section" class="form-select">
                        <option value="">All Sections</option>
                        @foreach($sections as $section)
                            <option value="{{ $section }}" {{ $filterSection == $section ? 'selected' : '' }}>
                                {{ $section }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="group_r" class="form-label">Group</label>
                    <select name="group_r" id="group_r" class="form-select">
                        <option value="">All Groups</option>
                        @foreach($groups as $group)
                            <option value="{{ $group }}" {{ $filterGroup == $group ? 'selected' : '' }}>
                                {{ $group }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-select">
                        <option value="">All Years</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $filterYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" name="student_id" id="student_id" class="form-control" 
                           placeholder="Search by ID" value="{{ $filterStudentId }}">
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                
                @if($filterClass || $filterSection || $filterGroup || $filterYear || $filterStudentId)
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary w-100">Clear Filters</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card">
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Roll</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Group</th>
                                <th>Year</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->roll }}</td>
                                    <td>{{ $student->class }}</td>
                                    <td>{{ $student->section }}</td>
                                    <td>{{ $student->group_r }}</td>
                                    <td>{{ $student->year }}</td>
                                    <td>{{ $student->mobile_number }}</td>
                                    <td>
                                        <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.students.resetPassword', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reset password to student ID? Student will be required to change password on next login.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Reset Password</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} 
                        of {{ $students->total() }} students
                    </div>
                    <div>
                        {{ $students->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.3;">📚</div>
                    <p class="text-muted mt-3">No students found</p>
                    @if($filterClass || $filterSection || $filterGroup || $filterYear)
                        <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
