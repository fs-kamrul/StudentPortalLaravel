@extends('layouts.admin')

@section('title', 'Add CQ Question')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>➕ Add CQ Question to {{ $chapter->chapter_name }}</h2>
            <p class="text-muted">Subject: {{ $chapter->subject->subject_name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cq.questions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
                        
                        <div class="mb-4">
                            <label for="question_stem" class="form-label"><strong>Question Stem/নিয়োগ/অনুচ্ছেদ</strong> <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('question_stem') is-invalid @enderror" 
                                      id="question_stem" name="question_stem" rows="6" required>{{ old('question_stem') }}</textarea>
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
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0"><strong>ক) Sub-question A</strong> <span class="text-danger">*</span></label>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="openBankModal('knowledge', 'sub_question_a')">
                                                🔍 Browse Bank
                                            </button>
                                        </div>
                                        <textarea class="form-control @error('sub_question_a') is-invalid @enderror" 
                                                  id="sub_question_a" name="sub_question_a" rows="2" required>{{ old('sub_question_a') }}</textarea>
                                        @error('sub_question_a')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_a_marks') is-invalid @enderror" 
                                               name="sub_question_a_marks" value="{{ old('sub_question_a_marks', 1) }}" min="0" required>
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
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0"><strong>খ) Sub-question B</strong> <span class="text-danger">*</span></label>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="openBankModal('comprehension', 'sub_question_b')">
                                                🔍 Browse Bank
                                            </button>
                                        </div>
                                        <textarea class="form-control @error('sub_question_b') is-invalid @enderror" 
                                                  id="sub_question_b" name="sub_question_b" rows="2" required>{{ old('sub_question_b') }}</textarea>
                                        @error('sub_question_b')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_b_marks') is-invalid @enderror" 
                                               name="sub_question_b_marks" value="{{ old('sub_question_b_marks', 2) }}" min="0" required>
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
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0"><strong>গ) Sub-question C</strong> <span class="text-danger">*</span></label>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="openBankModal('application', 'sub_question_c')">
                                                🔍 Browse Bank
                                            </button>
                                        </div>
                                        <textarea class="form-control @error('sub_question_c') is-invalid @enderror" 
                                                  id="sub_question_c" name="sub_question_c" rows="2" required>{{ old('sub_question_c') }}</textarea>
                                        @error('sub_question_c')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_c_marks') is-invalid @enderror" 
                                               name="sub_question_c_marks" value="{{ old('sub_question_c_marks', 3) }}" min="0" required>
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
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0"><strong>ঘ) Sub-question D</strong> (Optional)</label>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="openBankModal('higher_ability', 'sub_question_d')">
                                                🔍 Browse Bank
                                            </button>
                                        </div>
                                        <textarea class="form-control @error('sub_question_d') is-invalid @enderror" 
                                                  id="sub_question_d" name="sub_question_d" rows="2">{{ old('sub_question_d') }}</textarea>
                                        @error('sub_question_d')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Marks</label>
                                        <input type="number" step="0.01" class="form-control @error('sub_question_d_marks') is-invalid @enderror" 
                                               name="sub_question_d_marks" value="{{ old('sub_question_d_marks', 4) }}" min="0">
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
                                        <option value="easy" {{ old('difficulty_level') == 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="medium" {{ old('difficulty_level', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="hard" {{ old('difficulty_level') == 'hard' ? 'selected' : '' }}>Hard</option>
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
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">✓ Create Question</button>
                            <a href="{{ route('admin.cq.questions.index', $chapter->id) }}" class="btn btn-secondary">← Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question Bank Modal -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="bankModalLabel">📚 Browse Question Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="bankLoader" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Loading questions from bank...</p>
                </div>
                <div id="bankContent">
                    <!-- Questions will be loaded here via AJAX -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let activeTargetId = '';
    const bankModal = new bootstrap.Modal(document.getElementById('bankModal'));

    function openBankModal(type, targetId) {
        activeTargetId = targetId;
        const loader = document.getElementById('bankLoader');
        const content = document.getElementById('bankContent');
        
        loader.classList.remove('d-none');
        content.innerHTML = '';
        
        const chapterId = "{{ $chapter->id }}";
        const url = "{{ route('admin.cq.part_questions.api.search') }}?chapter_id=" + chapterId + "&question_type=" + type;

        bankModal.show();

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
                        <button type="button" class="list-group-item list-group-item-action" onclick="selectQuestion('${q.question_text.replace(/'/g, "\\'")}')">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-1 text-primary">Question:</h6>
                                <small class="badge bg-secondary">${q.marks} Marks</small>
                            </div>
                            <p class="mb-1 fw-bold">${q.question_text}</p>
                            <hr class="my-1">
                            <small class="text-muted"><strong>Answer hint:</strong> ${q.answer_text.substring(0, 100)}...</small>
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
    }

    function selectQuestion(text) {
        // Remove Ch-X, Set-X marker if present in seeded data
        const cleanText = text.replace(/\s\[Ch-\d+, Set-\d+\]$/, '');
        document.getElementById(activeTargetId).value = cleanText;
        bankModal.hide();
    }
</script>
@endpush
