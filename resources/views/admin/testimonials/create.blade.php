@extends('layouts.admin')

@section('title', 'Create Testimonial')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Create New Testimonial</h2>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                    ← Back to Testimonials
                </a>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.testimonials.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Student Selection -->
                    <div class="col-md-6 mb-3">
                        <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" 
                                    data-registration="{{ $student->registration_id ?? '' }}"
                                    data-roll="{{ $student->roll ?? '' }}"
                                    data-gpa="{{ $student->gpa ?? '' }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name ?? $student->id }} (ID: {{ $student->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Registration ID -->
                    <div class="col-md-6 mb-3">
                        <label for="registration_id" class="form-label">Registration ID <span class="text-danger">*</span></label>
                        <input type="text" name="registration_id" id="registration_id" 
                            class="form-control @error('registration_id') is-invalid @enderror" 
                            value="{{ old('registration_id') }}" required>
                        @error('registration_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Roll Number -->
                    <div class="col-md-6 mb-3">
                        <label for="roll" class="form-label">Roll Number <span class="text-danger">*</span></label>
                        <input type="text" name="roll" id="roll" 
                            class="form-control @error('roll') is-invalid @enderror" 
                            value="{{ old('roll') }}" required>
                        @error('roll')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- GPA -->
                    <div class="col-md-6 mb-3">
                        <label for="gpa" class="form-label">GPA <span class="text-danger">*</span></label>
                        <input type="number" name="gpa" id="gpa" step="0.01" min="0" max="5" 
                            class="form-control @error('gpa') is-invalid @enderror" 
                            value="{{ old('gpa') }}" required>
                        @error('gpa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Enter GPA between 0.00 and 5.00</small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Testimonial Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Payment Status -->
                    <div class="col-md-6 mb-3">
                        <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                        <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                            <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Payment Amount -->
                    <div class="col-md-6 mb-3">
                        <label for="payment_amount" class="form-label">Payment Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" name="payment_amount" id="payment_amount" step="0.01" min="0" 
                                class="form-control @error('payment_amount') is-invalid @enderror" 
                                value="{{ old('payment_amount', 100.00) }}" required>
                        </div>
                        @error('payment_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-6 mb-3">
                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                            <option value="bkash" {{ old('payment_method', 'bkash') == 'bkash' ? 'selected' : '' }}>Bkash</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bkash Transaction ID -->
                    <div class="col-md-6 mb-3">
                        <label for="bkash_transaction_id" class="form-label">Bkash Transaction ID</label>
                        <input type="text" name="bkash_transaction_id" id="bkash_transaction_id" 
                            class="form-control @error('bkash_transaction_id') is-invalid @enderror" 
                            value="{{ old('bkash_transaction_id') }}"
                            placeholder="Optional">
                        @error('bkash_transaction_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bkash Phone Number -->
                    <div class="col-md-6 mb-3">
                        <label for="bkash_phone_number" class="form-label">Bkash Phone Number</label>
                        <input type="text" name="bkash_phone_number" id="bkash_phone_number" 
                            class="form-control @error('bkash_phone_number') is-invalid @enderror" 
                            value="{{ old('bkash_phone_number') }}"
                            placeholder="Optional">
                        @error('bkash_phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="col-12 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" 
                            class="form-control @error('remarks') is-invalid @enderror" 
                            placeholder="Optional notes or comments">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<!-- Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 on student dropdown
    $('#student_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search by Student ID or Name',
        allowClear: true,
        width: '100%',
        matcher: function(params, data) {
            // If there are no search terms, return all data
            if ($.trim(params.term) === '') {
                return data;
            }
            
            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }
            
            // Search in both text (name) and student ID
            var searchTerm = params.term.toLowerCase();
            var text = data.text.toLowerCase();
            var studentId = $(data.element).val().toLowerCase();
            
            // Check if search term matches either the text or student ID
            if (text.indexOf(searchTerm) > -1 || studentId.indexOf(searchTerm) > -1) {
                return data;
            }
            
            return null;
        }
    });
    
    // Auto-fill registration and roll when student is selected
    $('#student_id').on('select2:select', function(e) {
        const selectedOption = e.params.data.element;
        
        if (selectedOption) {
            // Auto-fill registration ID
            const registrationId = $(selectedOption).attr('data-registration');
            if (registrationId) {
                $('#registration_id').val(registrationId);
            }
            
            // Auto-fill roll
            const roll = $(selectedOption).attr('data-roll');
            if (roll) {
                $('#roll').val(roll);
            }
            
            // Auto-fill GPA
            const gpa = $(selectedOption).attr('data-gpa');
            if (gpa) {
                $('#gpa').val(gpa);
            }
        }
    });
    
    // Clear fields when selection is cleared
    $('#student_id').on('select2:clear', function() {
        $('#registration_id').val('');
        $('#roll').val('');
        $('#gpa').val('');
    });
});
</script>
@endpush
@endsection
