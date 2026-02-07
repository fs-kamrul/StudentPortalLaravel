<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CqChapter;
use App\Models\ChapterQuestion;
use App\Models\CqQuestion;

class QBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = CqChapter::all();
        
        if ($chapters->isEmpty()) {
            $this->command->error('No chapters found to seed questions for. Run CqSystemSeeder first.');
            return;
        }

        $types = ['knowledge', 'comprehension', 'application', 'higher_ability'];
        
        $knowledgeQuestions = [
            'বেগ কাকে বলে?', 'ত্বরণ কী?', 'কাজ কাকে বলে?', 'ক্ষমতা কী?', 'শক্তির একক কী?',
            'কোষ কী?', 'নিউক্লিয়াস কী?', 'মাইটোকন্ড্রিয়া কী?', 'টিস্যু কাকে বলে?', 'অঙ্গ কী?',
            'পদার্থ কী?', 'পরমাণু কী?', 'অণু কাকে বলে?', 'যোজনী কী?', 'মৌল কী?',
            'ভর কাকে বলে?', 'ওজন কী?', 'চাপের একক কী?', 'ঘনত্ব কাকে বলে?', 'আধান কী?'
        ];

        $comprehensionQuestions = [
            'বেগের সাথে সময়ের সম্পর্ক ব্যাখ্যা কর।', 'ত্বরণ কেন সৃষ্টি হয়?', 'কাজ ও শক্তির মধ্যে পার্থক্য কী?', 'ক্ষমতা ও কাজের সম্পর্ক লিখ।',
            'উদ্ভিদ কোষ ও প্রাণী কোষের প্রধান পার্থক্য কী?', 'নিউক্লিয়াসের কাজ ব্যাখ্যা কর।', 'মাইটোকন্ড্রিয়াকে কোষের শক্তিঘর বলা হয় কেন?',
            'গ্যাসের প্রসারণ বেশি হয় কেন?', 'তাপ ও তাপমাত্রার মধ্যে পার্থক্য লিখ।', 'চাপ বাড়লে স্ফুটনাঙ্ক বাড়ে কেন?',
            'ঘর্ষণ কমানোর উপায় সমুহ ব্যাখ্যা কর।', 'শব্দের বেগ কঠিন মাধ্যমে বেশি কেন?', 'আলোর প্রতিফলনের সূত্র দুটি লিখ।'
        ];

        $applicationQuestions = [
            'একটি গাড়ির বেগ ৫ সেকেন্ডে ২০ মি/সে হলে ত্বরণ নির্ণয় কর।', '১০ কেজি ভরের বস্তুর ওজন নির্ণয় কর।', '৫০ জুল কাজ করতে কত শক্তি লাগে?',
            'উদ্ভিদ কীভাবে খাদ্য তৈরি করে তা বর্ণনা কর।', 'রক্তের কাজ কী কী?', 'শ্বসন প্রক্রিয়া কীভাবে ঘটে?',
            'লবণ ও বালির মিশ্রণ কীভাবে পৃথক করবে?', 'ইলেকট্রন বিন্যাস করে যোজনী নির্ণয় কর।', 'পানির ঘনত্ব বিশুদ্ধতার সাথে কীভাবে পরিবর্তিত হয়?',
            'একটি লিফটে ব্যক্তির ওজন কীভাবে পরিবর্তিত হয়?'
        ];

        $higherAbilityQuestions = [
            'বেগের পরিবর্তনের হার ধ্রুব থাকলে গতির প্রকৃতি বিশ্লেষণ কর।', 'শক্তির নিত্যতা সূত্রটি উদ্দীপকের আলোকে যাচাই কর।',
            'কোষ বিভাজন না হলে জীবের কী হতো? বিশ্লেষণ কর।', 'সালোকসংশ্লেষণ বন্ধ হলে পরিবেশের ওপর প্রভাব আলোচনা কর।',
            'রাসায়নিক বিক্রিয়ার গুরুত্ব আমাদের জীবনে কতটুকু? গাণিতিক যুক্তি দাও।', 'পর্যায় সারণীর ইলেকট্রন বিন্যাসের প্রভাব বিশ্লেষণ কর।',
            'জলবায়ু পরিবর্তনে সালোকসংশ্লেষণের হার কীভাবে প্রভাবিত হচ্ছে?', 'পারমাণবিক শক্তির ভবিষ্যৎ সম্ভাবনা মূল্যায়ন কর।'
        ];

        for ($i = 0; $i < 50; $i++) {
            $type = $types[array_rand($types)];
            $chapter = $chapters->random();
            
            $text = '';
            $answer = 'এটি একটি নমুনা উত্তর। সৃজনশীল প্রশ্নের উত্তর প্রদানের জন্য এই ক্ষেত্রটি ব্যবহার করা হয়। এখানে বিস্তারিত সমাধান প্রদান করা হয়েছে।';
            
            switch ($type) {
                case 'knowledge':
                    $text = $knowledgeQuestions[array_rand($knowledgeQuestions)];
                    break;
                case 'comprehension':
                    $text = $comprehensionQuestions[array_rand($comprehensionQuestions)];
                    break;
                case 'application':
                    $text = $applicationQuestions[array_rand($applicationQuestions)];
                    break;
                case 'higher_ability':
                    $text = $higherAbilityQuestions[array_rand($higherAbilityQuestions)];
                    break;
            }
            ChapterQuestion::create([
                'chapter_id' => $chapter->id,
                'question_type' => $type,
                'question_text' => $text . ' (নমুনা প্রশ্ন ' . ($i + 1) . ')',
                'answer_text' => $answer . ' উদাহরণস্বরূপ এই টেক্সটটি রাখা হয়েছে যাতে করে সিস্টেমে ডেটা দেখা যায়।',
                'marks' => $this->getMarks($type),
                'status' => 'active',
            ]);
        }

        // 2. Assemble some Creative Questions (CQs) using parts from the bank
        foreach ($chapters as $chapter) {
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
                        'question_stem' => "উদ্দীপক (সেট " . $k . "): " . $chapter->chapter_name . " এর ওপর ভিত্তি করে একটি সৃজনশীল প্রশ্ন।",
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

        $this->command->info('✓ 50 questions seeded in Question Bank.');
    }

    private function getMarks($type)
    {
        return match($type) {
            'knowledge' => 1,
            'comprehension' => 2,
            'application' => 3,
            'higher_ability' => 4,
            default => 1,
        };
    }
}
