@extends('layouts.student')

@section('title', 'Result Search - StudentPortal')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h1 class="h3 text-primary mb-2">🎯 Search Result</h1>
            <p class="text-muted mb-0">Enter your details to view your exam results</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.result.show') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="studentID" class="form-label">Student ID</label>
                            <input type="text" 
                                   class="form-control @error('studentID') is-invalid @enderror" 
                                   id="studentID" 
                                   name="studentID" 
                                   value="{{ $student->id }}" 
                                   readonly>
                            @error('studentID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="session" class="form-label">Session / Year <span class="text-danger">*</span></label>
                            <select class="form-select @error('session') is-invalid @enderror" 
                                    id="session" 
                                    name="session" 
                                    required>
                                <option value="">-- Select Session --</option>
                                @foreach($options['sessions'] as $session)
                                    <option value="{{ $session }}" {{ old('session') == $session ? 'selected' : '' }}>
                                        {{ $session }}
                                    </option>
                                @endforeach
                            </select>
                            @error('session')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="exam" class="form-label">Exam Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('exam') is-invalid @enderror" 
                                    id="exam" 
                                    name="exam" 
                                    required>
                                <option value="">-- Select Exam Type --</option>
                                @foreach($options['exam_types'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('exam') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                🔍 Search Result
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
