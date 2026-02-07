@extends('layouts.admin')

@section('title', 'Chapters - ' . $subject->subject_name)

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
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>📑 Chapters: {{ $subject->subject_name }}</h2>
                    <p class="text-muted mb-0">Manage chapters for this subject</p>
                </div>
                <div>
                    <a href="{{ route('admin.cq.chapters.create', $subject->id) }}" class="btn btn-primary">
                        ➕ Add Chapter
                    </a>
                    <a href="{{ route('admin.cq.subjects.index') }}" class="btn btn-outline-secondary">
                        ← Back to Subjects
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($chapters->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Chapter #</th>
                                <th>Chapter Name</th>
                                <th>Questions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $chapter)
                                <tr>
                                    <td><strong>{{ $chapter->chapter_number }}</strong></td>
                                    <td>{{ $chapter->chapter_name }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $chapter->questions_count }} questions</span>
                                    </td>
                                    <td>
                                        @if($chapter->status == 'active')
                                            <span class="badge bg-success">✓ Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.cq.questions.index', $chapter->id) }}" class="btn btn-outline-primary">
                                                📝 Questions
                                            </a>
                                            <a href="{{ route('admin.cq.chapters.edit', $chapter->id) }}" class="btn btn-outline-secondary">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('admin.cq.chapters.destroy', $chapter->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this chapter?');">
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
                {{ $chapters->links('pagination::bootstrap-5') }}
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.3;">📑</div>
                    <p class="text-muted mt-3">No chapters found for this subject</p>
                   <a href="{{ route('admin.cq.chapters.create', $subject->id) }}" class="btn btn-primary mt-2">
                        ➕ Add First Chapter
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
