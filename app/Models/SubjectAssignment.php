<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectAssignment extends Model
{
    protected $table = 'tbl_4sub';
    public $timestamps = false;

    protected $fillable = [
        'all_reg_id',
        'sub_id',
        'add_f'
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
}
