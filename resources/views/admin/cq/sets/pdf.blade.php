<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $set->set_name }}</title>
    <style>
        @font-face {
            font-family: 'BengaliFont';
            src: url('{{ public_path("fonts/NotoSerifBengali.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'BengaliFont', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .exam-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .subject-name {
            font-size: 12pt;
            margin-bottom: 5px;
        }
        .info-box {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 4px 0;
            margin-top: 5px;
            width: 100%;
        }
        .info-left {
            float: left;
            width: 50%;
        }
        .info-right {
            float: right;
            width: 50%;
            text-align: right;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .instructions {
            margin-top: 8px;
            font-size: 9pt;
            text-align: left;
            font-style: italic;
        }
        .question-container {
            margin-top: 15px;
            page-break-inside: avoid;
        }
        .question-header {
            width: 100%;
            margin-bottom: 5px;
        }
        .question-number {
            float: left;
            width: 3%;
            font-weight: bold;
        }
        .question-content {
            float: left;
            width: 97%;
        }
        .stem {
            margin-bottom: 8px;
            text-align: justify;
        }
        .sub-questions-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sub-q-text {
            width: 95%;
            padding: 1px 0;
        }
        .sub-q-marks {
            width: 5%;
            text-align: right;
            padding: 1px 0;
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 0.5px solid #ccc;
        }
        @page {
            margin: 0.5in;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="exam-name">{{ $set->exam_name }}</div>
        <div class="subject-name">{{ $set->subject->subject_name }}</div>
        
        <div class="info-box clearfix">
            <div class="info-left">
                <strong>সময়:</strong> {{ $set->duration_minutes }} মিনিট
            </div>
            <div class="info-right">
                <strong>পূর্ণমান:</strong> {{ number_format($set->total_marks, 0) }}
            </div>
        </div>

        @if($set->instructions)
        <div class="instructions">
            <strong>নির্দেশনা:</strong> {{ $set->instructions }}
        </div>
        @endif
    </div>

    <div class="body">
        @foreach($set->questions->sortBy('pivot.question_order') as $question)
            <div class="question-container clearfix">
                <div class="question-number">{{ $loop->iteration }}.</div>
                <div class="question-content">
                    <div class="stem">{!! nl2br(e($question->question_stem)) !!}</div>
                    
                    <table class="sub-questions-table">
                        <tr>
                            <td class="sub-q-text">ক) {{ $question->sub_question_a }}</td>
                            <td class="sub-q-marks">{{ intval($question->sub_question_a_marks) }}</td>
                        </tr>
                        <tr>
                            <td class="sub-q-text">খ) {{ $question->sub_question_b }}</td>
                            <td class="sub-q-marks">{{ intval($question->sub_question_b_marks) }}</td>
                        </tr>
                        <tr>
                            <td class="sub-q-text">গ) {{ $question->sub_question_c }}</td>
                            <td class="sub-q-marks">{{ intval($question->sub_question_c_marks) }}</td>
                        </tr>
                        @if($question->sub_question_d)
                        <tr>
                            <td class="sub-q-text">ঘ) {{ $question->sub_question_d }}</td>
                            <td class="sub-q-marks">{{ intval($question->sub_question_d_marks) }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        Generated by StudentPortal Creative Question System
    </div>
</body>
</html>
