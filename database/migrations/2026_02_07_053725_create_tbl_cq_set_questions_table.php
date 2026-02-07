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
        Schema::create('cp_set_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained('cp_sets')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('cp_questions')->onDelete('cascade');
            $table->integer('question_order')->default(0);
            $table->timestamps();
            
            // Ensure unique question-set combination
            $table->unique(['set_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp_set_questions');
    }
};
