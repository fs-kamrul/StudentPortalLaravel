<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInformation extends Model
{
    protected $table = 'student_information';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'reg_id',
        'name',
        'mobile_number',
        'father_name',
        'mother_name',
        'birth_bate',
        'photo',
        'division',
        'country',
        'zip_code',
        'village',
        'district'
    ];

    /**
     * Get the registration info for the student
     */
    public function registrationInfo()
    {
        return $this->belongsTo(RegistrationInfo::class, 'reg_id', 'reg_id');
    }
}
