@extends('layouts.admin')

@section('title', 'Student Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                        ← Back to List
                    </a>
                    <h2>Student Details</h2>
                </div>
                <a href="#" class="btn btn-warning">
                    <span>✏️</span> Edit Student
                </a>
            </div>
        </div>
    </div>

    <!-- Student Information -->
    <div class="row">
        <!-- Personal Information -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Student ID:</div>
                        <div class="col-7">{{ $student->id }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Name:</div>
                        <div class="col-7">{{ $student->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Roll:</div>
                        <div class="col-7">{{ $student->roll }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Gender:</div>
                        <div class="col-7">{{ $student->gender }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Date of Birth:</div>
                        <div class="col-7">{{ $student->birth_bate }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Blood Group:</div>
                        <div class="col-7">{{ $student->blood_group }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Religion:</div>
                        <div class="col-7">{{ $student->religion }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Nationality:</div>
                        <div class="col-7">{{ $student->nationality }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Birth Registration:</div>
                        <div class="col-7">{{ $student->birth_registration_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">National ID:</div>
                        <div class="col-7">{{ $student->national_id }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Academic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Class:</div>
                        <div class="col-7">{{ $student->class }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Section:</div>
                        <div class="col-7">{{ $student->section }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Group:</div>
                        <div class="col-7">{{ $student->group_r }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Year:</div>
                        <div class="col-7">{{ $student->year }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Join Date:</div>
                        <div class="col-7">{{ $student->join_date }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Student Phone:</div>
                        <div class="col-7">{{ $student->stu_phone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Mobile Number:</div>
                        <div class="col-7">{{ $student->mobile_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Email:</div>
                        <div class="col-7">{{ $student->email }}</div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">Permanent Address</h6>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Village:</div>
                        <div class="col-7">{{ $student->village }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Post:</div>
                        <div class="col-7">{{ $student->post }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Sub District:</div>
                        <div class="col-7">{{ $student->sub_district }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">District:</div>
                        <div class="col-7">{{ $student->district }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Division:</div>
                        <div class="col-7">{{ $student->division }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Zip Code:</div>
                        <div class="col-7">{{ $student->zip_code }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family Information -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Family Information</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Father's Information</h6>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Father's Name:</div>
                        <div class="col-7">{{ $student->father_name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Father's Phone:</div>
                        <div class="col-7">{{ $student->father_phone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Job Category:</div>
                        <div class="col-7">{{ $student->job_category }}</div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">Mother's Information</h6>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Mother's Name:</div>
                        <div class="col-7">{{ $student->mother_name }}</div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">Other</h6>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Marital Status:</div>
                        <div class="col-7">{{ $student->marital_status }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Yearly Income:</div>
                        <div class="col-7">{{ $student->yearly_income }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Previous Education -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Previous Education (SSC)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <strong>Previous School:</strong> {{ $student->previous_school_name }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>SSC Board:</strong> {{ $student->ssc_board }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>SSC Year:</strong> {{ $student->ssc_year }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>SSC Roll:</strong> {{ $student->ssc_roll }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>SSC Group:</strong> {{ $student->ssc_group }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>SSC Registration:</strong> {{ $student->ssc_registration }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>SSC GPA:</strong> {{ $student->ssc_gpa }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Previous Class:</strong> {{ $student->pre_class }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <strong>Previous GPA:</strong> {{ $student->pre_gpa }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
