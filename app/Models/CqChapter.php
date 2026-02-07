<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CqChapter extends Model
{
    use SoftDeletes;

    protected $table = 'cp_chapters';

    protected $fillable = [
        'subject_id',
        'chapter_number',
        'chapter_name',
        'description',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the subject that owns this chapter
     */
    public function subject()
    {
        return $this->belongsTo(CqSubject::class, 'subject_id');
    }

    /**
     * Get the questions for this chapter
     */
    public function questions()
    {
        return $this->hasMany(CqQuestion::class, 'chapter_id');
    }

    /**
     * Get active questions only
     */
    public function activeQuestions()
    {
        return $this->hasMany(CqQuestion::class, 'chapter_id')->where('status', 'active');
    }
}
