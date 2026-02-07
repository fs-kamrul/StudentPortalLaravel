@extends('layouts.admin')

@section('title', 'Edit CQ Question')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>✏️ Edit CQ Question</h2>
            <p class="text-muted">Subject: {{ $question->chapter->subject->subject_name }} | Chapter: {{ $question->chapter->chapter_name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cq.questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="question_stem" class="form-label"><strong>Question Stem/নিয়োগ/অনুচ্ছেদ</strong> <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('question_stem') is-invalid @enderror" 
                                      id="question_stem" name="question_stem" rows="6" required>{{ old('question_stem', $question->question_stem) }}</textarea>
                            @error('question_stem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h5>Sub-Questions</h5>

                        <!-- Sub-question ক -->
                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="form-label"><strong>ক) Sub-question A</strong> <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('sub_question_a') is-invalid @enderror" 
                                                  name="sub_question_a" rows="2" required>{{ old('sub_question_a', $question->sub_question_a) }}</textarea>
                                        @error('sub_question_a')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_a_marks') is-invalid @enderror" 
                                               name="sub_question_a_marks" value="{{ old('sub_question_a_marks', $question->sub_question_a_marks) }}" min="0" required>
                                        @error('sub_question_a_marks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-question খ -->
                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="form-label"><strong>খ) Sub-question B</strong> <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('sub_question_b') is-invalid @enderror" 
                                                  name="sub_question_b" rows="2" required>{{ old('sub_question_b', $question->sub_question_b) }}</textarea>
                                        @error('sub_question_b')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_b_marks') is-invalid @enderror" 
                                               name="sub_question_b_marks" value="{{ old('sub_question_b_marks', $question->sub_question_b_marks) }}" min="0" required>
                                        @error('sub_question_b_marks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-question গ -->
                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="form-label"><strong>গ) Sub-question C</strong> <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('sub_question_c') is-invalid @enderror" 
                                                  name="sub_question_c" rows="2" required>{{ old('sub_question_c', $question->sub_question_c) }}</textarea>
                                        @error('sub_question_c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_c_marks') is-invalid @enderror" 
                                               name="sub_question_c_marks" value="{{ old('sub_question_c_marks', $question->sub_question_c_marks) }}" min="0" required>
                                        @error('sub_question_c_marks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-question ঘ (Optional) -->
                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="form-label"><strong>ঘ) Sub-question D</strong> (Optional)</label>
                                        <textarea class="form-control @error('sub_question_d') is-invalid @enderror" 
                                                  name="sub_question_d" rows="2">{{ old('sub_question_d', $question->sub_question_d) }}</textarea>
                                        @error('sub_question_d')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks</label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_d_marks') is-invalid @enderror" 
                                               name="sub_question_d_marks" value="{{ old('sub_question_d_marks', $question->sub_question_d_marks) }}" min="0">
                                        @error('sub_question_d_marks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="difficulty_level" class="form-label">Difficulty Level <span class="text-danger">*</span></label>
                                    <select class="form-select @error('difficulty_level') is-invalid @enderror" id="difficulty_level" name="difficulty_level" required>
                                        <option value="easy" {{ old('difficulty_level', $question->difficulty_level) == 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="medium" {{ old('difficulty_level', $question->difficulty_level) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="hard" {{ old('difficulty_level', $question->difficulty_level) == 'hard' ? 'selected' : '' }}>Hard</option>
                                    </select>
                                    @error('difficulty_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', $question->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $question->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">✓ Update Question</button>
                            <a href="{{ route('admin.cq.questions.index', $question->chapter_id) }}" class="btn btn-secondary">← Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
