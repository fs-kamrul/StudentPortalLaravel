<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\CqQuestion;
use App\Models\ChapterQuestion;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all creative questions that don't have links yet
        $questions = CqQuestion::whereNull('sub_question_a_id')
            ->orWhereNull('sub_question_b_id')
            ->orWhereNull('sub_question_c_id')
            ->orWhereNull('sub_question_d_id')
            ->get();

        foreach ($questions as $cq) {
            $updated = false;

            // Link part A
            if ($cq->sub_question_a && !$cq->sub_question_a_id) {
                // Try to find exact text match in the same chapter
                $part = ChapterQuestion::where('chapter_id', $cq->chapter_id)
                    ->where('question_text', $cq->sub_question_a)
                    ->first();
                if ($part) {
                    $cq->sub_question_a_id = $part->id;
                    $updated = true;
                }
            }
            
            // Link part B
            if ($cq->sub_question_b && !$cq->sub_question_b_id) {
                $part = ChapterQuestion::where('chapter_id', $cq->chapter_id)
                    ->where('question_text', $cq->sub_question_b)
                    ->first();
                if ($part) {
                    $cq->sub_question_b_id = $part->id;
                    $updated = true;
                }
            }

            // Link part C
            if ($cq->sub_question_c && !$cq->sub_question_c_id) {
                $part = ChapterQuestion::where('chapter_id', $cq->chapter_id)
                    ->where('question_text', $cq->sub_question_c)
                    ->first();
                if ($part) {
                    $cq->sub_question_c_id = $part->id;
                    $updated = true;
                }
            }

            // Link part D
            if ($cq->sub_question_d && !$cq->sub_question_d_id) {
                $part = ChapterQuestion::where('chapter_id', $cq->chapter_id)
                    ->where('question_text', $cq->sub_question_d)
                    ->first();
                if ($part) {
                    $cq->sub_question_d_id = $part->id;
                    $updated = true;
                }
            }

            if ($updated) {
                $cq->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No practical reverse action needed besides clearing IDs, 
        // but it's better to keep links once established.
    }
};
