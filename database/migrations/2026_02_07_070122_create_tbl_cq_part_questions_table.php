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
        Schema::create('tbl_cq_part_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained('tbl_cq_chapters')->onDelete('cascade');
            $table->enum('question_type', ['knowledge', 'comprehension', 'application', 'higher_ability']);
            $table->text('question_text');
            $table->longText('answer_text');
            $table->integer('marks');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_cq_part_questions');
    }
};
