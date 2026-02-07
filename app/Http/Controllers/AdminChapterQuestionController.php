<?php

namespace App\Http\Controllers;

use App\Models\CqSubject;
use App\Models\CqChapter;
use App\Models\ChapterQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChapterQuestionController extends Controller
{
    /**
     * Display a listing of questions with filters.
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $query = ChapterQuestion::with(['chapter.subject']);

        // Filtering
        $filterSubject = $request->get('subject_id');
        $filterChapter = $request->get('chapter_id');
        $filterType = $request->get('question_type');

        if ($filterSubject) {
            $query->whereHas('chapter', function($q) use ($filterSubject) {
                $q->where('subject_id', $filterSubject);
            });
        }

        if ($filterChapter) {
            $query->where('chapter_id', $filterChapter);
        }

        if ($filterType) {
            $query->where('question_type', $filterType);
        }

        $questions = $query->latest()->paginate(15)->withQueryString();
        
        $subjects = CqSubject::all();
        $chapters = $filterSubject ? CqChapter::where('subject_id', $filterSubject)->get() : collect();

        return view('admin.cq.part_questions.index', compact(
            'admin', 'questions', 'subjects', 'chapters', 
            'filterSubject', 'filterChapter', 'filterType'
        ));
    }

    /**
     * Show create form.
     */
    public function create(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $subjects = CqSubject::all();
        $selectedSubject = $request->get('subject_id');
        $selectedChapter = $request->get('chapter_id');

        // Infer subject if only chapter is provided
        if (!$selectedSubject && $selectedChapter) {
            $chapter = CqChapter::find($selectedChapter);
            if ($chapter) {
                $selectedSubject = $chapter->subject_id;
            }
        }
        
        $chapters = $selectedSubject ? CqChapter::where('subject_id', $selectedSubject)->get() : collect();

        return view('admin.cq.part_questions.create', compact(
            'admin', 'subjects', 'chapters', 'selectedSubject', 'selectedChapter'
        ));
    }

    /**
     * Store new question.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chapter_id' => 'required|exists:tbl_cq_chapters,id',
            'question_type' => 'required|in:knowledge,comprehension,application,higher_ability',
            'question_text' => 'required|string',
            'answer_text' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Auto-assign marks based on type
        $marksMap = [
            'knowledge' => 1,
            'comprehension' => 2,
            'application' => 3,
            'higher_ability' => 4,
        ];
        $validated['marks'] = $marksMap[$validated['question_type']];

        ChapterQuestion::create($validated);

        return redirect()
            ->route('admin.cq.part_questions.index', ['chapter_id' => $validated['chapter_id']])
            ->with('success', 'Question & Answer added successfully!');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $question = ChapterQuestion::findOrFail($id);
        $subjects = CqSubject::all();
        $currentSubjectId = $question->chapter->subject_id;
        $chapters = CqChapter::where('subject_id', $currentSubjectId)->get();

        return view('admin.cq.part_questions.edit', compact(
            'admin', 'question', 'subjects', 'chapters', 'currentSubjectId'
        ));
    }

    /**
     * Update question.
     */
    public function update(Request $request, $id)
    {
        $question = ChapterQuestion::findOrFail($id);

        $validated = $request->validate([
            'chapter_id' => 'required|exists:tbl_cq_chapters,id',
            'question_type' => 'required|in:knowledge,comprehension,application,higher_ability',
            'question_text' => 'required|string',
            'answer_text' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $marksMap = [
            'knowledge' => 1,
            'comprehension' => 2,
            'application' => 3,
            'higher_ability' => 4,
        ];
        $validated['marks'] = $marksMap[$validated['question_type']];

        $question->update($validated);

        return redirect()
            ->route('admin.cq.part_questions.index', ['chapter_id' => $validated['chapter_id']])
            ->with('success', 'Question & Answer updated successfully!');
    }

    /**
     * Soft delete question.
     */
    public function destroy($id)
    {
        $question = ChapterQuestion::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Question moved to trash.');
    }
}
