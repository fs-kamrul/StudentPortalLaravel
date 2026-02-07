<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CqSet;
use App\Models\CqSubject;
use App\Models\CqQuestion;

class AdminCqSetController extends Controller
{
    /**
     * Display all question sets
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $filterSubject = $request->get('subject_id');
        $filterStatus = $request->get('status');
        
        $query = CqSet::with('subject')->withCount('questions');
        
        if ($filterSubject) {
            $query->where('subject_id', $filterSubject);
        }
        
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
        
        $sets = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        $subjects = CqSubject::where('status', 'active')->orderBy('subject_name')->get();
        
        return view('admin.cq.sets.index', compact('admin', 'sets', 'subjects', 'filterSubject', 'filterStatus'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $admin = Auth::guard('admin')->user();
        $subjects = CqSubject::where('status', 'active')->orderBy('subject_name')->get();
        
        return view('admin.cq.sets.create', compact('admin', 'subjects'));
    }

    /**
     * Store new set
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'set_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:cp_subjects,id',
            'exam_name' => 'required|string|max:255',
            'exam_date' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'instructions' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        // Initialize total_marks to 0
        $validated['total_marks'] = 0;

        $set = CqSet::create($validated);

        return redirect()
            ->route('admin.cq.sets.edit', $set->id)
            ->with('success', 'Question set created successfully. Now add questions to the set.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $set = CqSet::with(['subject', 'questions.chapter'])->findOrFail($id);
        
        return view('admin.cq.sets.edit', compact('admin', 'set'));
    }

    /**
     * Update set
     */
    public function update(Request $request, $id)
    {
        $set = CqSet::findOrFail($id);
        
        $validated = $request->validate([
            'set_name' => 'required|string|max:255',
            'exam_name' => 'required|string|max:255',
            'exam_date' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'instructions' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $set->update($validated);

        return redirect()
            ->route('admin.cq.sets.index')
            ->with('success', 'Question set updated successfully');
    }

    /**
     * Show interface to add questions to set
     */
    public function addQuestions($id)
    {
        $admin = Auth::guard('admin')->user();
        $set = CqSet::with(['subject', 'questions'])->findOrFail($id);
        
        // Get all active questions for the subject
        $availableQuestions = CqQuestion::whereHas('chapter', function($query) use ($set) {
            $query->where('subject_id', $set->subject_id);
        })
        ->with('chapter')
        ->where('status', 'active')
        ->orderBy('chapter_id')
        ->get();

        // Get all chapters for the subject to show in builder dropdown
        $allChapters = $set->subject->chapters()->where('status', 'active')->orderBy('chapter_number')->get();
        
        return view('admin.cq.sets.add_questions', compact('admin', 'set', 'availableQuestions', 'allChapters'));
    }

    /**
     * Store selected questions to set
     */
    public function storeQuestions(Request $request, $id)
    {
        $set = CqSet::findOrFail($id);
        
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'exists:cp_questions,id',
            'orders' => 'nullable|array',
            'orders.*' => 'integer|min:0',
        ]);

        $questions = $validated['questions'];
        $orders = $validated['orders'] ?? [];

        // Sync questions with orders
        $syncData = [];
        foreach ($questions as $index => $questionId) {
            $syncData[$questionId] = ['question_order' => $orders[$questionId] ?? $index + 1];
        }

        $set->questions()->sync($syncData);

        // Update total marks
        $set->total_marks = $set->calculateTotalMarks();
        $set->save();

        return redirect()
            ->route('admin.cq.sets.edit', $set->id)
            ->with('success', count($questions) . ' questions added to set. Total marks: ' . $set->total_marks);
    }

    /**
     * Build and store a new CQ from bank parts
     */
    public function buildFromBank(Request $request, $id)
    {
        $set = CqSet::findOrFail($id);
        
        $validated = $request->validate([
            'chapter_id' => 'required|exists:cp_chapters,id',
            'question_stem' => 'required|string',
            'sub_question_a' => 'required|string',
            'sub_question_a_id' => 'nullable|exists:tbl_cq_part_questions,id',
            'sub_question_b' => 'required|string',
            'sub_question_b_id' => 'nullable|exists:tbl_cq_part_questions,id',
            'sub_question_c' => 'required|string',
            'sub_question_c_id' => 'nullable|exists:tbl_cq_part_questions,id',
            'sub_question_d' => 'nullable|string',
            'sub_question_d_id' => 'nullable|exists:tbl_cq_part_questions,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
        ]);

        // Static marks for Bangladesh pattern
        $validated['sub_question_a_marks'] = 1;
        $validated['sub_question_b_marks'] = 2;
        $validated['sub_question_c_marks'] = 3;
        $validated['sub_question_d_marks'] = $validated['sub_question_d'] ? 4 : 0;
        $validated['status'] = 'active';

        // Create the full CQ
        $question = CqQuestion::create($validated);

        // Attach to set (at the end)
        $maxOrder = $set->questions()->max('question_order') ?? 0;
        $set->questions()->attach($question->id, ['question_order' => $maxOrder + 1]);

        // Update total marks
        $set->total_marks = $set->calculateTotalMarks();
        $set->save();

        return redirect()
            ->route('admin.cq.sets.addQuestions', $set->id)
            ->with('success', 'New Creative Question built from bank and added to set!');
    }

    /**
     * Preview question paper
     */
    public function preview($id)
    {
        $admin = Auth::guard('admin')->user();
        $set = CqSet::with(['subject', 'questions.chapter'])->findOrFail($id);
        
        return view('admin.cq.sets.preview', compact('admin', 'set'));
    }

    /**
     * Preview question paper with answers
     */
    public function ansPreview($id)
    {
        $admin = Auth::guard('admin')->user();
        $set = CqSet::with([
            'subject', 
            'questions.chapter',
            'questions.subQuestionA',
            'questions.subQuestionB',
            'questions.subQuestionC',
            'questions.subQuestionD'
        ])->findOrFail($id);
        
        return view('admin.cq.sets.ans_preview', compact('admin', 'set'));
    }

    /**
     * Generate PDF
     */
    public function generatePdf($id)
    {
        $set = CqSet::with(['subject', 'questions.chapter'])->findOrFail($id);
        
        // Load PDF library
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cq.sets.pdf', compact('set'));
        
        // Set paper size to A4
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = str_replace(' ', '_', $set->set_name) . '_' . date('Y-m-d') . '.pdf';
        
        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * Soft delete set
     */
    public function destroy($id)
    {
        $set = CqSet::findOrFail($id);
        $setName = $set->set_name;
        $set->delete();

        return redirect()
            ->route('admin.cq.sets.index')
            ->with('success', 'Question set deleted successfully: ' . $setName);
    }

    /**
     * Restore soft deleted set
     */
    public function restore($id)
    {
        $set = CqSet::onlyTrashed()->findOrFail($id);
        $set->restore();

        return redirect()
            ->route('admin.cq.sets.index')
            ->with('success', 'Question set restored successfully: ' . $set->set_name);
    }

    /**
     * Permanently delete set
     */
    public function forceDestroy($id)
    {
        $set = CqSet::withTrashed()->findOrFail($id);
        $setName = $set->set_name;
        $set->forceDelete();

        return redirect()
            ->route('admin.cq.sets.index')
            ->with('success', 'Question set permanently deleted: ' . $setName);
    }
}
