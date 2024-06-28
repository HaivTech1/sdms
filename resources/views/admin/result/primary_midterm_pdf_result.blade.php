<!DOCTYPE html>
<html>

<head>
    @section('title', $student->last_name . " | Mid Term Result Page")
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
            width: 50%;
        }

        .minorContainer {
            float: right;
            width: 50%;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-table th,
        .result-table td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .result-item {
            font-size: 15px;
        }

        .rotate-header {
            transform: rotate(270deg);
            writing-mode: vertical-rl;
            white-space: nowrap;
            vertical-align: middle;
            transform-origin: bottom right;
            text-orientation: mixed;
        }
    </style>
</head>

<body>
    <div id="body_content">
        <div class="bg_img">
            <img src="{{ asset('storage/' . application('image')) }}" alt="{{ application('name') }}" width="300px">
        </div>
        <div class="main_content">
            <div class="header">
                <div class="header-item">
                    <img src="{{ public_path('storage/' . application('image')) }}" width="80" height="80"
                        alt="Profile Image">
                </div>
                <div class="header-item">
                    <div style="font-weight: bold; text-align: center; text-transform: uppercase; font-size: 20px">
                        {{ application('name') }}</div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        {{ application('address') }}
                    </div>
                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                        {{ application('line1') }}, {{ application('line2') }}
                    </div>
                </div>
                <div class="header-item">
                    <img src="{{ $student->user->image() ? asset('storage/' . $student->user->image()) : public_path('default.png') }}"
                        width="80" height="80" alt="{{ $student->last_name }}" style="border-radius: 100%; border: 3px solid #0F28D5;">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: bold; text-align: center; text-transform: uppercase">Mid-Term Evaluation Report
                    Sheet</div>
                <div style="font-weight: bold; text-align: center; text-transform: uppercase">{{ $term->title() }}
                    {{ $period->title() }} Academic Session</div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Name:</b> <span>{{ ucfirst($student->lastName()) }} {{ ucfirst($student->firstName()) }}
                            {{ ucfirst($student->otherName()) }}</span>
                    </div>
                    <div class="result-item">
                        <b>Admission No.:</b>
                        <span>{{ $student->user->code()}}</span>
                    </div>
                    <div class="result-item">
                        <b>Class:</b>
                        <span>{{ $student->grade->title()}}</span>
                    </div>
                </div>
                <div class="minorContainer">
                    <div class="result-item">
                        <b>Class Population:</b>
                        <span>{{ $student->grade->students->count()}}</span>
                    </div>
                    <div class="result-item">
                        <b>Age:</b>
                        <span>
                            @php
$year = Carbon\Carbon::parse($student->dob())->age
                            @endphp
                            {{$year}}
                        </span>
                    </div>

                </div>
            </div>

            <div>
                <table class="result-table">
                    <thead>
                        <tr>
                            <th colspan="9"
                                style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">
                                COGNITIVE DOMAIN</th>
                        </tr>
                        <tr>
                            <th style="width: 30%; padding-left: 10px">Subjects</th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Re-Entry 1</th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Re-Entry 2</th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">1st Organized
                                Test </th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Class Activity
                            </th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Continuous
                                Assessment</th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Project</th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Total</th>
                            <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align: center; color: green">
                            <td></td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">5</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">5</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">20</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">60</td>
                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">100</td>
                        </tr>
                        <tr>
                            @foreach ($results as $result)
                                <tr>
                                    @if($result->subject->title() != null)
                                        <td style="padding-left: 10px; width: 50%; text-align: left; font-size: 10px">
                                            {{ $result->subject->title() }}</td>
                                    @endif
                                    @if($result->entry_1 != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->entry_1 }}
                                        </td>
                                    @endif
                                    @if($result->entry_2 != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->entry_2 }}
                                        </td>
                                    @endif
                                    @if($result->first_test != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->first_test }}
                                        </td>
                                    @endif
                                    @if($result->class_activity != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                            {{ $result->class_activity }}</td>
                                    @else
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">-</td>
                                    @endif
                                    @if($result->ca != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->ca }}</td>
                                    @else
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">-</td>
                                    @endif
                                    @if($result->project != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->project }}
                                        </td>
                                    @endif
                                    @if($result->total() != null)
                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->total() }}
                                        </td>
                                    @endif
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">
                                        {{ round(divnum($result->total() * 100, 60))}}</td>
                                </tr>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin: 5px 0">
                <span style="font-weight: bold; font-size: 15px">Principal's Remark: </span><span>{{ $comment }}</span>
            </div>
        </div>
    </div>
</body>

</html>