@extends('layouts.admin')

@section('title', 'Add Questions to Set')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>➕ Select Questions: {{ $set->set_name }}</h2>
                    <p class="text-muted">Subject: {{ $set->subject->subject_name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.cq.sets.edit', $set->id) }}" class="btn btn-outline-secondary">
                        ← Back to Set
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.cq.sets.storeQuestions', $set->id) }}" method="POST">
        @csrf
        <div class="row">
            <!-- Available Questions column -->
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Available Questions</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th style="width: 40px;">Select</th>
                                        <th>Chapter & Stem</th>
                                        <th style="width: 80px;">Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $currentChapter = null; @endphp
                                    @foreach($availableQuestions as $question)
                                        @if($currentChapter != $question->chapter->chapter_name)
                                            <tr class="table-secondary">
                                                <td colspan="3"><strong>Chapter {{ $question->chapter->chapter_number }}: {{ $question->chapter->chapter_name }}</strong></td>
                                            </tr>
                                            @php $currentChapter = $question->chapter->chapter_name; @endphp
                                        @endif
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input question-checkbox" type="checkbox" 
                                                           name="questions[]" value="{{ $question->id }}" id="q{{ $question->id }}"
                                                           {{ $set->questions->contains($question->id) ? 'checked' : '' }}
                                                           data-marks="{{ $question->total_marks }}"
                                                           data-stem="{{ Str::limit($question->question_stem, 100) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <label class="form-check-label w-100" for="q{{ $question->id }}">
                                                    <small class="text-muted d-block">ID: #{{ $question->id }} | {{ ucfirst($question->difficulty_level) }}</small>
                                                    {{ Str::limit($question->question_stem, 150) }}
                                                </label>
                                            </td>
                                            <td><span class="badge bg-secondary">{{ $question->total_marks }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selection summary and Ordering column -->
            <div class="col-lg-5">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Selected Questions</h5>
                        <span id="total-selected-marks" class="badge bg-light text-primary">0 marks</span>
                    </div>
                    <div class="card-body">
                        <div id="no-selection-msg" class="text-center py-4 {{ $set->questions->count() > 0 ? 'd-none' : '' }}">
                            <p class="text-muted">No questions selected yet</p>
                        </div>
                        
                        <div id="selection-list" class="mb-3">
                            <!-- Dynamic items will be added here via JS -->
                            @foreach($set->questions as $index => $question)
                                <div class="card mb-2 border-primary border-start border-4 selected-q-item" id="selected-list-q{{ $question->id }}">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <small class="text-primary fw-bold">Question {{ $loop->iteration }}</small>
                                                <p class="mb-0 small text-truncate" style="max-width: 250px;">{{ $question->question_stem }}</p>
                                            </div>
                                            <div class="ms-2">
                                                <input type="number" name="orders[{{ $question->id }}]" value="{{ $question->pivot->question_order ?? $loop->iteration }}" 
                                                       class="form-control form-control-sm text-center" style="width: 50px;" title="Order">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary w-100 d-flex justify-content-between align-items-center">
                            <span>Save Question Set</span>
                            <span class="badge bg-white text-primary" id="selected-count">{{ $set->questions->count() }} items</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.question-checkbox');
    const selectionList = document.getElementById('selection-list');
    const noSelectionMsg = document.getElementById('no-selection-msg');
    const totalMarksSpan = document.getElementById('total-selected-marks');
    const selectedCountSpan = document.getElementById('selected-count');

    function updateSummary() {
        let totalMarks = 0;
        let count = 0;
        const checked = document.querySelectorAll('.question-checkbox:checked');
        
        checked.forEach(cb => {
            totalMarks += parseFloat(cb.dataset.marks);
            count++;
        });

        totalMarksSpan.textContent = totalMarks.toFixed(2) + ' marks';
        selectedCountSpan.textContent = count + ' items';
        
        if (count > 0) {
            noSelectionMsg.classList.add('d-none');
        } else {
            noSelectionMsg.classList.remove('d-none');
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const qId = this.value;
            const stem = this.dataset.stem;
            
            if (this.checked) {
                // Add to list
                const idx = document.querySelectorAll('.selected-q-item').length + 1;
                const html = `
                    <div class="card mb-2 border-primary border-start border-4 selected-q-item" id="selected-list-q${qId}">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <small class="text-primary fw-bold">Added</small>
                                    <p class="mb-0 small text-truncate" style="max-width: 250px;">${stem}</p>
                                </div>
                                <div class="ms-2">
                                    <input type="number" name="orders[${qId}]" value="${idx}" 
                                           class="form-control form-control-sm text-center" style="width: 50px;" title="Order">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                selectionList.insertAdjacentHTML('beforeend', html);
            } else {
                // Remove from list
                const item = document.getElementById(`selected-list-q${qId}`);
                if (item) item.remove();
            }
            updateSummary();
        });
    });

    // Initial load
    updateSummary();
});
</script>
@endpush
@endsection
