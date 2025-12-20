<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationInfo extends Model
{
    protected $table = 'tbl_all_registration_info';
    protected $primaryKey = 'all_reg_id';
    public $timestamps = false;

    protected $fillable = [
        'reg_id',
        'all_reg_id',
        'roll',
        'class',
        'section',
        'year',
        'group_r'
    ];

    /**
     * Get the student information
     */
    public function studentInformation()
    {
        return $this->hasMany(StudentInformation::class, 'reg_id', 'reg_id');
    }

    /**
     * Get the subject assignments
     */
    public function subjectAssignments()
    {
        return $this->hasMany(SubjectAssignment::class, 'all_reg_id', 'all_reg_id');
    }
}
