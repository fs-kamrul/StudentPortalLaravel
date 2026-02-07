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
        Schema::table('cp_questions', function (Blueprint $table) {
            $table->foreignId('sub_question_a_id')->nullable()->after('sub_question_a')->constrained('cp_part_questions')->onDelete('set null');
            $table->foreignId('sub_question_b_id')->nullable()->after('sub_question_b')->constrained('cp_part_questions')->onDelete('set null');
            $table->foreignId('sub_question_c_id')->nullable()->after('sub_question_c')->constrained('cp_part_questions')->onDelete('set null');
            $table->foreignId('sub_question_d_id')->nullable()->after('sub_question_d')->constrained('cp_part_questions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cp_questions', function (Blueprint $table) {
            $table->dropForeign(['sub_question_a_id']);
            $table->dropColumn('sub_question_a_id');
            $table->dropForeign(['sub_question_b_id']);
            $table->dropColumn('sub_question_b_id');
            $table->dropForeign(['sub_question_c_id']);
            $table->dropColumn('sub_question_c_id');
            $table->dropForeign(['sub_question_d_id']);
            $table->dropColumn('sub_question_d_id');
        });
    }
};
