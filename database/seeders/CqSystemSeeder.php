<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CqSubject;
use App\Models\CqChapter;
use App\Models\CqQuestion;
use App\Models\CqSet;

class CqSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Subjects
        $physics = CqSubject::create([
            'subject_name' => 'Physics',
            'subject_code' => 'PHY-101',
            'class_level' => 'SSC',
            'description' => 'General Physics for Secondary School Certificate',
            'status' => 'active',
        ]);

        $chemistry = CqSubject::create([
            'subject_name' => 'Chemistry',
            'subject_code' => 'CHM-101',
            'class_level' => 'SSC',
            'description' => 'General Chemistry for Secondary School Certificate',
            'status' => 'active',
        ]);

        $biology = CqSubject::create([
            'subject_name' => 'Biology',
            'subject_code' => 'BIO-101',
            'class_level' => 'SSC',
            'description' => 'General Biology for Secondary School Certificate',
            'status' => 'active',
        ]);

        $mathematics = CqSubject::create([
            'subject_name' => 'Mathematics',
            'subject_code' => 'MAT-101',
            'class_level' => 'SSC',
            'description' => 'General Mathematics for Secondary School Certificate',
            'status' => 'active',
        ]);

        // Create Chapters for Physics
        $physicsChapter1 = CqChapter::create([
            'subject_id' => $physics->id,
            'chapter_number' => 1,
            'chapter_name' => 'Motion and Force',
            'description' => 'Study of motion, velocity, acceleration and Newton\'s laws',
            'status' => 'active',
        ]);

        $physicsChapter2 = CqChapter::create([
            'subject_id' => $physics->id,
            'chapter_number' => 2,
            'chapter_name' => 'Energy and Power',
            'description' => 'Various forms of energy and power calculations',
            'status' => 'active',
        ]);

        // Create Chapters for Chemistry
        $chemistryChapter1 = CqChapter::create([
            'subject_id' => $chemistry->id,
            'chapter_number' => 1,
            'chapter_name' => 'Matter and its Properties',
            'description' => 'States of matter and their characteristics',
            'status' => 'active',
        ]);

        $chemistryChapter2 = CqChapter::create([
            'subject_id' => $chemistry->id,
            'chapter_number' => 2,
            'chapter_name' => 'Chemical Reactions',
            'description' => 'Types of chemical reactions and their applications',
            'status' => 'active',
        ]);

        // Create Chapters for Biology
        $biologyChapter1 = CqChapter::create([
            'subject_id' => $biology->id,
            'chapter_number' => 1,
            'chapter_name' => 'Cell Structure',
            'description' => 'Study of cellular components and functions',
            'status' => 'active',
        ]);

        $biologyChapter2 = CqChapter::create([
            'subject_id' => $biology->id,
            'chapter_number' => 2,
            'chapter_name' => 'Photosynthesis',
            'description' => 'Process of photosynthesis in plants',
            'status' => 'active',
        ]);

        // Create Questions for Physics Chapter 1
        $physicsQ1 = CqQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_stem' => 'একটি গাড়ি স্থির অবস্থা থেকে যাত্রা শুরু করে ৫ সেকেন্ডে ২০ মিটার/সেকেন্ড বেগ প্রাপ্ত হয়।',
            'sub_question_a' => 'ত্বরণ কাকে বলে?',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'গাড়িটির ত্বরণ নির্ণয় কর।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'উদ্দীপকের গাড়িটি ৫ সেকেন্ডে কত দূরত্ব অতিক্রম করবে তা নির্ণয় কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => 'গাড়িটির ত্বরণ দ্বিগুণ হলে একই সময়ে অতিক্রান্ত দূরত্ব কিভাবে পরিবর্তিত হবে - গাণিতিক বিশ্লেষণ কর।',
            'sub_question_d_marks' => 4.00,
            'total_marks' => 10.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        $physicsQ2 = CqQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_stem' => 'একজন ব্যক্তি ১০ কেজি ভরের একটি বস্তুর উপর ৫০ নিউটন বল প্রয়োগ করলেন।',
            'sub_question_a' => 'নিউটনের দ্বিতীয় সূত্রটি লিখ।',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'বস্তুটির ত্বরণ নির্ণয় কর।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'একই বল দিয়ে ২০ কেজি ভরের বস্তুর ত্বরণ কত হবে তা নির্ণয় কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => 'বল ও ত্বরণের মধ্যে সম্পর্ক ব্যাখ্যা কর।',
            'sub_question_d_marks' => 4.00,
            'total_marks' => 10.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        // Create Questions for Physics Chapter 2
        $physicsQ3 = CqQuestion::create([
            'chapter_id' => $physicsChapter2->id,
            'question_stem' => 'একটি পাম্প ১০০ লিটার পানি ১০ মিটার উচ্চতায় তুলতে ৫০ সেকেন্ড সময় নেয়।',
            'sub_question_a' => 'ক্ষমতা কাকে বলে?',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'পাম্পটির কৃতকাজ নির্ণয় কর।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'পাম্পটির ক্ষমতা কত তা নির্ণয় কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => 'পাম্পটির দক্ষতা ৮০% হলে প্রকৃত ক্ষমতা কত হবে তা নির্ণয় কর।',
            'sub_question_d_marks' => 4.00,
            'total_marks' => 10.00,
            'difficulty_level' => 'hard',
            'status' => 'active',
        ]);

        // Create Questions for Chemistry Chapter 1
        $chemistryQ1 = CqQuestion::create([
            'chapter_id' => $chemistryChapter1->id,
            'question_stem' => 'পানির তিনটি অবস্থা হলো কঠিন (বরফ), তরল (পানি) এবং বায়বীয় (জলীয়বাষ্প)।',
            'sub_question_a' => 'পদার্থের কয়টি অবস্থা আছে?',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'কঠিন পদার্থের বৈশিষ্ট্য লিখ।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'পানি থেকে বরফে রূপান্তরের প্রক্রিয়া ব্যাখ্যা কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => 'তাপমাত্রা ও চাপের পরিবর্তনে পদার্থের অবস্থা পরিবর্তন বিশ্লেষণ কর।',
            'sub_question_d_marks' => 4.00,
            'total_marks' => 10.00,
            'difficulty_level' => 'easy',
            'status' => 'active',
        ]);

        // Create Questions for Chemistry Chapter 2
        $chemistryQ2 = CqQuestion::create([
            'chapter_id' => $chemistryChapter2->id,
            'question_stem' => 'সোডিয়াম হাইড্রক্সাইড এবং হাইড্রোক্লোরিক এসিডের বিক্রিয়ায় সোডিয়াম ক্লোরাইড এবং পানি উৎপন্ন হয়।',
            'sub_question_a' => 'রাসায়নিক বিক্রিয়া কাকে বলে?',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'উদ্দীপকের বিক্রিয়াটির সমীকরণ লিখ।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'এটি কোন ধরনের বিক্রিয়া ব্যাখ্যা কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => null,
            'sub_question_d_marks' => null,
            'total_marks' => 6.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        // Create Questions for Biology Chapter 1
        $biologyQ1 = CqQuestion::create([
            'chapter_id' => $biologyChapter1->id,
            'question_stem' => 'উদ্ভিদ কোষে কোষপ্রাচীর, কোষঝিল্লি, সাইটোপ্লাজম, নিউক্লিয়াস ও ক্লোরোপ্লাস্ট থাকে।',
            'sub_question_a' => 'কোষ কাকে বলে?',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'উদ্ভিদ কোষ ও প্রাণী কোষের মধ্যে পার্থক্য লিখ।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'ক্লোরোপ্লাস্টের কাজ ব্যাখ্যা কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => 'কোষের বিভিন্ন অঙ্গাণুর গুরুত্ব বিশ্লেষণ কর।',
            'sub_question_d_marks' => 4.00,
            'total_marks' => 10.00,
            'difficulty_level' => 'easy',
            'status' => 'active',
        ]);

        // Create Questions for Biology Chapter 2
        $biologyQ2 = CqQuestion::create([
            'chapter_id' => $biologyChapter2->id,
            'question_stem' => 'সবুজ উদ্ভিদ সূর্যালোকের উপস্থিতিতে পানি ও কার্বন ডাইঅক্সাইড থেকে গ্লুকোজ তৈরি করে এবং অক্সিজেন নির্গত করে।',
            'sub_question_a' => 'সালোকসংশ্লেষণ কাকে বলে?',
            'sub_question_a_marks' => 1.00,
            'sub_question_b' => 'সালোকসংশ্লেষণের সমীকরণ লিখ।',
            'sub_question_b_marks' => 2.00,
            'sub_question_c' => 'ক্লোরোফিলের ভূমিকা ব্যাখ্যা কর।',
            'sub_question_c_marks' => 3.00,
            'sub_question_d' => 'সালোকসংশ্লেষণের পরিবেশগত গুরুত্ব বিশ্লেষণ কর।',
            'sub_question_d_marks' => 4.00,
            'total_marks' => 10.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        // Create Question Sets
        $physicsSet = CqSet::create([
            'set_name' => 'Physics Model Test - 1',
            'subject_id' => $physics->id,
            'exam_name' => 'SSC Model Test 2026',
            'exam_date' => '2026-03-15',
            'total_marks' => 0, // Will be calculated
            'duration_minutes' => 180,
            'instructions' => 'সকল প্রশ্নের উত্তর দিতে হবে। প্রতিটি প্রশ্নের মান প্রশ্নের শেষে উল্লেখ করা আছে।',
            'status' => 'published',
        ]);

        // Attach questions to the set
        $physicsSet->questions()->attach([
            $physicsQ1->id => ['question_order' => 1],
            $physicsQ2->id => ['question_order' => 2],
            $physicsQ3->id => ['question_order' => 3],
        ]);

        // Update total marks
        $physicsSet->total_marks = $physicsSet->calculateTotalMarks();
        $physicsSet->save();

        $chemistrySet = CqSet::create([
            'set_name' => 'Chemistry Model Test - 1',
            'subject_id' => $chemistry->id,
            'exam_name' => 'SSC Model Test 2026',
            'exam_date' => '2026-03-16',
            'total_marks' => 0,
            'duration_minutes' => 180,
            'instructions' => 'সকল প্রশ্নের উত্তর দিতে হবে। প্রতিটি প্রশ্নের মান প্রশ্নের শেষে উল্লেখ করা আছে।',
            'status' => 'draft',
        ]);

        $chemistrySet->questions()->attach([
            $chemistryQ1->id => ['question_order' => 1],
            $chemistryQ2->id => ['question_order' => 2],
        ]);

        $chemistrySet->total_marks = $chemistrySet->calculateTotalMarks();
        $chemistrySet->save();

        $this->command->info('✓ CQ System seeded successfully!');
        $this->command->info('  - 4 Subjects created');
        $this->command->info('  - 6 Chapters created');
        $this->command->info('  - 8 Questions created');
        $this->command->info('  - 2 Question Sets created');
    }
}
