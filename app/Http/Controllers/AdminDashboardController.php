<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use App\Models\Student;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        
        // Get statistics
        $totalStudents = Student::count();
        $pendingTestimonials = Testimonial::where('status', 'pending')->count();
        $approvedTestimonials = Testimonial::where('status', 'approved')->count();
        $totalTestimonials = Testimonial::count();
        
        // Get recent testimonials with student info and payment status
        $testimonials = Testimonial::with('student')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact('admin', 'totalStudents', 'pendingTestimonials', 'approvedTestimonials', 'testimonials', 'totalTestimonials'));
    }
}
