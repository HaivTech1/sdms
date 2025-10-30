<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @section('title', $student->last_name . " | Mid Term Result Page")
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

        .bg_img {
            position: absolute;
            opacity: 0.1;
            background-repeat: no-repeat;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <div id="body_content">
        <div class="bg_img">
            <img src="{{ asset('storage/' .application('image')) }}" alt="{{ application('name') }}" width="320px">
        </div>

        <div class="header">
            <div class="header-item">
                <img src="{{ public_path('storage/' . application('image')) }}" width="100" height="90" alt="Profile Image">
            </div>
            <div class="header-item">
                <div style="font-weight: bold; text-align: center; text-transform: uppercase">{{ application('name') }}
                </div>
                <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                    {{ application('address') }}
                </div>
                <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                    {{ application('line1') }}, {{ application('line2') }}
                </div>
            </div>
            <div class="header-item">
                <img src="{{ public_path('storage/' . $student->user->image()) }}" width="100" height="90"
                    alt="{{ $student->last_name }}">
            </div>
        </div>

        <div style="margin: 10px 0">
            <div style="font-weight: bold; text-align: center; text-transform: uppercase">Mid-Term Evaluation Report Sheet
            </div>
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
                            @php
                $midterm = get_settings('midterm_format');
                $midtermTotal = 0;

                if (is_array($midterm)) {
                    foreach ($midterm as $key => $value) {
                        if (isset($value['mark'])) {
                            $midtermTotal += $value['mark'];
                        }
                    }
                }
                @endphp

                <thead>
                    <tr>
                        <th style="width: 40%; padding-left: 10px; text-align: left">Subjects</th>
                        @foreach ($midterm as $key => $value)
                            <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center; vertical-align: bottom; height: 80px;">
                                <div class="rotate-header">{{ $value['full_name'] }}</div>
                            </th>
                        @endforeach
                        <th style="font-size: 8px; font-weight: 500; text-align: center; vertical-align: bottom; height: 80px;">
                            <div class="rotate-header">Total</div>
                        </th>
                        <th style="font-size: 8px; font-weight: 500; text-align: center; vertical-align: bottom; height: 80px;">
                            <div class="rotate-header">Percentage</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                $totalSum = 0;
                    @endphp
                    <tr style="text-align: center; color: green;">
                        <td style="width: 50%"></td>
                        @foreach ($midterm as $key => $value)
                                            <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">
                                                {{ $value['mark'] }}
                                                @php
                $totalSum += $value['mark'];
                                                @endphp
                                            </td>
                        @endforeach
                        <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">{{ $totalSum }}</td>
                        <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">100%</td>
                    </tr>
                    <tr>
                        @foreach ($results as $result)
                            <tr>
                                @if($result->subject->title() != null)
                                    <td style="padding-left: 10px; width: 50%; text-align: left; font-size: 10px">
                                        {{ $result->subject->title() }}</td>
                                @endif
                                @foreach ($midterm as $key => $value)
                                    @if (isset($result[$key]))
                                        <td
                                            style="font-size: 10px; font-weight: 400; text-align: center; color: {{ exam20Color($result[$key]) }}">
                                            {{ $result[$key] }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @endforeach
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->total() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                    {{ round(divnum($result->total() * 100, $totalSum))}}</td>
                            </tr>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin: 5px 0" class="page-break">
            <span style="font-weight: bold; font-size: 15px">Remark: </span><span>{{ $comment }}</span>
        </div>
    </div>
</body>

</html>