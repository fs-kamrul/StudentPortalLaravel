<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddMark extends Model
{
    protected $table = 'tbl_add_mark';
    protected $primaryKey = 'add_mark_id';
    public $timestamps = false;

    protected $fillable = [
        'add_mark_id',
        'sub_id',
        'mark_title',
        'mark_number',
        'mark_pass'
    ];

    /**
     * Get the subject info
     */
    public function subjectInfo()
    {
        return $this->belongsTo(SubjectInfo::class, 'sub_id', 'sub_id');
    }

    /**
     * Get the marks submitted for this component
     */
    public function markSubmissions()
    {
        return $this->hasMany(MarkSub::class, 'add_mark_id', 'add_mark_id');
    }
}
