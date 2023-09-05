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
        <div style="width: 95%; margin: 0 auto">
            <div style="width: 10%; float: left; margin-right: 20px">
                <img src="{{  public_path('storage/'.application('image')) }}" width="70%" alt="{{ application('name') }}" />
            </div>
            <div style="width: 50%; float: left">
                <h2>{{ application('name') }} subject list </h2>
            </div>
        </div>

        <table style="position: relative; top: 20px">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Created At</th>                
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $key =>$subject)
                    <tr style="padding: 3px">
                        <td style="padding: 3px">{{ $key+1 }}</td>
                        <td style="padding: 3px" data-column="Name">{{ $subject->title() }}</td>
                        <td style="padding: 3px" data-column="Last Name">{{ $subject->id }}</td>
                        <td style="padding: 3px" data-column="Date">{{ $subject->created_at->format('F j, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>