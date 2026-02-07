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

    <ul class="nav nav-pills mb-4 bg-light p-2 rounded" id="questionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="manual-tab" data-bs-toggle="pill" data-bs-target="#manual-picker" type="button" role="tab">
                📋 Select Existing CQs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="builder-tab" data-bs-toggle="pill" data-bs-target="#bank-builder" type="button" role="tab">
                🏗️ Build New CQ from Bank
            </button>
        </li>
    </ul>

    <div class="tab-content" id="questionTabsContent">
        <!-- Tab 1: Manual Picker -->
        <div class="tab-pane fade show active" id="manual-picker" role="tabpanel">
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

                    <!-- Selection summary column -->
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

        <!-- Tab 2: Bank Builder -->
        <div class="tab-pane fade" id="bank-builder" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">🏗️ Construct Creative Question</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.cq.sets.buildCq', $set->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label"><strong>1. Select Chapter</strong></label>
                                    <select name="chapter_id" id="builder_chapter_id" class="form-select" required>
                                        <option value="">-- Choose Chapter --</option>
                                        @foreach($allChapters as $chap)
                                            <option value="{{ $chap->id }}">Chapter {{ $chap->chapter_number }}: {{ $chap->chapter_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>2. Question Stem (পঠিত অনুচ্ছেদ/উদ্দীপক)</strong></label>
                                    <textarea name="question_stem" class="form-control" rows="4" placeholder="Enter the main passage here..." required></textarea>
                                </div>

                                <div class="row g-3">
                                    <!-- Slot ক -->
                                    <div class="col-12">
                                        <div class="p-3 border rounded bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="fw-bold mb-0 text-primary">ক) ক-অংশ (Knowledge - 1 Mark)</label>
                                                <button type="button" class="btn btn-sm btn-info text-white" onclick="openBuilderBankModal('knowledge', 'sub_question_a')">🔍 Browse Bank</button>
                                            </div>
                                            <textarea name="sub_question_a" id="builder_sub_question_a" class="form-control form-control-sm" rows="1" required></textarea>
                                        </div>
                                    </div>
                                    <!-- Slot খ -->
                                    <div class="col-12">
                                        <div class="p-3 border rounded bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="fw-bold mb-0 text-primary">খ) খ-অংশ (Comprehension - 2 Marks)</label>
                                                <button type="button" class="btn btn-sm btn-info text-white" onclick="openBuilderBankModal('comprehension', 'sub_question_b')">🔍 Browse Bank</button>
                                            </div>
                                            <textarea name="sub_question_b" id="builder_sub_question_b" class="form-control form-control-sm" rows="1" required></textarea>
                                        </div>
                                    </div>
                                    <!-- Slot গ -->
                                    <div class="col-12">
                                        <div class="p-3 border rounded bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="fw-bold mb-0 text-primary">গ) গ-অংশ (Application - 3 Marks)</label>
                                                <button type="button" class="btn btn-sm btn-info text-white" onclick="openBuilderBankModal('application', 'sub_question_c')">🔍 Browse Bank</button>
                                            </div>
                                            <textarea name="sub_question_c" id="builder_sub_question_c" class="form-control form-control-sm" rows="1" required></textarea>
                                        </div>
                                    </div>
                                    <!-- Slot ঘ -->
                                    <div class="col-12">
                                        <div class="p-3 border rounded bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="fw-bold mb-0 text-primary">ঘ) ঘ-অংশ (Higher Ability - 4 Marks)</label>
                                                <button type="button" class="btn btn-sm btn-info text-white" onclick="openBuilderBankModal('higher_ability', 'sub_question_d')">🔍 Browse Bank</button>
                                            </div>
                                            <textarea name="sub_question_d" id="builder_sub_question_d" class="form-control form-control-sm" rows="1"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Difficulty</label>
                                        <select name="difficulty_level" class="form-select">
                                            <option value="easy">Easy</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="hard">Hard</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="submit" class="btn btn-success w-100">🚀 Build and Add to Set</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="alert alert-info">
                        <h5>💡 Construction Tips</h5>
                        <ul class="mb-0 small">
                            <li>Select a **Chapter** first to load relevant bank items.</li>
                            <li>Write a creative **Stem** that connects all four parts.</li>
                            <li>You can either type questions manually or **Browse Bank** to reuse existing items.</li>
                            <li>Once built, the question will be saved to the database and added to this set.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Builder Bank Modal -->
<div class="modal fade" id="builderBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">📚 Pick from Bank</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="builderBankLoader" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
                <div id="builderBankContent"></div>
            </div>
        </div>
    </div>
</div>
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

    // CQ Builder Logic
    const builderBankModal = new bootstrap.Modal(document.getElementById('builderBankModal'));
    let builderActiveTargetId = '';

    window.openBuilderBankModal = function(type, targetId) {
        const chapterId = document.getElementById('builder_chapter_id').value;
        if (!chapterId) {
            alert('Please select a chapter first to load relevant questions.');
            return;
        }

        builderActiveTargetId = targetId;
        const loader = document.getElementById('builderBankLoader');
        const content = document.getElementById('builderBankContent');
        
        loader.classList.remove('d-none');
        content.innerHTML = '';
        builderBankModal.show();

        const url = "{{ route('admin.cq.part_questions.api.search') }}?chapter_id=" + chapterId + "&question_type=" + type;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                loader.classList.add('d-none');
                if (data.length === 0) {
                    content.innerHTML = '<div class="alert alert-warning">No questions of this type found for this chapter in the bank.</div>';
                    return;
                }

                let html = '<div class="list-group">';
                data.forEach(q => {
                    html += `
                        <button type="button" class="list-group-item list-group-item-action" onclick="selectBuilderQuestion('${q.question_text.replace(/'/g, "\\'")}')">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-1 text-primary">Question:</h6>
                                <small class="badge bg-secondary">${q.marks} Marks</small>
                            </div>
                            <p class="mb-1 fw-bold">${q.question_text}</p>
                        </button>
                    `;
                });
                html += '</div>';
                content.innerHTML = html;
            })
            .catch(error => {
                loader.classList.add('d-none');
                content.innerHTML = '<div class="alert alert-danger">Error loading questions.</div>';
                console.error('Error:', error);
            });
    };

    window.selectBuilderQuestion = function(text) {
        // Improved regex to handle various metadata formats like [Ch-1, Set-1] or (Chapter 1, Set 5)
        const cleanText = text.replace(/\s?(\[Ch-\d+, Set-\d+\]|\(Chapter \d+, Set \d+\))$/i, '');
        document.getElementById('builder_' + builderActiveTargetId).value = cleanText;
        builderBankModal.hide();
    };
});
</script>
@endpush
@endsection
