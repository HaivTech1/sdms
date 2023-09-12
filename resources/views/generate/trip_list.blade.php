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
                padding: 5px
            }
        </style>
    </head>

    <body>
        <div style="width: 95%; margin: 0 auto">
            <div style="width: 10%; float: left; margin-right: 20px">
                <img src="{{  public_path('storage/'.application('image')) }}" width="70%" alt="{{ application('name') }}" />
            </div>
            <div style="width: 50%; float: left">
                <h4>{{ application('name') }} Trip list </h4>
            </div>
        </div>

        <table style="position: relative; top: 20px">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Address</th>
                    <th>Price</th>
                    <th>Space</th>  
                    <th>Split</th>   
                    <th>Split type</th>   
                    <th>Total Enrolled</th>   
                    <th>Status</th>               
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $key =>$trip)
                    <tr style="padding: 3px">
                        <td style="padding: 3px">{{ $key+1 }}</td>
                        <td style="padding: 3px" data-column="Address">{{ $trip->address() }}</td>
                        <td style="padding: 3px" data-column="Price">{{ $trip->price() }}</td>
                        <td style="padding: 3px" data-column="Space">{{ $trip->studentsCount() }}</td>
                        <td style="padding: 3px" data-column="Split">{{ $trip->split_status }}</td>
                        <td style="padding: 3px" data-column="Split Type">{{ $trip->split_type }}</td>
                        <td style="padding: 3px" data-column="Total Students">{{ count($trip->studentTrips) }}</td>
                        <td style="padding: 3px" data-column="Status">{{ $trip->status_type }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>