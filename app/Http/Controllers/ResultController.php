<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display the result search form
     */
    public function index()
    {
        $student = Auth::guard('student')->user();
        $options = Result::getOptions();
        
        return view('student.result.index', [
            'student' => $student,
            'options' => $options
        ]);
    }

    /**
     * Process the result search and display results
     */
    public function show(Request $request)
    {
        $student = Auth::guard('student')->user();
        
        // Validate the request
        $validated = $request->validate([
            'studentID' => 'required',
            'session' => 'required',
            'exam' => 'required'
        ], [
            'session.required' => 'Please select a session/year',
            'exam.required' => 'Please select an exam type'
        ]);

        $data = [
            'studentID' => $validated['studentID'],
            'session' => $validated['session'],
            'exam_type' => $validated['exam']
        ];

        // Get student info and results
        $resultInfo = Result::getStudentInfo($data);
        $subResults = Result::getSubjectResults($data);

        // Check if results exist
        if (!$resultInfo || $subResults->isEmpty()) {
            return redirect()->route('student.result.index')
                ->with('error', 'No results found for the selected session and exam type.');
        }

        // Process the results data
        $mainData = [];
        $subInfo = [];
        $totalGradePoints = 0;
        $totalSubjects = 0;
        $isFail = false;
        
        foreach ($subResults as $value) {
            $mainData[$value->sub_name][$value->mark_id] = [
                'mark_number' => $value->mark_number,
                'total' => $value->mark,
                'add_f' => $value->add_f,
                'pass_mark' => $value->pass_mark,
                'sub_mark' => $value->sub_mark,
                'mark_pf' => $value->mark_pf
            ];
            
            // Only process subject info once per subject
            if (!isset($subInfo[$value->sub_name])) {
                $subInfo[$value->sub_name] = [
                    'sub_code' => $value->sub_code,
                    'sub_name' => $value->sub_name,
                    'pass_mark' => $value->pass_mark,
                    'sub_mark' => $value->sub_mark
                ];
            }
        }

        // Calculate Grades and GPA for each subject
        foreach ($subInfo as $subName => &$info) {
            $subjectTotal = 0;
            $components = [];
            
            if (isset($mainData[$subName])) {
                foreach ($mainData[$subName] as $markId => $marks) {
                    $subjectTotal += $marks['total'];
                    // Store components for display (e.g., "26+15")
                    if ($marks['total'] > 0) {
                        $components[] = $marks['total'];
                    }
                }
            }
            
            $info['obtained_mark'] = $subjectTotal;
            $info['mark_components'] = implode('+', $components);
            
            // Calculate Grade and Point
            $gradeInfo = $this->calculateGrade($subjectTotal, $info['sub_mark']);
            $info['grade'] = $gradeInfo['grade'];
            $info['point'] = $gradeInfo['point'];
            
            if ($gradeInfo['grade'] == 'F') {
                $isFail = true;
            }
            
            // Only count towards CGPA if it's not an optional subject (logic can be adjusted)
            // Assuming all subjects count for now
            $totalGradePoints += $gradeInfo['point'];
            $totalSubjects++;
        }

        $cgpa = $totalSubjects > 0 ? number_format($totalGradePoints / $totalSubjects, 2) : 0.00;
        if ($isFail) {
            $cgpa = 0.00;
        }

        // Get School Info
        $school = \App\Models\School::first();

        return view('student.result.show', [
            'student' => $student,
            'resultsite' => $resultInfo,
            'sub_info' => $subInfo,
            'exam_type' => $data['exam_type'],
            'cgpa' => $cgpa,
            'is_fail' => $isFail,
            'school' => $school
        ]);
    }

    /**
     * Calculate Grade and Point based on obtained mark
     */
    private function calculateGrade($obtained, $total)
    {
        // Normalize to 100% scale if total is not 100
        $percentage = ($total > 0) ? ($obtained / $total) * 100 : 0;
        
        if ($percentage >= 80) return ['grade' => 'A+', 'point' => 5.00];
        if ($percentage >= 70) return ['grade' => 'A', 'point' => 4.00];
        if ($percentage >= 60) return ['grade' => 'A-', 'point' => 3.50];
        if ($percentage >= 50) return ['grade' => 'B', 'point' => 3.00];
        if ($percentage >= 40) return ['grade' => 'C', 'point' => 2.00];
        if ($percentage >= 33) return ['grade' => 'D', 'point' => 1.00];
        return ['grade' => 'F', 'point' => 0.00];
    }
}
