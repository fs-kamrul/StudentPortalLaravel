@extends('layouts.admin')

@section('title', 'Edit CQ Subject')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>✏️ Edit CQ Subject</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cq.subjects.update', $subject->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="subject_name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject_name') is-invalid @enderror" 
                                   id="subject_name" name="subject_name" value="{{ old('subject_name', $subject->subject_name) }}" required>
                            @error('subject_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subject_code" class="form-label">Subject Code</label>
                                    <input type="text" class="form-control @error('subject_code') is-invalid @enderror" 
                                           id="subject_code" name="subject_code" value="{{ old('subject_code', $subject->subject_code) }}">
                                    @error('subject_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="class_level" class="form-label">Class Level</label>
                                    <input type="text" class="form-control @error('class_level') is-invalid @enderror" 
                                           id="class_level" name="class_level" value="{{ old('class_level', $subject->class_level) }}" 
                                           placeholder="e.g., Class 10, SSC, HSC">
                                    @error('class_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $subject->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $subject->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                ✓ Update Subject
                            </button>
                            <a href="{{ route('admin.cq.subjects.index') }}" class="btn btn-secondary">
                                ← Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
