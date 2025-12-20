<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Result extends Model
{
    /**
     * Get available options for session years and exam types
     */
    public static function getOptions()
    {
        // Get sessions from OptionA
        $sessions = OptionA::getOptions('year');

        // Get exam types from OptionA
        $examTypesRaw = OptionA::getOptions('term');
        
        // Convert to associative array for dropdown
        $examTypes = [];
        foreach ($examTypesRaw as $term) {
            $examTypes[$term] = ucfirst(str_replace('_', ' ', $term));
        }

        return [
            'sessions' => $sessions,
            'exam_types' => $examTypes
        ];
    }

    /**
     * Get student basic information
     */
    public static function getStudentInfo($data)
    {
        return StudentInformation::select(
                'student_information.id',
                'student_information.name',
                'tbl_all_registration_info.roll',
                'tbl_all_registration_info.reg_id',
                'tbl_all_registration_info.all_reg_id',
                'tbl_all_registration_info.class',
                'tbl_all_registration_info.section',
                'tbl_all_registration_info.year',
                'tbl_all_registration_info.group_r'
            )
            ->join('tbl_all_registration_info', 'student_information.reg_id', '=', 'tbl_all_registration_info.reg_id')
            ->where('student_information.id', $data['studentID'])
            ->where('tbl_all_registration_info.year', $data['session'])
            ->first();
    }

    /**
     * Get subject results with all mark details
     */
    public static function getSubjectResults($data)
    {
        return DB::table('student_information as stu_info')
            ->select(
                'marksub.mark',
                'marksub.mark_pf',
                'marksub.mark_id',
                'addm.mark_title',
                'addm.mark_number',
                'addm.mark_pass',
                'sub.sub_name',
                'sub.sub_code',
                'sub.sub_mark',
                'sub.pass_mark',
                'tbl_4sub.add_f',
                'stu_info.id',
                'stu_info.name',
                'stu_info.mobile_number',
                'stu_info.father_name',
                'stu_info.mother_name',
                'stu_info.birth_bate',
                'stu_info.photo',
                'stu_info.division',
                'stu_info.country',
                'stu_info.zip_code',
                'stu_info.village',
                'stu_info.district',
                'reg_info.roll',
                'reg_info.reg_id',
                'reg_info.all_reg_id',
                'reg_info.class',
                'reg_info.section',
                'reg_info.year',
                'reg_info.group_r'
            )
            ->join('tbl_all_registration_info as reg_info', 'stu_info.reg_id', '=', 'reg_info.reg_id')
            ->join('tbl_4sub', 'tbl_4sub.all_reg_id', '=', 'reg_info.all_reg_id')
            ->join('tbl_subject_info as sub', 'sub.sub_id', '=', 'tbl_4sub.sub_id')
            ->join('tbl_add_mark as addm', function($join) {
                $join->on('addm.sub_id', '=', 'sub.sub_id')
                     ->on('addm.sub_id', '=', 'tbl_4sub.sub_id');
            })
            ->join('tbl_mark_sub as marksub', function($join) {
                $join->on('marksub.all_reg_id', '=', 'reg_info.all_reg_id')
                     ->on('addm.add_mark_id', '=', 'marksub.add_mark_id')
                     ->on('marksub.sub_id', '=', 'sub.sub_id');
            })
            ->where('stu_info.id', $data['studentID'])
            ->where('reg_info.year', $data['session'])
            ->where('marksub.term', $data['exam_type'])
            ->orderBy('sub.sub_id', 'ASC')
            ->get();
    }
}
