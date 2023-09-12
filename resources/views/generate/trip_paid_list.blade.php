<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Viewport" content="width=device-width, initial-scale=1.0">
        <Title>Order details</Title>

        <style>
            table {
                width: 95%;
                border-collapse: collapse;
                margin: 30px auto;
            }

            tr::nth-of-type(odd){
                background: #eee;
            }

            th{
                text-align: left;
                font-size: 10px;
            }

            td, th{
                border: 1px solid #ccc;
            }
        </style>
    </head>

    <body>
        <div style="width: 95%; margin: 0 auto">
            <div style="width: 10%; float: left; margin-right: 20px">
                <img src="{{  public_path('storage/'.application('image')) }}" width="70%" alt="{{ application('name') }}" />
            </div>
            <div style="width: 50%; float: left">
                <h5 style="text-align: center">{{ $term->title() }}/{{ $period->title() }} Paid {{ $type }} list for {{ $grade->title() }} </h5>
            </div>
        </div>

        <table style="position: relative; top: 20px">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount Paid</th>   
                    <th>To Balance</th> 
                    <th>Channel</th>               
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $key =>$trip)
                    <tr style="padding: 3px">
                        <td style="padding: 3px">{{ $key+1 }}</td>
                        <td style="padding: 3px" data-column="Address">{{ $trip->student->lastName() }} {{ $trip->student->firstName() }}</td>
                        <td style="padding: 3px" data-column="Price">{{ $trip->trip->price() }}</td>
                        <td style="padding: 3px" data-column="Amount Paid">{{ $trip->payment->amount }}</td>
                        <td style="padding: 3px" data-column="Balance">{{ $trip->payment->balance }}</td>
                        <td style="padding: 3px" data-column="Balance">{{ $trip->payment->channel }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>