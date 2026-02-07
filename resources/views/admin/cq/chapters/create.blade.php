@extends('layouts.admin')

@section('title', 'Add Chapter')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>➕ Add Chapter to {{ $subject->subject_name }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cq.chapters.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="chapter_number" class="form-label">Chapter Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('chapter_number') is-invalid @enderror" 
                                           id="chapter_number" name="chapter_number" value="{{ old('chapter_number') }}" min="1" required>
                                    @error('chapter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="chapter_name" class="form-label">Chapter Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('chapter_name') is-invalid @enderror" 
                                           id="chapter_name" name="chapter_name" value="{{ old('chapter_name') }}" required>
                                    @error('chapter_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">✓ Add Chapter</button>
                            <a href="{{ route('admin.cq.chapters.index', $subject->id) }}" class="btn btn-secondary">← Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
