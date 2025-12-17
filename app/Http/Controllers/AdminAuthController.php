<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login with MD5 password verification
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        // Find admin by email or username
        $admin = Admin::where('admin_email_address', $request->email)->first();

        // Verify MD5 password
        if ($admin && $admin->admin_password === md5($request->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . $admin->admin_name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.change-password', compact('admin'));
    }

    /**
     * Handle change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        // Verify current password (MD5)
        if ($admin->admin_password !== md5($request->current_password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        // Update password (MD5)
        $admin->admin_password = md5($request->new_password);
        $admin->save();

        return back()->with('success', 'Password changed successfully!');
    }
}
