<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Viewport" content="width=device-width, initial-scale=1.0">
        <Title>Subject Excel sheet</Title>

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
                $exam = get_settings('exam_format');
            @endphp
            <thead>
                <tr>
                    <th>subject</th>
                    <th>subject_id</th>
                    @foreach ($midterm as $key => $value)
                        <th>{{ $key }}</th>
                    @endforeach   
                    @foreach ($exam as $key => $value)
                        <th>{{ $key }}</th>
                    @endforeach              
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $key =>$subject)
                    <tr>
                        <td data-column="Name">{{ $subject->title() }}</td>
                        <td data-column="Id">{{ $subject->id() }}</td>
                        @foreach ($midterm as $key => $value)
                            <td data-column="{{ $key }}"></td>
                        @endforeach
                        @foreach ($exam as $key => $value)
                            <td data-column="{{ $key }}"></td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>