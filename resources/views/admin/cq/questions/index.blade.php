@extends('layouts.admin')

@section('title', 'CQ Questions')

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
                <div>
                    <h2>📝 Questions: {{ $chapter->chapter_name }}</h2>
                    <p class="text-muted mb-0">Subject: {{ $chapter->subject->subject_name }} | Chapter {{ $chapter->chapter_number }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.cq.questions.create', $chapter->id) }}" class="btn btn-primary">
                        ➕ Add Question
                    </a>
                    <a href="{{ route('admin.cq.chapters.index', $chapter->subject_id) }}" class="btn btn-outline-secondary">
                        ← Back to Chapters
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($questions->count() > 0)
                @foreach($questions as $question)
                <div class="card mb-3 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="badge bg-secondary mb-2">{{ ucfirst($question->difficulty_level) }}</div>
                                <div class="badge bg-info mb-2">Total: {{ $question->total_marks }} marks</div>
                                <div class="small text-muted mb-2">{!! nl2br(e(Str::limit($question->question_stem, 150))) !!}</div>
                            </div>
                            <div class="btn-group btn-group-sm ms-2" role="group">
                                <a href="{{ route('admin.cq.questions.show', $question->id) }}" class="btn btn-outline-info">
                                    👁️ View
                                </a>
                                <a href="{{ route('admin.cq.questions.edit', $question->id) }}" class="btn btn-outline-secondary">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.cq.questions.destroy', $question->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $questions->links('pagination::bootstrap-5') }}
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.3;">📝</div>
                    <p class="text-muted mt-3">No questions found for this chapter</p>
                    <a href="{{ route('admin.cq.questions.create', $chapter->id) }}" class="btn btn-primary mt-2">
                        ➕ Add First Question
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
