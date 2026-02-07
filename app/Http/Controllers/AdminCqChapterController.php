<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CqChapter;
use App\Models\CqSubject;

class AdminCqChapterController extends Controller
{
    /**
     * Display chapters for a specific subject
     */
    public function index($subjectId)
    {
        $admin = Auth::guard('admin')->user();
        $subject = CqSubject::findOrFail($subjectId);
        
        $chapters = $subject->chapters()
            ->withCount('questions')
            ->orderBy('chapter_number')
            ->paginate(20);
        
        return view('admin.cq.chapters.index', compact('admin', 'subject', 'chapters'));
    }

    /**
     * Show create form
     */
    public function create($subjectId)
    {
        $admin = Auth::guard('admin')->user();
        $subject = CqSubject::findOrFail($subjectId);
        
        return view('admin.cq.chapters.create', compact('admin', 'subject'));
    }

    /**
     * Store new chapter
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:cp_subjects,id',
            'chapter_number' => 'required|integer|min:1',
            'chapter_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $chapter = CqChapter::create($validated);

        return redirect()
            ->route('admin.cq.chapters.index', $chapter->subject_id)
            ->with('success', 'Chapter created successfully: ' . $chapter->chapter_name);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $chapter = CqChapter::with('subject')->findOrFail($id);
        
        return view('admin.cq.chapters.edit', compact('admin', 'chapter'));
    }

    /**
     * Update chapter
     */
    public function update(Request $request, $id)
    {
        $chapter = CqChapter::findOrFail($id);
        
        $validated = $request->validate([
            'chapter_number' => 'required|integer|min:1',
            'chapter_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $chapter->update($validated);

        return redirect()
            ->route('admin.cq.chapters.index', $chapter->subject_id)
            ->with('success', 'Chapter updated successfully: ' . $chapter->chapter_name);
    }

    /**
     * Soft delete chapter
     */
    public function destroy($id)
    {
        $chapter = CqChapter::findOrFail($id);
        
        // Check if chapter has questions
        if ($chapter->questions()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete chapter: It has ' . $chapter->questions()->count() . ' questions. Please delete them first.');
        }
        
        $subjectId = $chapter->subject_id;
        $chapterName = $chapter->chapter_name;
        $chapter->delete();

        return redirect()
            ->route('admin.cq.chapters.index', $subjectId)
            ->with('success', 'Chapter deleted successfully: ' . $chapterName);
    }

    /**
     * Restore soft deleted chapter
     */
    public function restore($id)
    {
        $chapter = CqChapter::onlyTrashed()->findOrFail($id);
        $chapter->restore();

        return redirect()
            ->route('admin.cq.chapters.index', $chapter->subject_id)
            ->with('success', 'Chapter restored successfully: ' . $chapter->chapter_name);
    }

    /**
     * Permanently delete chapter
     */
    public function forceDestroy($id)
    {
        $chapter = CqChapter::withTrashed()->findOrFail($id);
        
        if ($chapter->questions()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot permanently delete chapter: It still has questions.');
        }
        
        $subjectId = $chapter->subject_id;
        $chapterName = $chapter->chapter_name;
        $chapter->forceDelete();

        return redirect()
            ->route('admin.cq.chapters.index', $subjectId)
            ->with('success', 'Chapter permanently deleted: ' . $chapterName);
    }
}
