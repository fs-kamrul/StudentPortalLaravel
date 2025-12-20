@extends('layouts.student')

@section('title', 'Result - StudentPortal')

@section('content')
<div class="container-fluid bg-white p-4">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-uppercase mb-1" style="color: #0d47a1; font-size: 24px;">{{ $school->s_name ?? 'School Name' }}</h2>
        <h4 class="fw-bold" style="color: #556b2f; font-size: 16px;">Academic Transcript of Terminal Examination</h4>
    </div>

    <!-- Info Section -->
    <div class="row mb-4 align-items-start">
        <!-- Student Info -->
        <div class="col-md-5">
            <table class="table table-borderless table-sm student-info-table">
                <tr>
                    <td class="fw-bold" style="width: 100px;">Name:</td>
                    <td>{{ $resultsite->name }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Student ID:</td>
                    <td>{{ $resultsite->id }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Class:</td>
                    <td>{{ $resultsite->class }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Year:</td>
                    <td>{{ $resultsite->year }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Group:</td>
                    <td>{{ $resultsite->group_r }}</td>
                </tr>
            </table>
        </div>

        <!-- Logo Center -->
        <div class="col-md-2 text-center">
         {{-- @if($school && $school->logo) --}}
              {{-- <img src="{{ asset('uploads/school_logo/' . $school->logo) }}" alt="School Logo" class="img-fluid" style="max-height: 80px;"> --}}
            {{-- @else --}}
                <img src="{{ asset('images/logo.png') }}" alt="School Logo" class="img-fluid" style="max-height: 80px;">
            {{-- @endif --}}
            
            <div class="mt-3">
                <div class="row">
                    <div class="col-6 text-end fw-bold">Roll:</div>
                    <div class="col-6 text-start">{{ $resultsite->roll }}</div>
                </div>
                <div class="row">
                    <div class="col-6 text-end fw-bold">Section:</div>
                    <div class="col-6 text-start">{{ $resultsite->section }}</div>
                </div>
            </div>
        </div>

        <!-- Grading Scale -->
        <div class="col-md-5 d-flex justify-content-end">
            <table class="table table-bordered table-sm text-center grading-table" style="width: auto; font-size: 12px;">
                <thead class="table-light">
                    <tr>
                        <th>Letter Grade</th>
                        <th>Class Interval</th>
                        <th>Grade Point</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>A+</td><td>80-100</td><td>5</td></tr>
                    <tr><td>A</td><td>70-79</td><td>4</td></tr>
                    <tr><td>A-</td><td>60-69</td><td>3.5</td></tr>
                    <tr><td>B</td><td>50-59</td><td>3</td></tr>
                    <tr><td>C</td><td>40-49</td><td>2</td></tr>
                    <tr><td>D</td><td>33-39</td><td>1</td></tr>
                    <tr><td>F</td><td>0-32</td><td>0</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Result Table -->
    <div class="result-table-container">
        <table class="table result-table">
            <thead>
                <tr>
                    <th class="text-center">Subject Code</th>
                    <th class="text-start">Subject Name</th>
                    <th class="text-center">Total Mark</th>
                    <th class="text-center">Grade</th>
                    <th class="text-center">Grade Point</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($sub_info as $subject)
                    @php $grandTotal += $subject['obtained_mark']; @endphp
                    <tr>
                        <td class="text-center text-muted">{{ $subject['sub_code'] }}</td>
                        <td class="text-start text-uppercase text-muted">{{ $subject['sub_name'] }}</td>
                        <td class="text-center text-muted">
                            @if(!empty($subject['mark_components']) && $subject['mark_components'] != $subject['obtained_mark'])
                                {{ $subject['mark_components'] }}
                            @else
                                {{ $subject['obtained_mark'] }}
                            @endif
                        </td>
                        <td class="text-center text-muted">{{ $subject['grade'] }}</td>
                        <td class="text-center text-muted">{{ $subject['point'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="footer-row">
                    <td colspan="2" class="text-end pe-4">Total Mark</td>
                    <td class="text-center">{{ $grandTotal }}</td>
                    <td class="text-center">CGPA</td>
                    <td class="text-center">{{ $cgpa }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Print Button (Hidden in Print) -->
    <div class="mt-4 text-center d-print-none">
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Print Result
        </button>
        <a href="{{ route('student.result.index') }}" class="btn btn-outline-secondary ms-2">
            Back to Search
        </a>
    </div>
</div>

@section('styles')
<style>
    /* Custom Styles for Result Page */
    .student-info-table td {
        padding: 4px 8px;
        font-size: 15px;
        color: #333;
    }
    
    .grading-table th, .grading-table td {
        padding: 2px 8px;
    }
    
    .result-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .result-table thead th {
        background-color: #a8c1ff; /* Light blue header */
        color: #333;
        font-weight: 600;
        padding: 12px;
        border: none;
    }
    
    .result-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .result-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }
    
    .result-table tfoot td {
        background-color: #f0f4ff;
        padding: 12px;
        font-weight: bold;
        color: #555;
        border-top: 2px solid #dce4ff;
    }

    @media print {
        /* Force background colors */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Hide non-printable elements */
        .d-print-none, .sidebar, .navbar, .fixed-top, #sidebarToggle, .sidebar-overlay {
            display: none !important;
        }

        /* Reset layout for full width */
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        body {
            background: white;
            margin: 0;
            padding: 0;
            overflow: visible !important;
        }

        /* Ensure columns layout correctly */
        .row {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        .col-md-5 {
            width: 41.666667% !important;
            flex: 0 0 41.666667% !important;
        }
        
        .col-md-2 {
            width: 16.666667% !important;
            flex: 0 0 16.666667% !important;
        }

        /* Ensure table headers have background color */
        .result-table thead th {
            background-color: #a8c1ff !important;
            color: #333 !important;
        }

        /* Ensure footer has background color */
        .result-table tfoot td {
            background-color: #f0f4ff !important;
        }
        
        /* Ensure striped rows work */
        .result-table tbody tr:nth-child(even) {
            background-color: #f8f9fa !important;
        }
    }
</style>
@endsection
@endsection
