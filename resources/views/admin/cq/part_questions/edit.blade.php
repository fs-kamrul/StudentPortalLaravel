@extends('layouts.admin')

@section('title', 'Edit Question - Question Bank')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>✏️ Edit Question & Answer</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.cq.part_questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" value="{{ $question->chapter->subject->subject_name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="chapter_id" class="form-label">Chapter <span class="text-danger">*</span></label>
                                <select name="chapter_id" id="chapter_id" class="form-select @error('chapter_id') is-invalid @enderror" required>
                                    @foreach($chapters as $chapter)
                                        <option value="{{ $chapter->id }}" {{ old('chapter_id', $question->chapter_id) == $chapter->id ? 'selected' : '' }}>
                                            {{ $chapter->chapter_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('chapter_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="question_type" class="form-label">Question Type <span class="text-danger">*</span></label>
                                <select name="question_type" id="question_type" class="form-select @error('question_type') is-invalid @enderror" required>
                                    <option value="knowledge" {{ old('question_type', $question->question_type) == 'knowledge' ? 'selected' : '' }}>Knowledge-based (1 Mark)</option>
                                    <option value="comprehension" {{ old('question_type', $question->question_type) == 'comprehension' ? 'selected' : '' }}>Comprehension-based (2 Marks)</option>
                                    <option value="application" {{ old('question_type', $question->question_type) == 'application' ? 'selected' : '' }}>Application-based (3 Marks)</option>
                                    <option value="higher_ability" {{ old('question_type', $question->question_type) == 'higher_ability' ? 'selected' : '' }}>Higher Ability/Analysis (4 Marks)</option>
                                </select>
                                @error('question_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status', $question->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $question->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="question_text" class="form-label">Question Text <span class="text-danger">*</span></label>
                            <textarea name="question_text" id="question_text" class="form-control @error('question_text') is-invalid @enderror" 
                                      rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                            @error('question_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="answer_text" class="form-label">Answer Text <span class="text-danger">*</span></label>
                            <textarea name="answer_text" id="answer_text" class="form-control @error('answer_text') is-invalid @enderror" 
                                      rows="5" required>{{ old('answer_text', $question->answer_text) }}</textarea>
                            @error('answer_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">✓ Update Question</button>
                            <a href="{{ route('admin.cq.part_questions.index', ['chapter_id' => $question->chapter_id]) }}" class="btn btn-secondary">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
