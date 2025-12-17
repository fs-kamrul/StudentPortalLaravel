<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'registration_id',
        'roll',
        'gpa',
        'status',
        'remarks',
        'payment_method',
        'bkash_transaction_id',
        'bkash_phone_number',
        'payment_amount',
        'payment_status',
    ];

    /**
     * Get the student that owns the testimonial.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => '#fbbf24',      // yellow
            'processing' => '#3b82f6',   // blue
            'completed' => '#10b981',    // green
            'delivered' => '#8b5cf6',    // purple
            default => '#6b7280',        // gray
        };
    }

    /**
     * Get status display name
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
