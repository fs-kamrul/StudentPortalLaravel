@extends('layouts.admin')

@section('title', 'CQ Subjects')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <h2>📚 CQ Subjects</h2>
                <div>
                    <a href="{{ route('admin.cq.subjects.create') }}" class="btn btn-primary">
                        ➕ Create New Subject
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cq.subjects.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ $filterStatus == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $filterStatus == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                
                @if($filterStatus)
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.cq.subjects.index') }}" class="btn btn-secondary w-100">Clear Filters</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Subjects Table -->
    <div class="card">
        <div class="card-body">
            @if($subjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Class Level</th>
                                <th>Chapters</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->id }}</td>
                                    <td><strong>{{ $subject->subject_name }}</strong></td>
                                    <td>{{ $subject->subject_code ?? '-' }}</td>
                                    <td>{{ $subject->class_level ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $subject->chapters_count }} chapters</span>
                                        <div class="mt-1">
                                            <span class="badge bg-primary">{{ $subject->part_questions_count }} QBank items</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($subject->status == 'active')
                                            <span class="badge bg-success">✓ Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.cq.chapters.index', $subject->id) }}" class="btn btn-outline-primary" title="View Chapters">
                                                📑 Chapters
                                            </a>
                                            <a href="{{ route('admin.cq.subjects.edit', $subject->id) }}" class="btn btn-outline-secondary" title="Edit">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('admin.cq.subjects.destroy', $subject->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">🗑️ Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} 
                        of {{ $subjects->total() }} subjects
                    </div>
                    <div>
                        {{ $subjects->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.3;">📚</div>
                    <p class="text-muted mt-3">No subjects found</p>
                    @if($filterStatus)
                        <a href="{{ route('admin.cq.subjects.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
