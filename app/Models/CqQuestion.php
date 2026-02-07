<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CqQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'cp_questions';

    protected $fillable = [
        'chapter_id',
        'question_stem',
        'sub_question_a',
        'sub_question_a_marks',
        'sub_question_b',
        'sub_question_b_marks',
        'sub_question_c',
        'sub_question_c_marks',
        'sub_question_d',
        'sub_question_d_marks',
        'sub_question_a_id',
        'sub_question_b_id',
        'sub_question_c_id',
        'sub_question_d_id',
        'total_marks',
        'difficulty_level',
        'status',
    ];

    protected $casts = [
        'sub_question_a_marks' => 'decimal:2',
        'sub_question_b_marks' => 'decimal:2',
        'sub_question_c_marks' => 'decimal:2',
        'sub_question_d_marks' => 'decimal:2',
        'sub_question_a_id' => 'integer',
        'sub_question_b_id' => 'integer',
        'sub_question_c_id' => 'integer',
        'sub_question_d_id' => 'integer',
        'total_marks' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the chapter that owns this question
     */
    public function chapter()
    {
        return $this->belongsTo(CqChapter::class, 'chapter_id');
    }

    /**
     * Relationship: Sub-question A (from bank)
     */
    public function subQuestionA()
    {
        return $this->belongsTo(ChapterQuestion::class, 'sub_question_a_id');
    }

    /**
     * Relationship: Sub-question B (from bank)
     */
    public function subQuestionB()
    {
        return $this->belongsTo(ChapterQuestion::class, 'sub_question_b_id');
    }

    /**
     * Relationship: Sub-question C (from bank)
     */
    public function subQuestionC()
    {
        return $this->belongsTo(ChapterQuestion::class, 'sub_question_c_id');
    }

    /**
     * Relationship: Sub-question D (from bank)
     */
    public function subQuestionD()
    {
        return $this->belongsTo(ChapterQuestion::class, 'sub_question_d_id');
    }

    /**
     * Get all part questions (QBank) for the same chapter as this question
     */
    public function partQuestions()
    {
        return $this->hasMany(ChapterQuestion::class, 'chapter_id', 'chapter_id');
    }

    /**
     * Get the sets that include this question
     */
    public function sets()
    {
        return $this->belongsToMany(CqSet::class, 'cp_set_questions', 'question_id', 'set_id')
            ->withPivot('question_order')
            ->withTimestamps()
            ->orderBy('cp_set_questions.question_order');
    }

    /**
     * Get the subject through chapter
     */
    public function subject()
    {
        return $this->chapter->subject();
    }

    /**
     * Accessor to get subject directly
     */
    public function getSubjectAttribute()
    {
        return $this->chapter ? $this->chapter->subject : null;
    }

    /**
     * Calculate and set total marks from sub-questions
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($question) {
            $question->total_marks = 
                ($question->sub_question_a_marks ?? 0) +
                ($question->sub_question_b_marks ?? 0) +
                ($question->sub_question_c_marks ?? 0) +
                ($question->sub_question_d_marks ?? 0);
        });
    }
}
