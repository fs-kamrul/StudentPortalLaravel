<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'student_id',
        'testimonial_id',
        'amount',
        'currency',
        'status',
        'transaction_id',
        'customer_msisdn',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class);
    }
}
