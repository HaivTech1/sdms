<!DOCTYPE html>
<html>
<head>
    @section('title', $grade->title . " | Class Exam Result Report")
    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ public_path("fonts/Amiri-Regular.ttf") }}') format('truetype');
        }
        body {
            font-family: 'Amiri', Arial, Helvetica, sans-serif;
        }

        @page {
            margin: 0.5in;
            size: A4 portrait;
        }

        .page-break {
            page-break-after: avoid;
        }

        #body_content {
            position: relative;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bg_img {
            position: absolute;
            opacity: 0.1;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .header {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .header-item {
            display: table-cell;
            vertical-align: middle;
            text-align: center;    
        }

        .header-item:first-child {
            text-align: left;
            width: 10%
        }

        .header-item:last-child {
            text-align: right;
            width: 10%
        }

        .majorContainer {
            width: 100%;
            margin-bottom: 1em;
        }

        .majorContainer::after {
            content: '';
            display: table;
            clear: both;
            vertical-align: middle;
        }

        .mainContainer {
            float: left;
            width: 35%;
        }

        .minorContainer {
            float: right;
            width: 30%;
        }

        .affectiveContainer {
            float: left;
            width: 45%;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-table th,
        .result-table td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .result-item {
            font-size: 10px;
        }

        .rotate-header {
            display: inline-block;
            transform: rotate(-90deg);
            writing-mode: vertical-rl;
            white-space: nowrap;
            line-height: 1;
            vertical-align: middle;
            transform-origin: center;
            font-size: 8px;
            padding: 2px 0;
        }

        .comment-section {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .comment-section th,
        .comment-section td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 10px;
        }

        .comment-section th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .behavioral-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .behavioral-table th,
        .behavioral-table td {
            padding: 3px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 8px;
        }

        .behavioral-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @foreach($classData as $index => $studentData)
        @if($index > 0)
            <div style="page-break-before: always;"></div>
        @endif
        
        <div id="body_content">
            <div class="bg_img">
                <img src="{{ asset('storage/' .application('image')) }}" alt="{{ application('name') }}" width="320px">
            </div>

            <div>
                <div class="header">
                    <div class="header-item">
                        <img src="{{ public_path('storage/'.application('image')) }}" width="70" height="70" alt="Profile Image">
                    </div>
                    <div class="header-item">
                        <div style="font-weight: 900; text-align: center; text-transform: uppercase; font-size: 30px;">{{ application('name') }}</div>
                        <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                            {{ application('address') }}
                        </div>
                        <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                            {{ application('line1') }}, {{ application('line2') }}
                        </div>
                    </div>
                    <div class="header-item">
                        <img src="{{ public_path('storage/'.$studentData['student']->user->image()) }}" width="80" height="80" alt="{{ $studentData['student']->last_name }}">
                    </div>
                </div>

                <div style="margin: 10px 0">
                    <div style="font-weight: 500; text-align: center; text-transform: uppercase">REPORT SHEET FOR {{ $term->title() }} {{ $period->title() }} Academic Session</div>
                </div>

                <div class="majorContainer">
                    <div class="mainContainer">
                        <div class="result-item">
                            <b>Name:</b> <span>{{ ucfirst($studentData['student']->lastName()) }} {{ ucfirst($studentData['student']->firstName()) }} {{ ucfirst($studentData['student']->otherName()) }}</span>
                        </div>
                        <div class="result-item">
                            <b>Class:</b>
                            <span>{{ $grade->title()}}</span>
                        </div>
                        <div class="result-item">
                            <b>Students in class:</b>
                            <span>{{ $studentData['gradeStudentsCount'] ?? $grade->students->count()}}</span>
                        </div>
                    </div>
                    <div class="mainContainer">
                        <div class="result-item">
                            <b>No. of times school opened:</b>
                            <span>{{ $studentData['studentAttendance']->attendance_duration ?? 'N/A' }}</span>
                        </div>
                        <div class="result-item">
                            <b>No. of times present:</b>
                            <span>{{ $studentData['studentAttendance']->attendance_present ?? 'N/A' }}</span>
                        </div>
                        <div class="result-item">
                            <b>Age:</b>
                            <span>
                                @php
                                    $year = Carbon\Carbon::parse($studentData['student']->dob())->age
                                @endphp
                                {{$year}}
                            </span>
                        </div>
                    </div>
                    <div class="minorContainer">
                        <div class="result-item">
                            <b>Class Average:</b>
                            <span>{{ number_format($studentData['aggregate'], 2) }}%</span>
                        </div>
                        <div class="result-item">
                            <b>Position in class:</b>
                            <span>{{ $studentData['student']->position ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <table class="result-table">
                        <thead>
                            <tr>
                                <th style="width: 30%; text-align: left; padding-left: 10px;">Subjects</th>
                                @php
                                    $midtermFormat = get_settings('midterm_format');
                                    $examFormat = get_settings('exam_format');
                                @endphp
                                
                                @if(is_array($midtermFormat))
                                    @foreach($midtermFormat as $key => $value)
                                        <th style="width: 5%; font-size: 8px;">{{ $value['short_name'] ?? $key }}</th>
                                    @endforeach
                                @endif
                                
                                @if(is_array($examFormat))
                                    @foreach($examFormat as $key => $value)
                                        <th style="width: 5%; font-size: 8px;">{{ $value['short_name'] ?? $key }}</th>
                                    @endforeach
                                @endif
                                
                                <th style="width: 8%; font-size: 8px;">Total</th>
                                <th style="width: 8%; font-size: 8px;">Grade</th>
                                <th style="width: 8%; font-size: 8px;">Remark</th>
                                <th style="width: 8%; font-size: 8px;">Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalMarks = 0;
                                foreach($midtermFormat as $key => $value) {
                                    $totalMarks += $value['mark'] ?? 0;
                                }
                                foreach($examFormat as $key => $value) {
                                    $totalMarks += $value['mark'] ?? 0;
                                }
                            @endphp
                            
                            <tr style="color: green; font-weight: bold;">
                                <td style="text-align: left; padding-left: 10px; font-size: 8px;">Total Obtainable</td>
                                @if(is_array($midtermFormat))
                                    @foreach($midtermFormat as $key => $value)
                                        <td style="font-size: 8px;">{{ $value['mark'] ?? '' }}</td>
                                    @endforeach
                                @endif
                                
                                @if(is_array($examFormat))
                                    @foreach($examFormat as $key => $value)
                                        <td style="font-size: 8px;">{{ $value['mark'] ?? '' }}</td>
                                    @endforeach
                                @endif
                                
                                <td style="font-size: 8px;">{{ $totalMarks }}</td>
                                <td style="font-size: 8px;">-</td>
                                <td style="font-size: 8px;">-</td>
                                <td style="font-size: 8px;">-</td>
                            </tr>

                            @foreach($studentData['results'] as $result)
                                <tr>
                                    <td style="text-align: left; padding-left: 10px; font-size: 8px;">{{ $result['subject'] ?? 'N/A' }}</td>
                                    
                                    @if(is_array($midtermFormat))
                                        @foreach($midtermFormat as $key => $value)
                                            <td style="font-size: 8px;">{{ $result[$key] ?? '-' }}</td>
                                        @endforeach
                                    @endif
                                    
                                    @if(is_array($examFormat))
                                        @foreach($examFormat as $key => $value)
                                            <td style="font-size: 8px;">{{ $result[$key] ?? '-' }}</td>
                                        @endforeach
                                    @endif
                                    
                                    <td style="font-size: 8px;">{{ calculateResult($result) }}</td>
                                    <td style="font-size: 8px;">{{ getGrade(calculateResult($result)) }}</td>
                                    <td style="font-size: 8px;">{{ getRemark(calculateResult($result)) }}</td>
                                    <td style="font-size: 8px;">{{ $result['position_in_class_subject'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(!empty($studentData['psychomotors']) && $studentData['psychomotors']->count() > 0)
                    <div style="margin-top: 10px;">
                        <table class="behavioral-table">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center; font-size: 10px;">PSYCHOMOTOR DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Skills</th>
                                    <th style="text-align: center; width: 20%;">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentData['psychomotors'] as $psychomotor)
                                    <tr>
                                        <td style="text-align: left;">{{ $psychomotor->title }}</td>
                                        <td style="text-align: center;">{{ $psychomotor->rate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if(!empty($studentData['affectives']) && $studentData['affectives']->count() > 0)
                    <div style="margin-top: 10px;">
                        <table class="behavioral-table">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center; font-size: 10px;">AFFECTIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Traits</th>
                                    <th style="text-align: center; width: 20%;">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentData['affectives'] as $affective)
                                    <tr>
                                        <td style="text-align: left;">{{ $affective->title }}</td>
                                        <td style="text-align: center;">{{ $affective->rate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div style="margin-top: 10px;">
                    <table class="comment-section">
                        <thead>
                            <tr>
                                <th style="text-align: center;">COMMENTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Class Teacher's Comment:</strong><br>
                                    {{ $studentData['comment'] ?? 'No comment available.' }}
                                </td>
                            </tr>
                            @if(!empty($studentData['studentAttendance']->principal_comment))
                                <tr>
                                    <td>
                                        <strong>Principal's Comment:</strong><br>
                                        {{ $studentData['studentAttendance']->principal_comment }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>