<!DOCTYPE html>
<html>
<head>
    @section('title', "Debtors List")
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
                    <img src="{{ public_path('storage/'.auth()->user()->image()) }}" width="70" height="70" alt="user">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: 500; text-align: center; text-transform: uppercase">Debtors List</div>
            </div>


            <div>
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="text-align: left">Name</th>
                            <th style="text-align: left">Class</th>
                            <th style="text-align: left">Amount</th> 
                            <th style="text-align: left">Status</th>                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($debtors as $key => $debtor)
                            <tr style="padding: 4px; text-align: left">
                                <td style="padding: 3px; text-align: left">{{ $key+1 }}</td>
                                <td style="padding: 3px; text-align: left" data-column="Name">{{ $debtor['student_name'] }}</td>
                                <td style="padding: 3px; text-align: left" data-column="Class">{{ $debtor['class'] }}</td>
                                <td style="padding: 3px; text-align: left" data-column="Outstanding">{{ number_format($debtor['outstanding']['outstanding'], 2) }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
