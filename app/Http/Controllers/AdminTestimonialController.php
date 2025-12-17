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

    /**
     * Update testimonial status
     */
    public function updateStatus(Request $request, $id, $status)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        // Validate status transition
        $validStatuses = ['pending', 'processing', 'completed', 'delivered'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status provided.');
        }
        
        $testimonial->status = $status;
        $testimonial->save();
        
        return redirect()->back()->with('success', 'Testimonial status updated to ' . ucfirst($status) . ' successfully!');
    }
}
