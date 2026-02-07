<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CqSubject;
use App\Models\CqChapter;
use App\Models\CqQuestion;
use App\Models\CqSet;
use App\Models\ChapterQuestion;

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
        $ict = CqSubject::create([
            'subject_name' => 'ICT',
            'subject_code' => 'ICT-101',
            'class_level' => 'SSC',
            'description' => 'General ICT for Secondary School Certificate',
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
        $q_a = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'knowledge',
            'question_text' => 'ত্বরণ কাকে বলে?',
            'answer_text' => 'সময়ের সাথে বেগের পরিবর্তনের হারকে ত্বরণ বলে।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'comprehension',
            'question_text' => 'গাড়িটির ত্বরণ নির্ণয় কর।',
            'answer_text' => 'ত্বরণ, a = (v-u)/t। এখানে v=২০, u=০, t=৫। অতএব a = ৪ মি/সে^২।',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'application',
            'question_text' => 'উদ্দীপকের গাড়িটি ৫ সেকেন্ডে কত দূরত্ব অতিক্রম করবে তা নির্ণয় কর।',
            'answer_text' => 'দূরত্ব, s = ut + 0.5at^2 = 0*5 + 0.5*4*25 = ৫০ মিটার।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $q_d = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'higher_ability',
            'question_text' => 'গাড়িটির ত্বরণ দ্বিগুণ হলে একই সময়ে অতিক্রান্ত দূরত্ব কিভাবে পরিবর্তিত হবে - গাণিতিক বিশ্লেষণ কর।',
            'answer_text' => 'ত্বরণ দ্বিগুণ (৮) হলে s = 0.5*8*25 = ১০০ মিটার। অর্থাৎ দূরত্ব দ্বিগুণ হবে।',
            'marks' => 4,
            'status' => 'active',
        ]);

        $physicsQ1 = CqQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_stem' => 'একটি গাড়ি স্থির অবস্থা থেকে যাত্রা শুরু করে ৫ সেকেন্ডে ২০ মিটার/সেকেন্ড বেগ প্রাপ্ত হয়।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => $q_d->question_text,
            'sub_question_d_id' => $q_d->id,
            'sub_question_d_marks' => $q_d->marks,
            'total_marks' => 10.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        $q_a = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'knowledge',
            'question_text' => 'নিউটনের দ্বিতীয় সূত্রটি লিখ।',
            'answer_text' => 'বস্তুর ভরবেগের পরিবর্তনের হার তার উপর প্রযুক্ত বলের সমানুপাতিক এবং বল যেদিকে ক্রিয়া করে বস্তুর ভরবেগের পরিবর্তনও সেদিকে ঘটে।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'comprehension',
            'question_text' => 'বস্তুটির ত্বরণ নির্ণয় কর।',
            'answer_text' => 'F = ma, a = F/m = ৫০/১০ = ৫ মি/সে^২।',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'application',
            'question_text' => 'একই বল দিয়ে ২০ কেজি ভরের বস্তুর ত্বরণ কত হবে তা নির্ণয় কর।',
            'answer_text' => 'a = F/m = ৫০/২০ = ২.৫ মি/সে^২।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $q_d = ChapterQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_type' => 'higher_ability',
            'question_text' => 'বল ও ত্বরণের মধ্যে সম্পর্ক ব্যাখ্যা কর।',
            'answer_text' => 'বল ও ত্বরণ সমানুপাতিক (যদি ভর ধ্রুব থাকে)। অর্থাৎ প্রযুক্ত বল বাড়ালে ত্বরণ বাড়বে।',
            'marks' => 4,
            'status' => 'active',
        ]);

        $physicsQ2 = CqQuestion::create([
            'chapter_id' => $physicsChapter1->id,
            'question_stem' => 'একজন ব্যক্তি ১০ কেজি ভরের একটি বস্তুর উপর ৫০ নিউটন বল প্রয়োগ করলেন।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => $q_d->question_text,
            'sub_question_d_id' => $q_d->id,
            'sub_question_d_marks' => $q_d->marks,
            'total_marks' => 10.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        // Create Questions for Physics Chapter 2
        $q_a = ChapterQuestion::create([
            'chapter_id' => $physicsChapter2->id,
            'question_type' => 'knowledge',
            'question_text' => 'ক্ষমতা কাকে বলে?',
            'answer_text' => 'কাজ করার হারকে ক্ষমতা বলে।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $physicsChapter2->id,
            'question_type' => 'comprehension',
            'question_text' => 'পাম্পটির কৃতকাজ নির্ণয় কর।',
            'answer_text' => 'W = mgh = ১০০ * ৯.৮ * ১০ = ৯৮০০ জুল।',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $physicsChapter2->id,
            'question_type' => 'application',
            'question_text' => 'পাম্পটির ক্ষমতা কত তা নির্ণয় কর।',
            'answer_text' => 'P = W/t = ৯৮০০ / ৫০ = ১৯৬ ওয়াট।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $q_d = ChapterQuestion::create([
            'chapter_id' => $physicsChapter2->id,
            'question_type' => 'higher_ability',
            'question_text' => 'পাম্পটির দক্ষতা ৮০% হলে প্রকৃত ক্ষমতা কত হবে তা নির্ণয় কর।',
            'answer_text' => 'দক্ষতা = কার্যকর ক্ষমতা / প্রকৃত ক্ষমতা। অতএব প্রকৃত ক্ষমতা = ১৯৬ / ০.৮ = ২৪৫ ওয়াট।',
            'marks' => 4,
            'status' => 'active',
        ]);

        $physicsQ3 = CqQuestion::create([
            'chapter_id' => $physicsChapter2->id,
            'question_stem' => 'একটি পাম্প ১০০ লিটার পানি ১০ মিটার উচ্চতায় তুলতে ৫০ সেকেন্ড সময় নেয়।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => $q_d->question_text,
            'sub_question_d_id' => $q_d->id,
            'sub_question_d_marks' => $q_d->marks,
            'total_marks' => 10.00,
            'difficulty_level' => 'hard',
            'status' => 'active',
        ]);

        // Create Questions for Chemistry Chapter 1
        $q_a = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter1->id,
            'question_type' => 'knowledge',
            'question_text' => 'পদার্থের কয়টি অবস্থা আছে?',
            'answer_text' => 'পদার্থের প্রধানত তিনটি অবস্থা আছে: কঠিন, তরল ও বায়বীয়।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter1->id,
            'question_type' => 'comprehension',
            'question_text' => 'কঠিন পদার্থের বৈশিষ্ট্য লিখ।',
            'answer_text' => 'কঠিন পদার্থের নির্দিষ্ট আকার ও আয়তন থাকে। এর আন্তঃআণবিক আকর্ষণ বল অনেক বেশি।',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter1->id,
            'question_type' => 'application',
            'question_text' => 'পানি থেকে বরফে রূপান্তরের প্রক্রিয়া ব্যাখ্যা কর।',
            'answer_text' => 'শীতলীকরণের মাধ্যমে পানির তাপমাত্রা কমালে তা বরফে পরিণত হয়। একে ঘনীভবন ও কঠিনীভবন বলা হয়।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $q_d = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter1->id,
            'question_type' => 'higher_ability',
            'question_text' => 'তাপমাত্রা ও চাপের পরিবর্তনে পদার্থের অবস্থা পরিবর্তন বিশ্লেষণ কর।',
            'answer_text' => 'তাপ বাড়ালে কঠিন তরল হয় এবং তরল গ্যাসীয় হয়। চাপ বাড়ালে গ্যাসীয় পদার্থ তরল বা কঠিনে রূপান্তরিত হতে পারে।',
            'marks' => 4,
            'status' => 'active',
        ]);

        $chemistryQ1 = CqQuestion::create([
            'chapter_id' => $chemistryChapter1->id,
            'question_stem' => 'পানির তিনটি অবস্থা হলো কঠিন (বরফ), তরল (পানি) এবং বায়বীয় (জলীয়বাষ্প)।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => $q_d->question_text,
            'sub_question_d_id' => $q_d->id,
            'sub_question_d_marks' => $q_d->marks,
            'total_marks' => 10.00,
            'difficulty_level' => 'easy',
            'status' => 'active',
        ]);

        // Create Questions for Chemistry Chapter 2
        $q_a = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter2->id,
            'question_type' => 'knowledge',
            'question_text' => 'রাসায়নিক বিক্রিয়া কাকে বলে?',
            'answer_text' => 'যে প্রক্রিয়ায় এক বা একাধিক পদার্থ ভিন্ন গুণসম্পন্ন নতুন পদার্থে পরিণত হয় তাকে রাসায়নিক বিক্রিয়া বলে।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter2->id,
            'question_type' => 'comprehension',
            'question_text' => 'উদ্দীপকের বিক্রিয়াটির সমীকরণ লিখ।',
            'answer_text' => 'NaOH + HCl -> NaCl + H2O',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $chemistryChapter2->id,
            'question_type' => 'application',
            'question_text' => 'এটি কোন ধরনের বিক্রিয়া ব্যাখ্যা কর।',
            'answer_text' => 'এটি একটি প্রশমন বিক্রিয়া। এসিড ও ক্ষার বিক্রিয়া করে লবণ ও পানি উৎপন্ন করেছে।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $chemistryQ2 = CqQuestion::create([
            'chapter_id' => $chemistryChapter2->id,
            'question_stem' => 'সোডিয়াম হাইড্রক্সাইড এবং হাইড্রোক্লোরিক এসিডের বিক্রিয়ায় সোডিয়াম ক্লোরাইড এবং পানি উৎপন্ন হয়।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => null,
            'sub_question_d_id' => null,
            'sub_question_d_marks' => null,
            'total_marks' => 6.00,
            'difficulty_level' => 'medium',
            'status' => 'active',
        ]);

        // Create Questions for Biology Chapter 1
        $q_a = ChapterQuestion::create([
            'chapter_id' => $biologyChapter1->id,
            'question_type' => 'knowledge',
            'question_text' => 'কোষ কাকে বলে?',
            'answer_text' => 'জীবদেহের গঠন ও কাজের একককে কোষ বলে।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $biologyChapter1->id,
            'question_type' => 'comprehension',
            'question_text' => 'উদ্ভিদ কোষ ও প্রাণী কোষের মধ্যে পার্থক্য লিখ।',
            'answer_text' => 'উদ্ভিদ কোষে কোষপ্রাচীর থাকে কিন্তু প্রাণী কোষে থাকে না। উদ্ভিদ কোষে ক্লোরোপ্লাস্ট থাকে।',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $biologyChapter1->id,
            'question_type' => 'application',
            'question_text' => 'ক্লোরোপ্লাস্টের কাজ ব্যাখ্যা কর।',
            'answer_text' => 'ক্লোরোপ্লাস্ট সালোকসংশ্লেষণ প্রক্রিয়ার মাধ্যমে খাদ্য তৈরি করতে সাহায্য করে।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $q_d = ChapterQuestion::create([
            'chapter_id' => $biologyChapter1->id,
            'question_type' => 'higher_ability',
            'question_text' => 'কোষের বিভিন্ন অঙ্গাণুর গুরুত্ব বিশ্লেষণ কর।',
            'answer_text' => 'নিউক্লিয়াস কোষের প্রাণকেন্দ্র। মাইটোকন্ড্রিয়া কোষের শক্তিঘর। এগুলো ছাড়া কোষের তথ্য ও শক্তি প্রবাহ সম্ভব নয়।',
            'marks' => 4,
            'status' => 'active',
        ]);

        $biologyQ1 = CqQuestion::create([
            'chapter_id' => $biologyChapter1->id,
            'question_stem' => 'উদ্ভিদ কোষে কোষপ্রাচীর, কোষঝিল্লি, সাইটোপ্লাজম, নিউক্লিয়াস ও ক্লোরোপ্লাস্ট থাকে।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => $q_d->question_text,
            'sub_question_d_id' => $q_d->id,
            'sub_question_d_marks' => $q_d->marks,
            'total_marks' => 10.00,
            'difficulty_level' => 'easy',
            'status' => 'active',
        ]);

        // Create Questions for Biology Chapter 2
        $q_a = ChapterQuestion::create([
            'chapter_id' => $biologyChapter2->id,
            'question_type' => 'knowledge',
            'question_text' => 'সালোকসংশ্লেষণ কাকে বলে?',
            'answer_text' => 'সবুজ উদ্ভিদ সূর্যালোকের সাহায্যে নিজের খাদ্য নিজে তৈরি করার প্রক্রিয়াকে সালোকসংশ্লেষণ বলে।',
            'marks' => 1,
            'status' => 'active',
        ]);

        $q_b = ChapterQuestion::create([
            'chapter_id' => $biologyChapter2->id,
            'question_type' => 'comprehension',
            'question_text' => 'সালোকসংশ্লেষণের সমীকরণ লিখ।',
            'answer_text' => '6CO2 + 12H2O -> C6H12O6 + 6O2 + 6H2O',
            'marks' => 2,
            'status' => 'active',
        ]);

        $q_c = ChapterQuestion::create([
            'chapter_id' => $biologyChapter2->id,
            'question_type' => 'application',
            'question_text' => 'ক্লোরোফিলের ভূমিকা ব্যাখ্যা কর।',
            'answer_text' => 'ক্লোরোফিল সূর্যালোক শোষণ করে রাসায়নিক শক্তিতে রূপান্তর করতে সাহায্য করে।',
            'marks' => 3,
            'status' => 'active',
        ]);

        $q_d = ChapterQuestion::create([
            'chapter_id' => $biologyChapter2->id,
            'question_type' => 'higher_ability',
            'question_text' => 'সালোকসংশ্লেষণের পরিবেশগত গুরুত্ব বিশ্লেষণ কর।',
            'answer_text' => 'সালোকসংশ্লেষণ বায়ুর অক্সিজেন ও কার্বন ডাইঅক্সাইডের ভারসাম্য বজায় রাখে এবং সকল প্রাণীর খাদ্যের যোগান দেয়।',
            'marks' => 4,
            'status' => 'active',
        ]);

        $biologyQ2 = CqQuestion::create([
            'chapter_id' => $biologyChapter2->id,
            'question_stem' => 'সবুজ উদ্ভিদ সূর্যালোকের উপস্থিতিতে পানি ও কার্বন ডাইঅক্সাইড থেকে গ্লুকোজ তৈরি করে এবং অক্সিজেন নির্গত করে।',
            'sub_question_a' => $q_a->question_text,
            'sub_question_a_id' => $q_a->id,
            'sub_question_a_marks' => $q_a->marks,
            'sub_question_b' => $q_b->question_text,
            'sub_question_b_id' => $q_b->id,
            'sub_question_b_marks' => $q_b->marks,
            'sub_question_c' => $q_c->question_text,
            'sub_question_c_id' => $q_c->id,
            'sub_question_c_marks' => $q_c->marks,
            'sub_question_d' => $q_d->question_text,
            'sub_question_d_id' => $q_d->id,
            'sub_question_d_marks' => $q_d->marks,
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
