<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CqSubject;

class AdminCqSubjectController extends Controller
{
    /**
     * Display all subjects with pagination
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Get filter parameters
        $filterStatus = $request->get('status');
        
        // Build query
        $query = CqSubject::withCount('chapters');
        
        // Apply filters
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
        
        // Get subjects with pagination
        $subjects = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        
        return view('admin.cq.subjects.index', compact('admin', 'subjects', 'filterStatus'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.cq.subjects.create', compact('admin'));
    }

    /**
     * Store new subject
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:50',
            'class_level' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $subject = CqSubject::create($validated);

        return redirect()
            ->route('admin.cq.subjects.index')
            ->with('success', 'Subject created successfully: ' . $subject->subject_name);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $subject = CqSubject::findOrFail($id);
        
        return view('admin.cq.subjects.edit', compact('admin', 'subject'));
    }

    /**
     * Update subject
     */
    public function update(Request $request, $id)
    {
        $subject = CqSubject::findOrFail($id);
        
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:50',
            'class_level' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $subject->update($validated);

        return redirect()
            ->route('admin.cq.subjects.index')
            ->with('success', 'Subject updated successfully: ' . $subject->subject_name);
    }

    /**
     * Soft delete subject
     */
    public function destroy($id)
    {
        $subject = CqSubject::findOrFail($id);
        
        // Check if subject has chapters
        if ($subject->chapters()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete subject: It has ' . $subject->chapters()->count() . ' chapters. Please delete or reassign them first.');
        }
        
        $subjectName = $subject->subject_name;
        $subject->delete();

        return redirect()
            ->route('admin.cq.subjects.index')
            ->with('success', 'Subject deleted successfully: ' . $subjectName);
    }

    /**
     * Restore soft deleted subject
     */
    public function restore($id)
    {
        $subject = CqSubject::onlyTrashed()->findOrFail($id);
        $subject->restore();

        return redirect()
            ->route('admin.cq.subjects.index')
            ->with('success', 'Subject restored successfully: ' . $subject->subject_name);
    }

    /**
     * Permanently delete subject
     */
    public function forceDestroy($id)
    {
        $subject = CqSubject::withTrashed()->findOrFail($id);
        
        // Final check for dependencies
        if ($subject->chapters()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot permanently delete subject: It still has chapters.');
        }
        
        $subjectName = $subject->subject_name;
        $subject->forceDelete();

        return redirect()
            ->route('admin.cq.subjects.index')
            ->with('success', 'Subject permanently deleted: ' . $subjectName);
    }
}
