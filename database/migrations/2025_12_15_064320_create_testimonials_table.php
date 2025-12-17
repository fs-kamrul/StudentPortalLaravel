<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('student_id'); // Foreign key to student_information.id
            $table->string('registration_id');
            $table->string('roll');
            $table->decimal('gpa', 3, 2); // e.g., 3.75
            $table->enum('status', ['pending', 'processing', 'completed', 'delivered'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // Index for faster queries
            $table->index('student_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
