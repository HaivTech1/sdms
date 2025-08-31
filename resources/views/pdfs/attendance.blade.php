@php
/**
 * Minimal PDF layout for attendance export.
 * Variables available: $title, $records (collection/array), $type
 */
@endphp

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
                <th>AM</th>
                <th>PM</th>
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
                    <td>{{ $r['date'] }}</td>
                    <td>{{ $r['am_status'] ? 'Present' : 'Absent' }}</td>
                    <td>{{ $r['pm_status'] ? 'Present' : 'Absent' }}</td>
                    <td>{{ $r['note'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
