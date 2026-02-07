<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CqSubject;
use App\Models\CqChapter;
use App\Models\ChapterQuestion;
use App\Models\CqQuestion;

class QBankSeederICT extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create ICT Subject
        $ict = CqSubject::firstOrCreate(
            ['subject_code' => 'ICT-101'],
            [
                'subject_name' => 'Information and Communication Technology (ICT)',
                'class_level' => 'HSC',
                'description' => 'Comprehensive ICT for Higher Secondary Certificate',
                'status' => 'active',
            ]
        );

        // 2. Chapter Names
        $chapterNames = [
            'Information & Communication Technology: World & Bangladesh Perspective',
            'Communication Systems & Networking',
            'Number Systems & Digital Logic',
            'Web Design & HTML',
            'Programming Language (C)',
            'Database Management System',
            'Multimedia & Graphics',
            'Cyber Security & Ethics'
        ];

        $types = ['knowledge', 'comprehension', 'application', 'higher_ability'];
        $marksMap = ['knowledge' => 1, 'comprehension' => 2, 'application' => 3, 'higher_ability' => 4];

        foreach ($chapterNames as $index => $name) {
            $chapterNumber = $index + 1;
            
            // Create Chapter
            $chapter = CqChapter::create([
                'subject_id' => $ict->id,
                'chapter_number' => $chapterNumber,
                'chapter_name' => $name,
                'description' => 'Chapter ' . $chapterNumber . ' for ICT subject.',
                'status' => 'active',
            ]);

            foreach ($types as $type) {
                for ($i = 1; $i <= 5; $i++) {
                    $questionText = "";
                    $answerText = "এটি হলো অধ্যায় " . $chapterNumber . " এর একটি নমুনা উত্তর। এই উত্তরটি স্বয়ংক্রিয়ভাবে জেনারেট করা হয়েছে ভেরিফিকেশন করার জন্য।";

                    // Simple pattern-based question generation to ensure variety
                    switch ($type) {
                        case 'knowledge':
                            $knowledgeList = ['ডেটা কী?', 'আইসিটি কাকে বলে?', 'ব্যান্ডউইথ কী?', 'কম্পাইলার কী?', 'আইপি অ্যাড্রেস কী?', 'সার্ভার কী?', 'এইচটিএমএল কী?', 'সফটওয়্যার কী?'];
                            $questionText = $knowledgeList[($index + $i) % count($knowledgeList)];
                            break;
                        case 'comprehension':
                            $questionText = "অধ্যায় " . $chapterNumber . " এর আলোকে " . ($i % 2 == 0 ? "এর ব্যবহার ব্যাখ্যা কর।" : "এর গুরুত্ব আলোচনা কর।");
                            break;
                        case 'application':
                            $questionText = "উদ্দীপকের তথ্যানুযায়ী " . $name . " এর প্রয়োগ দেখাও। (নমুনা " . $i . ")";
                            break;
                        case 'higher_ability':
                            $questionText = "বর্তমান প্রেক্ষাপটে " . $name . " এর প্রভাব বিশ্লেষণ কর এবং যুক্তিসহ তোমার মতামত দাও।";
                            break;
                    }

                    ChapterQuestion::create([
                        'chapter_id' => $chapter->id,
                        'question_type' => $type,
                        'question_text' => $questionText . " [Ch-" . $chapterNumber . ", Set-" . $i . "]",
                        'answer_text' => $answerText . " এখানে আমরা বিস্তারিত " . $type . " ভিত্তিক বিশ্লেষণ করেছি।",
                        'marks' => $marksMap[$type],
                        'status' => 'active',
                    ]);
                }
            }

            // 3. Create sample Creative Questions (CQs) using parts from bank
            for ($k = 1; $k <= 2; $k++) {
                $q_a = ChapterQuestion::where('chapter_id', $chapter->id)->where('question_type', 'knowledge')->inRandomOrder()->first();
                $q_b = ChapterQuestion::where('chapter_id', $chapter->id)->where('question_type', 'comprehension')->inRandomOrder()->first();
                $q_c = ChapterQuestion::where('chapter_id', $chapter->id)->where('question_type', 'application')->inRandomOrder()->first();
                $q_d = ChapterQuestion::where('chapter_id', $chapter->id)->where('question_type', 'higher_ability')->inRandomOrder()->first();

                if ($q_a && $q_b && $q_c) {
                    $marks_a = $q_a->marks;
                    $marks_b = $q_b->marks;
                    $marks_c = $q_c->marks;
                    $marks_d = $q_d ? $q_d->marks : 0;

                    CqQuestion::create([
                        'chapter_id' => $chapter->id,
                        'question_stem' => "এটি অধ্যায় " . $chapterNumber . " এর একটি নমুনা উদ্দীপক (Set " . $k . ")। এই সৃজনশীল প্রশ্নটি ব্যাংক থেকে তৈরি করা হয়েছে।",
                        'sub_question_a' => $q_a->question_text,
                        'sub_question_a_id' => $q_a->id,
                        'sub_question_a_marks' => $marks_a,
                        'sub_question_b' => $q_b->question_text,
                        'sub_question_b_id' => $q_b->id,
                        'sub_question_b_marks' => $marks_b,
                        'sub_question_c' => $q_c->question_text,
                        'sub_question_c_id' => $q_c->id,
                        'sub_question_c_marks' => $marks_c,
                        'sub_question_d' => $q_d ? $q_d->question_text : null,
                        'sub_question_d_id' => $q_d ? $q_d->id : null,
                        'sub_question_d_marks' => $marks_d,
                        'total_marks' => $marks_a + $marks_b + $marks_c + $marks_d,
                        'difficulty_level' => 'medium',
                        'status' => 'active',
                    ]);
                }
            }
        }

        $this->command->info('✓ ICT System seeded successfully!');
        $this->command->info('  - 1 Subject (ICT) created');
        $this->command->info('  - 8 Chapters created');
        $this->command->info('  - 160 Q&A Questions created in Bank');
        $this->command->info('  - 16 Creative Questions (CQs) assembled from Bank');
    }
}
