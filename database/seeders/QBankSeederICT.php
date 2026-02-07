<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CqSubject;
use App\Models\CqChapter;
use App\Models\ChapterQuestion;

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
        }

        $this->command->info('✓ ICT System seeded successfully!');
        $this->command->info('  - 1 Subject (ICT) created');
        $this->command->info('  - 8 Chapters created');
        $this->command->info('  - 160 Q&A Questions created (5 per type per chapter)');
    }
}
