<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectInfo extends Model
{
    protected $table = 'tbl_subject_info';
    protected $primaryKey = 'sub_id';
    public $timestamps = false;

    protected $fillable = [
        'sub_id',
        'sub_code',
        'sub_name',
        'sub_mark',
        'pass_mark',
        'group_r'
    ];

    /**
     * Get the subject assignments
     */
    public function subjectAssignments()
    {
        return $this->hasMany(SubjectAssignment::class, 'sub_id', 'sub_id');
    }

    /**
     * Get the mark components for this subject
     */
    public function markComponents()
    {
        return $this->hasMany(AddMark::class, 'sub_id', 'sub_id');
    }
}
