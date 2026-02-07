<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CqSet extends Model
{
    use SoftDeletes;

    protected $table = 'cp_sets';

    protected $fillable = [
        'set_name',
        'subject_id',
        'exam_name',
        'exam_date',
        'total_marks',
        'duration_minutes',
        'instructions',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'total_marks' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the subject for this set
     */
    public function subject()
    {
        return $this->belongsTo(CqSubject::class, 'subject_id');
    }

    /**
     * Get the questions in this set
     */
    public function questions()
    {
        return $this->belongsToMany(CqQuestion::class, 'cp_set_questions', 'set_id', 'question_id')
            ->withPivot('question_order')
            ->withTimestamps()
            ->orderBy('cp_set_questions.question_order');
    }

    /**
     * Calculate total marks from all questions in the set
     */
    public function calculateTotalMarks()
    {
        return $this->questions()->sum('total_marks');
    }
}
