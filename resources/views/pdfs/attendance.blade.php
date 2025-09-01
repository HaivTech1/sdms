<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Attendance Export' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    {{-- faint background watermark --}}
    <div style="position: fixed; top: 200px; left: 0; right: 0; text-align: center; opacity: 0.08; z-index: 0;">
        <img src="{{ asset('storage/' . application('image')) }}" alt="logo" style="width: 300px; height: auto; display: inline-block;" />
    </div>

    {{-- header with logo and school details (table layout for DomPDF compatibility) --}}
    <div style="position: relative; z-index: 1; margin-bottom: 8px;">
        <table style="width:100%; border-collapse: collapse; border: none;">
            <tr>
                <td style="width:15%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    <img src="{{ asset('storage/' . application('image')) }}" alt="{{ application('name') }}" style="max-width: 80px; height: auto;" />
                </td>
                <td style="width:70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                    <div style="margin:0; font-size:18px; font-weight:700; text-transform:uppercase">{{ application('name') }}</div>
                    <div style="font-size:12px">{{ application('address') }}</div>
                    @if(application('local'))
                        <div style="font-size:11px">{{ application('local') }}</div>
                    @endif
                </td>
                <td style="width:15%; vertical-align: middle; text-align: right; border: none; padding: 0;">
                    {{-- optional right-side image or info --}}
                </td>
            </tr>
        </table>
    </div>
    <h2>{{ $title ?? 'Attendance Export' }}</h2>
    <p>Type: {{ ucfirst($type ?? 'all') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Reg No</th>
                <th>Grade</th>
                <th>Date</th>
                <th>AM Time</th>
                <th>PM Time</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r['person']['name'] ?? '-' }}</td>
                    <td>{{ $r['person']['reg_no'] ?? '-' }}</td>
                        <td>{{ $r['person']['grade'] ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r['date'])->format('j M Y') }}</td>
                        <td>
                            @if(!empty($r['am_check_in_at']))
                                {{ \Carbon\Carbon::parse($r['am_check_in_at'])->format('g:i A') }}
                            @else
                                Absent
                            @endif
                        </td>
                        <td>
                            @if(!empty($r['pm_check_out_at']))
                                {{ \Carbon\Carbon::parse($r['pm_check_out_at'])->format('g:i A') }}
                            @else
                                Absent
                            @endif
                        </td>
                    <td>{{ $r['note'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
