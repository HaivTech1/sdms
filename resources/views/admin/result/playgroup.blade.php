<!DOCTYPE html>
<html>
<head>
    @section('title', $student->last_name." | Exam Result Page")
    <style>
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
            width: 40%;
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

        .beh-d th, beh-d td{
            padding: 2px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-item {
            font-size: 15px;
        }

        .affect-table {
            width: 100%;
            border-collapse: collapse;
        }

        .affect-table th,
        .affect-table td {
            padding: 2px;
            border: 1px solid #000;
            text-align: center;
        }

        .affect-table th {
            background-color: #f2f2f2;
        }

        .affect-item {
            font-size: 8px;
        }

        .rotate-header {
            transform: rotate(270deg);
            writing-mode: vertical-rl;
            white-space: nowrap;
            {{-- font-size: 8px !important; --}}
            {{-- font-weight: bold; --}}
            vertical-align: middle;
            {{-- font-weight: 900; --}}
            {{-- width: 70px; --}}
            transform-origin: bottom right;
            {{-- padding: 5px 0; --}}
            text-orientation: mixed;
        }
    </style>
</head>
<body>
    <div id="body_content">
        <div class="bg_img">
            <img src="{{ asset('storage/' .application('image')) }}" alt="{{ application('name') }}" width="300px">
        </div>

        <div>
            <div class="header">
                <div class="header-item">
                    <img src="{{ public_path('storage/'.application('image')) }}" width="70" height="70" alt="Profile Image">
                </div>
                <div class="header-item">
                    <div style="font-weight: bold; text-align: center; text-transform: uppercase">{{ application('name') }}</div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        {{ application('address') }}
                    </div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        {{ application('line1') }}, {{ application('line2') }}
                    </div>
                </div>
                <div class="header-item">
                    <img src="{{ public_path('storage/'.$student->user->image()) }}" width="70" height="70" alt="{{ $student->last_name }}">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: 500; text-align: center; text-transform: uppercase">Terminal Evaluation Report Sheet</div>
                <div style="font-weight: 500; text-align: center; text-transform: uppercase">{{ $term->title() }} {{ $period->title() }} Academic Session</div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Name:</b> <span>{{ ucfirst($student->lastName()) }} {{ ucfirst($student->firstName()) }} {{ ucfirst($student->otherName()) }}</span>
                    </div>
                    <div class="result-item">
                        <b>Admission No.:</b>
                        <span>{{ $student->user->code()}}</span>
                    </div>
                    <div class="result-item">
                        <b>Class:</b>
                        <span>{{ $student->grade->title()}}</span>
                    </div>
                    <div class="result-item">
                        <b>Students in class:</b>
                        <span>{{ $student->grade->students->count()}}</span>
                    </div>
                </div>
                <div class="minorContainer">
                    <div class="result-item">
                        <b>No. of times school opened:</b>
                        <span>{{ $studentAttendance->attendance_duration ?? ''}}</span>
                    </div>
                    <div class="result-item">
                        <b>No. of times present:</b>
                        <span>{{ $studentAttendance->attendance_present ?? '' }}</span>
                    </div>
                    <div class="result-item">
                        <b>Attendance Average:</b>
                        <span>{{ number_format(calculatePercentage($studentAttendance->attendance_present ?? 0, $studentAttendance->attendance_duration ?? 0, 100), 1) ?? '' }}%</span>
                    </div>
                </div>
            </div>

            <div class="table-wrapper table-responsive" style="margin: 5px 0">
                <table class="result-table">
                    <thead>
                        <tr>
                            <th colspan="6" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">PHYSICAL DEVELOPMENT</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th colspan="2" class="v-align">Height (m)</th>
                            <th colspan="2">Width (kg)</th>
                            <th rowspan="2" style="width: 20%"> </th>
                            <th rowspan="2" style="font-size: 8px">Nature of Illness</th>
                        </tr>
                        <tr>
                            <td style="font-size: 8px">Beginning of Term</td>
                            <td style="font-size: 8px">End of Term</td>
                            <td style="font-size: 8px">Beginning of Term</td>
                            <td style="font-size: 8px">End of Term</td>
                        
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td colspan="2"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <table class="result-table">
                    <thead id="ch">
                        <tr>
                            <th colspan="3" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                        </tr>
                        <tr>
                            <th style="width: 20%; font-weight: 900;">Subjects</th>
                            <th style="font-weight: 900; text-align: center">Activity</th>
                            <th style="font-weight: 900; text-align: center">Teacher's Remarks</th>
                        </tr>
                    </thead>
                    <tbody style="">
                        @foreach ($results as $result)
                            <tr>
                                <td style="text-align: left">{{ $result['subject']['title'] }}</td>
                                @if (is_array($result['remark']))
                                    <td style="text-align: left; font-weight: 900; width: 15%;">
                                        @foreach ($result['remark'] as $key => $value)
                                            <div>{{ $key }}:</div>
                                        @endforeach
                                    </td>
                                    <td style="text-align: left">
                                        @foreach ($result['remark'] as $key => $value)
                                            <div>{{ $value }}</div>
                                        @endforeach
                                    </td>
                                @else
                                    <td colspan="2" style="text-align: left">{{ $result['remark'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="majorContainer">
                <div class="affectiveContainer">
                    <table class="affect-table" style="height: 50px; padding: 5px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="v-align" style="font-size: 8px">BEHAVIOURS</th>
                                <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500; font-size: 8px">PSYCHOMOTOR DOMAIN</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">5</td>
                                <td style="font-size: 8px">4</td>
                                <td style="font-size: 8px">3</td>
                                <td style="font-size: 8px">2</td>
                                <td style="font-size: 8px">1</td>
                            </tr>
                        </thead>

                        @foreach ($psychomotors as $psychomotor)
                            <tbody class="beh-d" style="height: 100px; padding: 10px;">
                                <tr>
                                    <th style="font-size: 8px; text-align: left">{{ $psychomotor->title() }}</th>
                                    <td>
                                        @if ($psychomotor->rate == 5)
                                            <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($psychomotor->rate == 4)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($psychomotor->rate == 3)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($psychomotor->rate == 2)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($psychomotor->rate == 1)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            <div>
                <div style="margin: 10px 0">
                    <span style="font-weight: bold; font-size: 12px">
                        <b>Class Teacher's Remarks</b>: 
                    </span>
                    <span style="font-size: 10px">{{ $studentAttendance?->comment() ?? 'No comment'}}</span>
                </div>
                <div style="margin: 5px 0">
                    <span style="font-weight: bold; font-size: 12px"><b>Principal's Remarks</b>: </span><span style="font-size: 10px">{{ $comment ?? 'No comment' }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
