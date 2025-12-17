<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\OptionA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminStudentController extends Controller
{
    /**
     * Display student list with filters
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Get filter parameters
        $filterClass = $request->get('class');
        $filterSection = $request->get('section');
        $filterGroup = $request->get('group_r');
        $filterYear = $request->get('year');
        $filterStudentId = $request->get('student_id');
        
        // Build query
        $query = Student::query();
        
        // Apply filters if provided
        if ($filterClass) {
            $query->where('class', $filterClass);
        }
        if ($filterSection) {
            $query->where('section', $filterSection);
        }
        if ($filterGroup) {
            $query->where('group_r', $filterGroup);
        }
        if ($filterYear) {
            $query->where('year', $filterYear);
        }
        if ($filterStudentId) {
            $query->where('id', 'LIKE', '%' . $filterStudentId . '%');
        }
        
        // Get students with pagination
        $students = $query->orderBy('name', 'asc')->paginate(20)->appends($request->query());
        
        // Get unique values for filter dropdowns from option_a table
        $classes = OptionA::getOptions('class');
        $sections = OptionA::getOptions('section');
        $groups = OptionA::getOptions('group');
        $years = OptionA::getOptions('year');
        
        return view('admin.students.index', compact(
            'admin', 'students', 
            'classes', 'sections', 'groups', 'years',
            'filterClass', 'filterSection', 'filterGroup', 'filterYear', 'filterStudentId'
        ));
    }

    /**
     * Display individual student information
     */
    public function show($id)
    {
        $admin = Auth::guard('admin')->user();
        $student = Student::where('id', $id)->firstOrFail();
        
        return view('admin.students.show', compact('admin', 'student'));
    }

    /**
     * Reset student password to their ID
     */
    public function resetPassword($id)
    {
        $student = Student::where('id', $id)->firstOrFail();
        
        // Reset password to student ID (using Laravel Hash)
        $student->password = Hash::make($student->id);
        $student->must_change_password = 1;
        $student->save();
        
        return redirect()->back()->with('success', 'Password has been reset to student ID. Student must change password on next login.');
    }

    /**
     * Reset all students' passwords to their IDs
     */
    public function resetAllPasswords()
    {
        $students = Student::all();
        $count = 0;
        
        foreach ($students as $student) {
            $student->password = Hash::make($student->id);
            $student->must_change_password = 1;
            $student->save();
            $count++;
        }
        
        return redirect()->back()->with('success', "Successfully reset passwords for {$count} students. All students must change password on next login.");
    }
}
