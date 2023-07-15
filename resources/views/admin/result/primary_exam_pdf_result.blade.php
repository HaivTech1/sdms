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
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Aggregate:</b><span class="s-avg aggregate"> {{ number_format($aggregate , 1)}}</span>
                    </div>
                    <div class="result-item">
                        <b>Mark obtainable:</b>
                        <span>{{ $student->subjects->count() * 100 }}</span>
                    </div>
                    <div class="result-item">
                        <b>Mark obtained:</b>
                        <span class="s-avg grand_total"> {{ $marksObtained }}</span>
                    </div>
                    <div class="result-item">
                        <b>Position in class:</b>
                        <span>{!! $position !!}</span>
                    </div>
                </div>
                <div class="minorContainer">
                    <div class="result-item">
                        <b>No. of times school opened:</b>
                        <span>{{ $studentAtendance->attendance_duration ?? 0 ?? ''}}</span>
                    </div>
                    <div class="result-item">
                        <b>No. of times present:</b>
                        <span>{{ $studentAttendance->attendance_present ?? '' }}</span>
                    </div>
                    <div class="result-item">
                        <b>Attendance Average:</b>
                        <span>{{ number_format(calculatePercentage($studentAttendance->attendance_duration ?? 0, $studentAttendance->attendance_present ?? 0, 100), 1) ?? '' }}%</span>
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
                    @if ($term->id() === '1')
                        <table class="result-table">
                            <thead id="ch">
                                <tr>
                                    <th colspan="11" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Subjects</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Remarks</th>
                                </tr>
                                <tr style="text-align: center">
                                    <th></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">60</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">40</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">%</th>
                                    <th></th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody style="">
                                @foreach ($results as $result)
                                    <tr>
                                        <td style="text-align: left; font-size: 10px">{{ $result['subject'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam20Color($result['ca1']) }}">{{ $result['ca1'] ?? '' }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam20Color($result['ca2']) }}">{{ $result['ca2'] ?? '' }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam10Color($result['ca3']) }}">{{ $result['ca3'] ?? '' }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam10Color($result['pr']) }}">{{ $result['pr'] ?? '' }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam60Color($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']) }}"> {{ $result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']  }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam40Color($result['exam']) }}">{{ $result['exam'] ?? '' }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ $result['total'] ?? '' }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ class_average($student->grade->id(), $result['subject'], $term->id(), $period->id() ) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ examGrade($result['total']) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ examRemark($result['total']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($term->id() === '2')
                        <table class="result-table">
                            <thead id="ch">
                                <tr>
                                    <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Subjects</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">1st Term Score</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grand TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Avg.</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg.</th>
                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">Remarks</th>
                                </tr>
                                </tr>
                                <tr style="text-align: center">
                                    <th></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">20</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">10</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">60</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">40</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">100</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">200</th>
                                    <th></th>
                                    <th></th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">%</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="">
                                @foreach ($results as $result)
                                    @php
                                        if ($term->id() === '2'){
                                            $total = $result['total'] + $result['first_term_cummulative'];
                                        }elseif($term->id() === '3'){
                                            $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                        }
                                    @endphp

                                    <tr>
                                        <td style="text-align: left; font-size: 10px">{{ $result['subject'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam20Color($result['ca1']) }}">{{ $result['ca1'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam20Color($result['ca2']) }}">{{ $result['ca2'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam10Color($result['ca3']) }}">{{ $result['ca3'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam10Color($result['pr']) }}">{{ $result['pr'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam60Color($result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']) }}"> {{ $result['ca1'] + $result['ca2'] + $result['ca3'] + $result['pr']  }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam40Color($result['exam']) }}">{{ $result['exam'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ $result['total'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['first_term_cummulative']) }}">{{ $result['first_term_cummulative'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center;">{{ sum($result['total'], $result['first_term_cummulative']) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ divnum(sum($result['total'], $result['first_term_cummulative']), 2) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ examGrade(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ class_average($student->grade->id(), $result['subject'], $term->id(), $period->id() ) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; width: 20%; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ examRemark(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <table class="result-table">
                            <thead id="ch">
                                <tr>
                                    <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Subjects</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Re-Entry Test Class Activities</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                </tr>
                                <tr>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">1st TS</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">2nd TS</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grand TOTAL</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Avg.</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg.</th>
                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center" colspan="2">Remarks</th>
                                </tr>
                                </tr>
                                <tr style="text-align: center">
                                    <th>20</th>
                                    <th>20</th>
                                    <th>10</th>
                                    <th>10</th>
                                    <th>60</th>
                                    <th>40</th>
                                    <th>100</th>
                                    <th>100</th>
                                    <th>100</th>
                                    <th>300</th>
                                    <th>%</th>
                                    <th></th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody style="">
                                @foreach ($results as $result)
                                    @php
                                        if ($term->id() === '2'){
                                            $total = $result['total'] + $result['first_term_cummulative'];
                                        }elseif($term->id() === '3'){
                                            $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{ $result['subject'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam20Color($result['ca1']) }}">{{ $result['ca1'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam20Color($result['ca2']) }}">{{ $result['ca2'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam10Color($result['ca3']) }}">{{ $result['ca3'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam10Color($result['pr']) }}">{{ $result['pr'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam60Color($result['ct']) }}">{{ $result['ct'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam40Color($result['exam']) }}">{{ $result['exam'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ $result['total'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['first_term_cummulative']) }}">{{ $result['first_term_cummulative'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['second_term_cummulative']) }}">{{ $result['second_term_cummulative'] }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ examGrade(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}</td>
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ class_average($student->grade->id(), $result['subject'], $term->id(), $period->id() ) }}</td>
                                        <td style="font-size: 8px; font-weight: 500; text-align: center; width: 20%">{{ examRemark(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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

                <div class="affectiveContainer" style="margin-left: 10px">
                    <table class="affect-table" style="height: 50px; padding: 5px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="v-align" style="margin: 4px 20px; font-size: 8px">BEHAVIOURS</th>
                                <th colspan="5" class="text-center" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500; font-size: 8px">AFFECTIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">5</td>
                                <td style="font-size: 8px">4</td>
                                <td style="font-size: 8px">3</td>
                                <td style="font-size: 8px">2</td>
                                <td style="font-size: 8px">1</td>
                            </tr>
                        </thead>

                        @foreach ($affectives as $affective)
                            <tbody class="beh-d">
                                <tr>
                                    <th style="font-size: 8px; text-align: left">{{ $affective->title() }}</th>
                                    <td>
                                        @if ($affective->rate == 5)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($affective->rate == 4)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($affective->rate == 3)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($affective->rate == 2)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($affective->rate == 1)
                                        <span style="font-size: 8px">V</span>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="majorContainer">
                <div class="affectiveContainer">
                    <table class="result-table">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="7" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">INTERPRETATION OF RESULT</th>
                            </tr>
                            <tr>
                                <th style="font-size: 8px">Color code</th>
                                <th style="font-size: 8px">Over 10</th>
                                <th style="font-size: 8px">Over 20</th>
                                <th style="font-size: 8px">Over 40</th>
                                <th style="font-size: 8px">Over 60</th>
                                <th style="font-size: 8px">Over 100</th>
                                <th style="font-size: 8px">Grade</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            <tr>
                                <td style="color: black; font-size: 8px">BLACK</td>
                                <td style="font-size: 8px">8-10</td>
                                <td style="font-size: 8px">16-20</td>
                                <td style="font-size: 8px">32-40</td>
                                <td style="font-size: 8px">48-60</td>
                                <td style="font-size: 8px">80-100</td>
                                <td style="font-size: 8px">A</td>
                            </tr>
                            <tr>
                                <td style="color: black; font-size: 8px">BLACK</td>
                                <td style="font-size: 8px">7-7.9</td>
                                <td style="font-size: 8px">14-15.9</td>
                                <td style="font-size: 8px">28-31.9</td>
                                <td style="font-size: 8px">42-47.9</td>
                                <td style="font-size: 8px">70-79.9</td>
                                <td style="font-size: 8px">B</td>
                            </tr>
                            <tr>
                                <td style="color: green; font-size: 8px">GREEN</td>
                                <td style="font-size: 8px">6-6.9</td>
                                <td style="font-size: 8px">12-13.9</td>
                                <td style="font-size: 8px">24-27.9</td>
                                <td style="font-size: 8px">36-41.9</td>
                                <td style="font-size: 8px">60-99.9</td>
                                <td style="font-size: 8px">C</td>
                            </tr>
                            <tr>
                                <td style="color: blue; font-size: 8px">BLUE</td>
                                <td style="font-size: 8px">5.8-5.9</td>
                                <td style="font-size: 8px">11.6-11.9</td>
                                <td style="font-size: 8px">23.3-23.9</td>
                                <td style="font-size: 8px">34.8-35.9</td>
                                <td style="font-size: 8px">58-59.9</td>
                                <td style="font-size: 8px">D</td>
                            </tr>
                            <tr>
                                <td style="color: blue; font-size: 8px">BLUE</td>
                                <td style="font-size: 8px">5.6-5.79</td>
                                <td style="font-size: 8px">11.2-11.5</td>
                                <td style="font-size: 8px">22.4-23.1</td>
                                <td style="font-size: 8px">33.6-34.7</td>
                                <td style="font-size: 8px">56-57.9</td>
                                <td style="font-size: 8px">E</td>
                            </tr>
                            <tr>
                                <td style="color: red; font-size: 8px">RED</td>
                                <td style="font-size: 8px">Below 5.6</td>
                                <td style="font-size: 8px">Below 11.2</td>
                                <td style="font-size: 8px">Below 22.4</td>
                                <td style="font-size: 8px">Below 33.6</td>
                                <td style="font-size: 8px">Below 56</td>
                                <td style="font-size: 8px">F</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="affectiveContainer" style="margin-left: 5px">
                    <table class="result-table">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="5" style="padding: 0 5px; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">CLUB & SOCIETY</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            <tr>
                                <td colspan="5" style=""></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">OFFICE HELD</td>
                            </tr>
                            <tr>
                                <td colspan="5" style=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div style="margin: 5px 0">
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
