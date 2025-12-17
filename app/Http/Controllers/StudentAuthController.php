<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class StudentAuthController extends Controller
{
    /**
     * Show the student login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('student.login');
    }

    /**
     * Handle student login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'student_id' => 'required',
            'password' => 'required',
        ]);

        $studentId = $request->input('student_id');
        $password = $request->input('password');

        // Find the student by ID
        $student = Student::where('id', $studentId)->first();

        if (!$student) {
            return back()->withErrors([
                'student_id' => 'Invalid student ID or password.',
            ])->withInput($request->only('student_id'));
        }

        // Check if password matches
        // Try hashed password first, then fallback to plain text if needed
        
        $passwordMatches = false;
        
        // Try bcrypt hashed password first
        try {
            if (Hash::check($password, $student->password)) {
                $passwordMatches = true;
            }
        } catch (\RuntimeException $e) {
            // Password is not bcrypt hashed, will try plain text comparison
        }
        
        // Fallback to plain text comparison (if passwords are stored as plain text)
        if (!$passwordMatches && $password === $student->password) {
            $passwordMatches = true;
        }

        if (!$passwordMatches) {
            return back()->withErrors([
                'password' => 'Invalid student ID or password.',
            ])->withInput($request->only('student_id'));
        }

        // Log in the student
        Auth::guard('student')->login($student);

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        // Check if password must be changed
        if ($student->must_change_password) {
            return redirect()->route('student.password.change');
        }

        return redirect()->intended(route('student.dashboard'));
    }

    /**
     * Show the student dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        return view('student.dashboard', compact('student'));
    }

    /**
     * Handle student logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}
