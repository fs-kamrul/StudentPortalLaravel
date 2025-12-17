<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;

class AdminTestimonialController extends Controller
{
    /**
     * Display all testimonials with filters
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Get filter parameters
        $filterStatus = $request->get('status');
        $filterPaymentStatus = $request->get('payment_status');
        
        // Build query
        $query = Testimonial::with('student');
        
        // Apply filters
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
        if ($filterPaymentStatus) {
            $query->where('payment_status', $filterPaymentStatus);
        }
        
        // Get testimonials with pagination
        $testimonials = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        
        return view('admin.testimonials.index', compact('admin', 'testimonials', 'filterStatus', 'filterPaymentStatus'));
    }
}
