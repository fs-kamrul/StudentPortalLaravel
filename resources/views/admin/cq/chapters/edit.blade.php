@extends('layouts.admin')

@section('title', 'Edit Chapter')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>✏️ Edit Chapter</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cq.chapters.update', $chapter->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" value="{{ $chapter->subject->subject_name }}" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="chapter_number" class="form-label">Chapter Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('chapter_number') is-invalid @enderror" 
                                           id="chapter_number" name="chapter_number" value="{{ old('chapter_number', $chapter->chapter_number) }}" min="1" required>
                                    @error('chapter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="chapter_name" class="form-label">Chapter Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('chapter_name') is-invalid @enderror" 
                                           id="chapter_name" name="chapter_name" value="{{ old('chapter_name', $chapter->chapter_name) }}" required>
                                    @error('chapter_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $chapter->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $chapter->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $chapter->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">✓ Update Chapter</button>
                            <a href="{{ route('admin.cq.chapters.index', $chapter->subject_id) }}" class="btn btn-secondary">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
