@extends('layouts.admin')

@section('title', 'Question Bank')

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
                <h2>📚 Chapter-wise Question Bank</h2>
                <div>
                    <a href="{{ route('admin.cq.part_questions.create', ['subject_id' => $filterSubject, 'chapter_id' => $filterChapter]) }}" class="btn btn-primary">
                        ➕ Add New Question
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cq.part_questions.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $filterSubject == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="chapter_id" class="form-label">Chapter</label>
                    <select name="chapter_id" id="chapter_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Chapters</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}" {{ $filterChapter == $chapter->id ? 'selected' : '' }}>
                                {{ $chapter->chapter_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="question_type" class="form-label">Type</label>
                    <select name="question_type" id="question_type" class="form-select" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="knowledge" {{ $filterType == 'knowledge' ? 'selected' : '' }}>Knowledge-based (1)</option>
                        <option value="comprehension" {{ $filterType == 'comprehension' ? 'selected' : '' }}>Comprehension-based (2)</option>
                        <option value="application" {{ $filterType == 'application' ? 'selected' : '' }}>Application-based (3)</option>
                        <option value="higher_ability" {{ $filterType == 'higher_ability' ? 'selected' : '' }}>Higher Ability/Analysis (4)</option>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                    <a href="{{ route('admin.cq.part_questions.index') }}" class="btn btn-secondary px-4">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @forelse($questions as $question)
                <div class="question-row p-4 border-bottom position-relative">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <span class="badge {{ 
                                $question->question_type == 'knowledge' ? 'bg-info' : 
                                ($question->question_type == 'comprehension' ? 'bg-primary' : 
                                ($question->question_type == 'application' ? 'bg-warning text-dark' : 'bg-danger')) 
                            }}">
                                {{ $question->type_name }}
                            </span>
                            <span class="badge bg-secondary ms-1">Marks: {{ $question->marks }}</span>
                            <small class="text-muted ms-2">
                                {{ $question->chapter->subject->subject_name }} > {{ $question->chapter->chapter_name }}
                            </small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.cq.part_questions.edit', $question->id) }}" class="btn btn-outline-secondary">✏️ Edit</a>
                            <form action="{{ route('admin.cq.part_questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Move to trash?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">🗑️ Delete</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="question-text mb-3">
                        <strong>Q:</strong> {!! nl2br(e($question->question_text)) !!}
                    </div>
                    <div class="answer-text p-3 bg-light rounded shadow-inner mb-2" style="border-left: 4px solid #0d6efd;">
                        <strong>A:</strong> {!! nl2br(e($question->answer_text)) !!}
                    </div>
                    
                    <div class="text-end">
                        <small class="text-muted" style="font-size: 0.7rem;">Added: {{ $question->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div style="font-size: 3rem; opacity: 0.2;">📚</div>
                    <p class="text-muted mt-3">No questions found matching your criteria</p>
                    <a href="{{ route('admin.cq.part_questions.create') }}" class="btn btn-primary btn-sm">Add First Question</a>
                </div>
            @endforelse
        </div>
        <div class="card-footer bg-white py-3">
            {{ $questions->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
.question-row:hover { background-color: #f8f9fa; }
.answer-text { font-size: 0.95rem; line-height: 1.5; color: #444; }
.question-text { font-size: 1.05rem; }
.shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); }
</style>
@endsection
