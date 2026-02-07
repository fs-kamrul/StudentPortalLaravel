<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CqQuestion;
use App\Models\CqChapter;

class AdminCqQuestionController extends Controller
{
    /**
     * Display questions for a specific chapter
     */
    public function index($chapterId)
    {
        $admin = Auth::guard('admin')->user();
        $chapter = CqChapter::with('subject')->findOrFail($chapterId);
        
        $questions = $chapter->questions()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.cq.questions.index', compact('admin', 'chapter', 'questions'));
    }

    /**
     * Show create form
     */
    public function create($chapterId)
    {
        $admin = Auth::guard('admin')->user();
        $chapter = CqChapter::with('subject')->findOrFail($chapterId);
        
        return view('admin.cq.questions.create', compact('admin', 'chapter'));
    }

    /**
     * Store new question
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chapter_id' => 'required|exists:cp_chapters,id',
            'question_stem' => 'required|string',
            'sub_question_a' => 'required|string',
            'sub_question_a_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_a_marks' => 'required|numeric|min:0',
            'sub_question_b' => 'required|string',
            'sub_question_b_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_b_marks' => 'required|numeric|min:0',
            'sub_question_c' => 'required|string',
            'sub_question_c_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_c_marks' => 'required|numeric|min:0',
            'sub_question_d' => 'nullable|string',
            'sub_question_d_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_d_marks' => 'nullable|numeric|min:0',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'status' => 'required|in:active,inactive',
        ]);

        $question = CqQuestion::create($validated);

        return redirect()
            ->route('admin.cq.questions.index', $question->chapter_id)
            ->with('success', 'Question created successfully with total marks: ' . $question->total_marks);
    }

    /**
     * Show single question
     */
    public function show($id)
    {
        $admin = Auth::guard('admin')->user();
        $question = CqQuestion::with(['chapter.subject'])->findOrFail($id);
        
        return view('admin.cq.questions.show', compact('admin', 'question'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $question = CqQuestion::with(['chapter.subject'])->findOrFail($id);
        
        return view('admin.cq.questions.edit', compact('admin', 'question'));
    }

    /**
     * Update question
     */
    public function update(Request $request, $id)
    {
        $question = CqQuestion::findOrFail($id);
        
        $validated = $request->validate([
            'question_stem' => 'required|string',
            'sub_question_a' => 'required|string',
            'sub_question_a_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_a_marks' => 'required|numeric|min:0',
            'sub_question_b' => 'required|string',
            'sub_question_b_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_b_marks' => 'required|numeric|min:0',
            'sub_question_c' => 'required|string',
            'sub_question_c_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_c_marks' => 'required|numeric|min:0',
            'sub_question_d' => 'nullable|string',
            'sub_question_d_id' => 'nullable|exists:cp_part_questions,id',
            'sub_question_d_marks' => 'nullable|numeric|min:0',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'status' => 'required|in:active,inactive',
        ]);

        $question->update($validated);

        return redirect()
            ->route('admin.cq.questions.index', $question->chapter_id)
            ->with('success', 'Question updated successfully');
    }

    /**
     * Soft delete question
     */
    public function destroy($id)
    {
        $question = CqQuestion::findOrFail($id);
        $chapterId = $question->chapter_id;
        $question->delete();

        return redirect()
            ->route('admin.cq.questions.index', $chapterId)
            ->with('success', 'Question deleted successfully');
    }

    /**
     * Restore soft deleted question
     */
    public function restore($id)
    {
        $question = CqQuestion::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()
            ->route('admin.cq.questions.index', $question->chapter_id)
            ->with('success', 'Question restored successfully');
    }

    /**
     * Permanently delete question
     */
    public function forceDestroy($id)
    {
        $question = CqQuestion::withTrashed()->findOrFail($id);
        $chapterId = $question->chapter_id;
        $question->forceDelete();

        return redirect()
            ->route('admin.cq.questions.index', $chapterId)
            ->with('success', 'Question permanently deleted');
    }
}
