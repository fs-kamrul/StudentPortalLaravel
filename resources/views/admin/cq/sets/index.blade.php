@extends('layouts.admin')

@section('title', 'Question Sets')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <h2>📝 Question Sets</h2>
                <div>
                    <a href="{{ route('admin.cq.sets.create') }}" class="btn btn-primary">
                        ➕ Create New Set
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cq.sets.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $filterSubject == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="draft" {{ $filterStatus == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $filterStatus == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                
                @if($filterSubject || $filterStatus)
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.cq.sets.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($sets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Set Name</th>
                                <th>Subject</th>
                                <th>Exam Name</th>
                                <th>Questions</th>
                                <th>Total Marks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sets as $set)
                                <tr>
                                    <td>{{ $set->id }}</td>
                                    <td><strong>{{ $set->set_name }}</strong></td>
                                    <td>{{ $set->subject->subject_name }}</td>
                                    <td>{{ $set->exam_name }}</td>
                                    <td><span class="badge bg-info">{{ $set->questions_count }} questions</span></td>
                                    <td>{{ $set->total_marks }}</td>
                                    <td>
                                        @if($set->status == 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.cq.sets.preview', $set->id) }}" class="btn btn-outline-info" title="Preview Paper">
                                                👁️
                                            </a>
                                            <a href="{{ route('admin.cq.sets.addQuestions', $set->id) }}" class="btn btn-outline-primary" title="Manage Questions">
                                                ➕ Q
                                            </a>
                                            <a href="{{ route('admin.cq.sets.edit', $set->id) }}" class="btn btn-outline-secondary" title="Edit Details">
                                                ✏️
                                            </a>
                                            @if($set->status == 'published')
                                            <a href="{{ route('admin.cq.sets.pdf', $set->id) }}" class="btn btn-outline-danger" title="Download PDF">
                                                📥
                                            </a>
                                            @endif
                                            <form action="{{ route('admin.cq.sets.destroy', $set->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this set?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $sets->links('pagination::bootstrap-5') }}
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.3;">📝</div>
                    <p class="text-muted mt-3">No question sets found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
