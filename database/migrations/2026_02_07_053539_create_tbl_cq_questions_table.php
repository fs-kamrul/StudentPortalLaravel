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
        Schema::create('cp_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('cp_chapters')->onDelete('cascade');
            $table->text('question_stem');
            $table->text('sub_question_a');
            $table->decimal('sub_question_a_marks', 5, 2);
            $table->text('sub_question_b');
            $table->decimal('sub_question_b_marks', 5, 2);
            $table->text('sub_question_c');
            $table->decimal('sub_question_c_marks', 5, 2);
            $table->text('sub_question_d')->nullable();
            $table->decimal('sub_question_d_marks', 5, 2)->nullable();
            $table->decimal('total_marks', 5, 2);
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('medium');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp_questions');
    }
};
