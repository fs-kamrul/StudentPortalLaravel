@extends('layouts.admin')

@section('title', 'Edit Question Set')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>✏️ Edit Question Set: {{ $set->set_name }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Set Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cq.sets.update', $set->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" value="{{ $set->subject->subject_name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="set_name" class="form-label">Set Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('set_name') is-invalid @enderror" 
                                   id="set_name" name="set_name" value="{{ old('set_name', $set->set_name) }}" required>
                            @error('set_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exam_name" class="form-label">Exam Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                                   id="exam_name" name="exam_name" value="{{ old('exam_name', $set->exam_name) }}" required>
                            @error('exam_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exam_date" class="form-label">Exam Date</label>
                                    <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                           id="exam_date" name="exam_date" value="{{ old('exam_date', $set->exam_date ? $set->exam_date->format('Y-m-d') : '') }}">
                                    @error('exam_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration_minutes" class="form-label">Duration (Minutes)</label>
                                    <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                           id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $set->duration_minutes) }}" min="1">
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instructions</label>
                            <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                      id="instructions" name="instructions" rows="3">{{ old('instructions', $set->instructions) }}</textarea>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $set->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $set->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">✓ Update Set Details</button>
                            <a href="{{ route('admin.cq.sets.index') }}" class="btn btn-secondary">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Selected Questions</h5>
                    <a href="{{ route('admin.cq.sets.addQuestions', $set->id) }}" class="btn btn-sm btn-outline-primary">Edit List</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($set->questions as $question)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>Q{{ $loop->iteration }}.</strong> 
                                        <small class="text-muted d-block">{{ Str::limit($question->question_stem, 60) }}</small>
                                    </div>
                                    <span class="badge bg-secondary">{{ $question->total_marks }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4">
                                <p class="text-muted mb-0">No questions added yet</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
                @if($set->questions->count() > 0)
                <div class="card-footer bg-white text-end">
                    <strong>Total Marks: {{ $set->total_marks }}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
