<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CqSubject extends Model
{
    use SoftDeletes;

    protected $table = 'cp_subjects';

    protected $fillable = [
        'subject_name',
        'subject_code',
        'class_level',
        'description',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the chapters for this subject
     */
    public function chapters()
    {
        return $this->hasMany(CqChapter::class, 'subject_id');
    }

    /**
     * Get the question sets for this subject
     */
    public function sets()
    {
        return $this->hasMany(CqSet::class, 'subject_id');
    }

    /**
     * Get all part questions (QBank) for this subject through chapters
     */
    public function partQuestions()
    {
        return $this->hasManyThrough(ChapterQuestion::class, CqChapter::class, 'subject_id', 'chapter_id');
    }

    /**
     * Get active chapters only
     */
    public function activeChapters()
    {
        return $this->hasMany(CqChapter::class, 'subject_id')->where('status', 'active');
    }
}
