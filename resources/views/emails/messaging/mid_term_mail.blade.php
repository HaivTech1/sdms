<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #f7f7f7;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f7f7f7;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .date {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .title {
            font-size: 24px;
            color: #212529;
            margin: 0;
            font-weight: 600;
        }
        .relative {
            position: relative;
        }
        .w-100 {
            width: 100%;
        }
        .mb4 {
            margin-bottom: 2rem;
        }
        .bg-near-white {
            background-color: #f8f9fa;
        }
        .mb3 {
            margin-bottom: 1.5rem;
        }
        .pa4 {
            padding: 2rem;
        }
        .mid-gray {
            color: #6c757d;
        }
        .f6 {
            font-size: 0.875rem;
        }
        .f3 {
            font-size: 1.5rem;
        }
        .near-black {
            color: #212529;
        }
        .nested-links {
            line-height: 1.6;
        }
        .f5 {
            font-size: 1rem;
        }
        .lh-copy {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="date">{{ date('D, M j, Y \a\t g:ia') }}</div>
            <h1 class="title">{{ ucwords($subject) }}</h1>
        </div>
        
        <div class="content">
            <div class="relative w-100 mb4 bg-near-white">
                <div class="mb3 pa4 mid-gray overflow-hidden">
                    <div class="nested-links f5 lh-copy nested-copy-line-height">
                        {!! $body !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>
                Thanks,<br>
                <strong>{{ application('name') }}</strong>
            </p>
        </div>
    </div>
</body>
</html>