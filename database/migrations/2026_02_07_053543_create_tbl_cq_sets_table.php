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
        Schema::create('cp_sets', function (Blueprint $table) {
            $table->id();
            $table->string('set_name');
            $table->foreignId('subject_id')->constrained('cp_subjects')->onDelete('cascade');
            $table->string('exam_name');
            $table->date('exam_date')->nullable();
            $table->decimal('total_marks', 6, 2);
            $table->integer('duration_minutes')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp_sets');
    }
};
