<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkSub extends Model
{
    protected $table = 'tbl_mark_sub';
    protected $primaryKey = 'mark_id';
    public $timestamps = false;

    protected $fillable = [
        'mark_id',
        'all_reg_id',
        'sub_id',
        'add_mark_id',
        'term',
        'mark',
        'mark_pf'
    ];

    /**
     * Get the registration info
     */
    public function registrationInfo()
    {
        return $this->belongsTo(RegistrationInfo::class, 'all_reg_id', 'all_reg_id');
    }

    /**
     * Get the subject info
     */
    public function subjectInfo()
    {
        return $this->belongsTo(SubjectInfo::class, 'sub_id', 'sub_id');
    }

    /**
     * Get the mark component
     */
    public function markComponent()
    {
        return $this->belongsTo(AddMark::class, 'add_mark_id', 'add_mark_id');
    }
}
