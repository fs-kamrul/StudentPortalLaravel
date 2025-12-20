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

    /**
     * Show the form for creating a new testimonial
     */
    public function create()
    {
        $admin = Auth::guard('admin')->user();
        
        // Get all students for the dropdown
        $students = \App\Models\Student::orderBy('name')->get();
        
        return view('admin.testimonials.create', compact('admin', 'students'));
    }

    /**
     * Store a newly created testimonial
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'student_id' => 'required|exists:student_information,id',
            'registration_id' => 'required|string|max:255',
            'roll' => 'required|string|max:255',
            'gpa' => 'required|numeric|min:0|max:5',
            'status' => 'required|in:pending,processing,completed,delivered',
            'payment_status' => 'required|in:unpaid,pending,paid',
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'bkash_transaction_id' => 'nullable|string|max:255',
            'bkash_phone_number' => 'nullable|string|max:20',
            'remarks' => 'nullable|string',
        ]);

        // Create the testimonial
        $testimonial = Testimonial::create($validated);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully for student ID: ' . $testimonial->student_id);
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id, $payment_status)
    {
        $testimonial = Testimonial::findOrFail($id);
        
        // Validate payment status
        $validPaymentStatuses = ['unpaid', 'pending', 'paid'];
        if (!in_array($payment_status, $validPaymentStatuses)) {
            return redirect()->back()->with('error', 'Invalid payment status provided.');
        }
        
        $testimonial->payment_status = $payment_status;
        $testimonial->save();
        
        return redirect()->back()->with('success', 'Payment status updated to ' . ucfirst($payment_status) . ' successfully!');
    }
}
