<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Question Paper' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3, h4 { margin: 4px 0; padding: 0; }
        .meta { font-size: 12px; margin-bottom: 8px; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f4f4f4; }
        .q { margin: 10px 0 6px; }
        .opts { margin: 0 0 10px 0; padding-left: 12px; }
        .opt { margin: 2px 0; }
        .watermark { position: fixed; top: 200px; left: 0; right: 0; text-align: center; opacity: 0.08; z-index: 0; }
        .header { position: relative; z-index: 1; margin-bottom: 8px; }
        .hr { border-top: 1px dashed #ccc; margin: 8px 0; }
    </style>
    {{-- DomPDF sometimes needs this for UTF-8 rendering --}}
</head>
<body>
    {{-- faint background watermark --}}
    <div class="watermark">
        @if(!empty($school['logo']))
            <img src="{{ $school['logo'] }}" alt="logo" style="width: 300px; height: auto; display: inline-block;" />
        @endif
    </div>

    {{-- header with logo and school details (table layout for DomPDF compatibility) --}}
    <div class="header">
        <table style="width:100%; border-collapse: collapse; border: none;">
            <tr>
                <td style="width:15%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    @if(!empty($school['logo']))
                        <img src="{{ $school['logo'] }}" alt="{{ $school['name'] ?? '' }}" style="max-width: 80px; height: auto;" />
                    @endif
                </td>
                <td style="width:70%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                    <div style="margin:0; font-size:18px; font-weight:700; text-transform:uppercase">{{ $school['name'] ?? '' }}</div>
                    @if(!empty($school['address']))
                        <div style="font-size:12px">{{ $school['address'] }}</div>
                    @endif
                </td>
                <td style="width:15%; vertical-align: middle; text-align: right; border: none; padding: 0;"></td>
            </tr>
        </table>
    </div>

    <h2 style="text-align:center;">{{ $title ?? 'Question Paper' }}</h2>
    <div class="meta" style="text-align:center;">
        <span>Grade: <strong>{{ $meta['grade'] ?? '-' }}</strong></span>
        &nbsp;|&nbsp;
        <span>Subject: <strong>{{ $meta['subject'] ?? '-' }}</strong></span>
        &nbsp;|&nbsp;
        <span>Term: <strong>{{ $meta['term'] ?? '-' }}</strong></span>
        &nbsp;|&nbsp;
        <span>Period: <strong>{{ $meta['period'] ?? '-' }}</strong></span>
        <br>
        <span class="muted">Generated: {{ $meta['generated_at'] ?? '' }}</span>
    </div>

    <div class="hr"></div>

    {{-- Candidate info lines --}}
    <table style="width:100%; border-collapse: collapse; border: none; margin-bottom: 10px;">
        <tr>
            <td style="border:none; padding: 4px 0;">Name: _______________________________________</td>
            <td style="border:none; padding: 4px 0;">Reg No: ___________________</td>
        </tr>
        <tr>
            <td style="border:none; padding: 4px 0;">Class: ________________________________________</td>
            <td style="border:none; padding: 4px 0;">Date: _____________________</td>
        </tr>
    </table>

    {{-- Instructions --}}
    <div style="margin-bottom: 10px;">
        <strong>Instructions:</strong>
        <ol style="margin: 6px 0 0 18px;">
            <li>Answer all questions.</li>
            <li>Choose the correct option for each question.</li>
            <li>Ensure you write your name and class clearly.</li>
        </ol>
    </div>

    {{-- Questions --}}
    @php $letters = ['A','B','C','D','E','F']; @endphp
    @forelse($questions as $i => $q)
        <div class="q">
            <strong>{{ $i + 1 }}.</strong>
            {!! $q['question'] ?? '' !!}
            @if(!empty($q['topic_title']))
                <span class="muted" style="font-size:10px;"> (Topic: {{ $q['topic_title'] }})</span>
            @endif
        </div>
        @if(!empty($q['options']) && is_array($q['options']))
            <div class="opts">
                @foreach($q['options'] as $oi => $opt)
                    <div class="opt">{{ $letters[$oi] ?? chr(65 + $oi) }}. {!! is_string($opt) ? $opt : json_encode($opt) !!}</div>
                @endforeach
            </div>
        @endif
    @empty
        <p>No questions available.</p>
    @endforelse

</body>
</html>
