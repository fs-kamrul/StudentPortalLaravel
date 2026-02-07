@extends('layouts.admin')

@section('title', 'Set Q&A Preview')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2>📝 Q&A Board (Questions + Answers)</h2>
                <p class="text-muted">Set: {{ $set->set_name }} | Subject: {{ $set->subject->subject_name }}</p>
            </div>
            <div class="d-print-none">
                <button onclick="window.print()" class="btn btn-primary">
                    🖨️ Print
                </button>
                <a href="{{ route('admin.cq.sets.index') }}" class="btn btn-outline-secondary">
                    ← Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- The Q&A Document -->
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 900px; padding: 40px; background-color: white;">
        <div class="exam-header text-center mb-4 pb-3 border-bottom">
            <h2 class="mb-1 text-uppercase">{{ $set->exam_name }}</h2>
            <h4 class="mb-2">{{ $set->subject->subject_name }} - Solution Paper</h4>
            <div class="d-flex justify-content-center gap-4 mt-3">
                <div><strong>Set ID:</strong> #{{ $set->id }}</div>
                <div><strong>Total Marks:</strong> {{ $set->total_marks }}</div>
                <div><strong>Date:</strong> {{ date('d M, Y') }}</div>
            </div>
        </div>

        <div class="exam-body">
            @forelse($set->questions->sortBy('pivot.question_order') as $question)
                <div class="question-answer-block mb-5 pb-4 border-bottom">
                    <div class="d-flex mb-3">
                        <div class="fw-bold pe-2" style="font-size: 1.25rem;">{{ $loop->iteration }}.</div>
                        <div class="flex-grow-1">
                            <div class="question-stem mb-3 text-justify fw-bold">
                                {!! nl2br(e($question->question_stem)) !!}
                            </div>

                            <!-- Part A -->
                            <div class="part-container mb-4">
                                <div class="d-flex justify-content-between align-items-start mb-2 bg-light p-2 rounded">
                                    <div class="fw-bold">ক) {{ $question->sub_question_a }}</div>
                                    <span class="badge bg-secondary">{{ intval($question->sub_question_a_marks) }}</span>
                                </div>
                                <div class="answer-box ps-4 py-2 text-success">
                                    <strong>উত্তর:</strong> 
                                    @if($question->subQuestionA)
                                        {!! nl2br(e($question->subQuestionA->answer_text)) !!}
                                    @else
                                        <span class="text-muted italic">No linked answer found in bank.</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Part B -->
                            <div class="part-container mb-4">
                                <div class="d-flex justify-content-between align-items-start mb-2 bg-light p-2 rounded">
                                    <div class="fw-bold">খ) {{ $question->sub_question_b }}</div>
                                    <span class="badge bg-secondary">{{ intval($question->sub_question_b_marks) }}</span>
                                </div>
                                <div class="answer-box ps-4 py-2 text-success">
                                    <strong>উত্তর:</strong> 
                                    @if($question->subQuestionB)
                                        {!! nl2br(e($question->subQuestionB->answer_text)) !!}
                                    @else
                                        <span class="text-muted italic">No linked answer found in bank.</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Part C -->
                            <div class="part-container mb-4">
                                <div class="d-flex justify-content-between align-items-start mb-2 bg-light p-2 rounded">
                                    <div class="fw-bold">গ) {{ $question->sub_question_c }}</div>
                                    <span class="badge bg-secondary">{{ intval($question->sub_question_c_marks) }}</span>
                                </div>
                                <div class="answer-box ps-4 py-2 text-success">
                                    <strong>উত্তর:</strong> 
                                    @if($question->subQuestionC)
                                        {!! nl2br(e($question->subQuestionC->answer_text)) !!}
                                    @else
                                        <span class="text-muted italic">No linked answer found in bank.</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Part D -->
                            @if($question->sub_question_d)
                            <div class="part-container">
                                <div class="d-flex justify-content-between align-items-start mb-2 bg-light p-2 rounded">
                                    <div class="fw-bold">ঘ) {{ $question->sub_question_d }}</div>
                                    <span class="badge bg-secondary">{{ intval($question->sub_question_d_marks) }}</span>
                                </div>
                                <div class="answer-box ps-4 py-2 text-success">
                                    <strong>উত্তর:</strong> 
                                    @if($question->subQuestionD)
                                        {!! nl2br(e($question->subQuestionD->answer_text)) !!}
                                    @else
                                        <span class="text-muted italic">No linked answer found in bank.</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center">
                    No questions added to this set yet.
                </div>
            @endforelse
        </div>

        <div class="exam-footer text-center mt-4 text-muted small d-none d-print-block">
            Generated by StudentPortal Solution Module
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .card, .card * { visibility: visible; }
    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .d-print-none { display: none !important; }
    .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; }
    .badge { border: 1px solid #6c757d !important; color: black !important; }
}
.question-stem { font-size: 1.15rem; line-height: 1.5; }
.answer-box { 
    border-left: 3px solid #198754;
    margin-top: 5px;
    background-color: #f9fffb;
    border-radius: 0 5px 5px 0;
}
.text-justify { text-align: justify; }
.italic { font-style: italic; }
</style>
@endsection
