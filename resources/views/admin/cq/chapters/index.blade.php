@extends('layouts.admin')

@section('title', 'Chapters - ' . $subject->subject_name)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>📑 Chapters: {{ $subject->subject_name }}</h2>
                    <p class="text-muted mb-0">Manage chapters for this subject</p>
                </div>
                <div>
                    <a href="{{ route('admin.cq.chapters.create', $subject->id) }}" class="btn btn-primary">
                        ➕ Add Chapter
                    </a>
                    <a href="{{ route('admin.cq.subjects.index') }}" class="btn btn-outline-secondary">
                        ← Back to Subjects
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form id="bulk-delete-form" action="{{ route('admin.cq.chapters.bulkDelete') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                @if($chapters->count() > 0)
                    <div id="bulk-actions-bar" class="alert alert-secondary d-none mb-3 d-flex justify-content-between align-items-center py-2">
                        <span id="selected-count-msg" class="fw-bold">0 chapters selected</span>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected chapters? Empty chapters (no questions) will be deleted.')">
                            🗑️ Delete Selected
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="select-all">
                                    </th>
                                    <th style="width: 100px;">Chapter #</th>
                                    <th>Chapter Name</th>
                                    <th>Questions</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chapters as $chapter)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $chapter->id }}" class="form-check-input chapter-checkbox">
                                        </td>
                                        <td><strong>{{ $chapter->chapter_number }}</strong></td>
                                        <td>{{ $chapter->chapter_name }}</td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <span class="badge bg-info">{{ $chapter->questions_count }} CQs</span>
                                                <span class="badge bg-primary">{{ $chapter->part_questions_count }} QBank items</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($chapter->status == 'active')
                                                <span class="badge bg-success">✓ Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.cq.questions.index', $chapter->id) }}" class="btn btn-outline-primary">
                                                    📝 Questions
                                                </a>
                                                <a href="{{ route('admin.cq.part_questions.index', ['subject_id' => $subject->id, 'chapter_id' => $chapter->id]) }}" class="btn btn-outline-info" title="View in Question Bank">
                                                    📚 QBank
                                                </a>
                                                <a href="{{ route('admin.cq.part_questions.create', ['chapter_id' => $chapter->id]) }}" class="btn btn-info text-white" title="Add to Question Bank">
                                                    +
                                                </a>
                                                <a href="{{ route('admin.cq.chapters.edit', $chapter->id) }}" class="btn btn-outline-secondary">
                                                    ✏️ Edit
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmSingleDelete({{ $chapter->id }})">🗑️</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $chapters->links('pagination::bootstrap-5') }}
                @else
                    <div class="text-center py-5">
                        <div style="font-size: 3rem; opacity: 0.3;">📑</div>
                        <p class="text-muted mt-3">No chapters found for this subject</p>
                       <a href="{{ route('admin.cq.chapters.create', $subject->id) }}" class="btn btn-primary mt-2">
                            ➕ Add First Chapter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <!-- Single Delete Form (Hidden) -->
    <form id="single-delete-form" action="" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.chapter-checkbox');
        const actionBar = document.getElementById('bulk-actions-bar');
        const selectedCountMsg = document.getElementById('selected-count-msg');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                toggleActionBar();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', toggleActionBar);
        });

        function toggleActionBar() {
            const checkedCount = document.querySelectorAll('.chapter-checkbox:checked').length;
            if (checkedCount > 0) {
                actionBar.classList.remove('d-none');
                selectedCountMsg.textContent = checkedCount + ' chapters selected';
            } else {
                actionBar.classList.add('d-none');
                if (selectAll) selectAll.checked = false;
            }
        }
    });

    function confirmSingleDelete(id) {
        if (confirm('Delete this chapter?')) {
            const form = document.getElementById('single-delete-form');
            form.action = "{{ route('admin.cq.chapters.destroy', 'ID_PLACEHOLDER') }}".replace('ID_PLACEHOLDER', id);
            form.submit();
        }
    }
</script>
@endpush
