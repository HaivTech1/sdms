<!DOCTYPE html>
<html>
<head>
    @section('title', $student->last_name." | Mid Term Result Page")
    <style>
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
    <div class="header">
        <div class="header-item">
            <img src="{{ public_path('storage/'.application('image')) }}" width="100" height="90" alt="Profile Image">
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
            <img src="{{ public_path('storage/'.$student->user->image()) }}" width="100" height="90" alt="{{ $student->last_name }}">
        </div>
    </div>

    <div style="margin: 10px 0">
        <div style="font-weight: bold; text-align: center; text-transform: uppercase">Mid-Term Evaluation Report Sheet</div>
        <div style="font-weight: bold; text-align: center; text-transform: uppercase">{{ $term->title() }} {{ $period->title() }} Academic Session</div>
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
                {{-- <tr>
                    <th colspan="{{ count($midterm) + 3 }}" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                </tr> --}}
                <tr>
                    <th style="width: 50%; padding-left: 10px; text-align: left">Subjects</th>
                    @foreach ($midterm as $key => $value)
                        <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                            {{ $value['full_name'] }}
                        </th>
                    @endforeach
                    <th  style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">
                        Total
                    </th>
                    <th  style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">
                       Percentage
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
                                <td style="padding-left: 10px; width: 50%; text-align: left; font-size: 10px">{{ $result->subject->title() }}</td>
                            @endif
                            @foreach ($midterm as $key => $value)
                                @if (isset($result[$key]))
                                    <td style="font-size: 10px; font-weight: 400; text-align: center; color: {{ exam20Color($result[$key]) }}">{{ $result[$key] }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endforeach
                            <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->total() }}</td>
                            <td style="font-size: 10px; font-weight: 500; text-align: center">{{ round(divnum($result->total() * 100, $totalSum))}}</td>
                        </tr>
                    @endforeach
                </tr>
            </tbody>
        </table>
   </div>

    <div style="margin: 5px 0">
        <span style="font-weight: bold; font-size: 15px">Principal's Remark: </span><span>{{ $comment }}</span>
    </div>
</body>
</html>
