<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChapterQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_cq_part_questions';

    protected $fillable = [
        'chapter_id',
        'question_type',
        'question_text',
        'answer_text',
        'marks',
        'status',
    ];

    /**
     * Relationship: Belongs to Chapter
     */
    public function chapter()
    {
        return $this->belongsTo(CqChapter::class, 'chapter_id');
    }

    /**
     * Scope for filtering by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('question_type', $type);
    }

    /**
     * Get human-readable question type
     */
    public function getTypeNameAttribute()
    {
        $types = [
            'knowledge' => 'Knowledge-based',
            'comprehension' => 'Comprehension-based',
            'application' => 'Application-based',
            'higher_ability' => 'Higher Ability/Analysis',
        ];

        return $types[$this->question_type] ?? $this->question_type;
    }
}
