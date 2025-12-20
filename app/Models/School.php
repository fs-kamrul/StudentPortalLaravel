<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'tbl_school';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'school_name',
        'logo',
        'address',
        'mobile',
        'email'
    ];
}
