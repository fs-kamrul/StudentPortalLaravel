@extends('layouts.admin')

@section('title', 'View Question')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>👁️ View Question</h2>
                    <p class="text-muted">{{ $question->chapter->subject->subject_name }} - {{ $question->chapter->chapter_name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.cq.questions.edit', $question->id) }}" class="btn btn-outline-primary">
                        ✏️ Edit
                    </a>
                    <a href="{{ route('admin.cq.questions.index', $question->chapter_id) }}" class="btn btn-outline-secondary">
                        ← Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <div class="d-flex gap-2 mb-2">
                    <span class="badge bg-secondary">{{ ucfirst($question->difficulty_level) }}</span>
                    <span class="badge bg-info">Total: {{ $question->total_marks }} marks</span>
                    <span class="badge bg-{{ $question->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($question->status) }}
                    </span>
                </div>
                <div class="p-3 bg-light rounded">
                    <strong>Question Stem/অনুচ্ছেদ:</strong>
                    <div class="mt-2">{!! nl2br(e($question->question_stem)) !!}</div>
                </div>
            </div>

            <hr>

            <!-- Sub-questions -->
            <div class="mb-3">
                <h5>Sub-Questions:</h5>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>ক)</strong> {!! nl2br(e($question->sub_question_a)) !!}
                            </div>
                            <div><span class="badge bg-primary">{{ $question->sub_question_a_marks }} marks</span></div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>খ)</strong> {!! nl2br(e($question->sub_question_b)) !!}
                            </div>
                            <div><span class="badge bg-primary">{{ $question->sub_question_b_marks }} marks</span></div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>গ)</strong> {!! nl2br(e($question->sub_question_c)) !!}
                            </div>
                            <div><span class="badge bg-primary">{{ $question->sub_question_c_marks }} marks</span></div>
                        </div>
                    </div>
                </div>

                @if($question->sub_question_d)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>ঘ)</strong> {!! nl2br(e($question->sub_question_d)) !!}
                            </div>
                            <div><span class="badge bg-primary">{{ $question->sub_question_d_marks }} marks</span></div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
