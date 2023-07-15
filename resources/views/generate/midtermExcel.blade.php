<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Viewport" content="width=device-width, initial-scale=1.0">
        <Title>Midterm Excel sheet</Title>

        <style>
            table {
                width: 95%;
                border-collapse: collapse;
                margin: 50px auto;
            }

            tr::nth-of-type(odd){
                background: #eee;
            }

            th{
                background: #502179;
                color: #fff;
                font-weight: bold;
                text-align: left;
                font-size: 18px;
            }

            td, th{
                padding: 10px;
                border: 1px solid #ccc;
            }
        </style>
    </head>

    <body>

        <table style="position: relative; top: 20px">
            @php
                $midterm = get_settings('midterm_format');
            @endphp
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Id</th>
                    <th>Subject</th>
                    <th>Period</th>
                    <th>Term</th>
                    @foreach ($midterm as $key => $value)
                    <th>{{ $key }}</th>
                    @endforeach                
                </tr>
            </thead>
            <tbody>
                @foreach($results as $key =>$result)
                    <tr>
                        <td data-column="Name">{{ $result->student->lastName() }} {{ $result->student->firstName() }} {{ $result->student->firstName() }}</td>
                        <td data-column="Id">{{ $result->student->user->code() }}</td>
                        <td data-column="subject">{{ $result->period_id }}</td>
                        <td data-column="period">{{ $result->term_id }}</td>
                        <td data-column="term">{{ $result->subject_id }}</td>
                        @foreach ($midterm as $key => $value)
                            @if (isset($result[$key]))
                                <td data-column="{{ $key }}">{{ $result[$key] }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>