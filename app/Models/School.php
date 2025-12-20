<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'tbl_school';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        's_name',
        's_address',
        's_code',
        'email',
        'phone_number',
        'logo',
        'site_url',
        'favicon'
    ];
}
