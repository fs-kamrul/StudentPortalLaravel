<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        // Check if student must change password
        $student = Auth::guard('student')->user();
        if ($student->must_change_password && !$request->routeIs('student.password.*')) {
            return redirect()->route('student.password.change');
        }

        return $next($request);
    }
}
