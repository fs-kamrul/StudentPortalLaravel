<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    /**
     * Show the password change form
     */
    public function showChangeForm()
    {
        $student = Auth::guard('student')->user();
        return view('student.password-change', compact('student'));
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        $student = Auth::guard('student')->user();

        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Verify current password
        $currentPasswordMatches = false;
        
        try {
            if (Hash::check($request->current_password, $student->password)) {
                $currentPasswordMatches = true;
            }
        } catch (\RuntimeException $e) {
            // Handle plain text password
            if ($request->current_password === $student->password) {
                $currentPasswordMatches = true;
            }
        }

        if (!$currentPasswordMatches) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password and mark as changed
        $student->password = Hash::make($request->new_password);
        $student->must_change_password = false;
        $student->save();

        return redirect()->route('student.dashboard')
            ->with('success', 'Password changed successfully!');
    }
}
