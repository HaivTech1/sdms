<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Question Paper' }}</title>
    <style>
        /* Tight page margins */
        @page {
            margin: 8mm 8mm 10mm 8mm;
        }

        /* Base typography & spacing */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            /* slightly smaller */
            line-height: 1.25;
            /* tighter lines */
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 2px 0;
            padding: 0;
        }

        .meta {
            font-size: 11px;
            margin-bottom: 6px;
        }

        .muted {
            color: #666;
        }

        /* Tables: collapse + minimal padding */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
        }

        /* reduced from 6px */
        th {
            background: #f5f5f5;
        }

        /* Layout helpers */
        .qblock {
            page-break-inside: avoid;
        }

        /* keep question + options together */
        .q {
            margin: 6px 0 4px;
        }

        /* was 10px 0 6px */
        .hr {
            border-top: 1px dashed #ccc;
            margin: 6px 0;
        }

        /* tighter */

        /* Header / watermark */
        .watermark {
            position: fixed;
            top: 160px;
            left: 0;
            right: 0;
            text-align: center;
            opacity: 0.06;
            z-index: 0;
        }

        .header {
            position: relative;
            z-index: 1;
            margin-bottom: 6px;
        }

        /* Two-column page grid already achieved by your outer table (50%/50%) */
        /* Options: compact 2-column grid inside each question */
        .opts-table {
            width: 100%;
            border-collapse: collapse;
        }

        .opts-table td {
            border: none;
            /* no cell borders inside options */
            padding: 2px 0;
            /* very tight vertical padding */
            vertical-align: top;
            width: 50%;
        }

        /* Candidate info line spacing */
        .cand td {
            border: none;
            padding: 3px 0;
        }
    </style>
</head>

<body>
    {{-- faint background watermark --}}
    <div class="watermark">
        @if(!empty($school['logo']))
        <img src="{{ $school['logo'] }}" alt="logo" style="width: 240px; height: auto; display: inline-block;" />
        @endif
    </div>

    {{-- header --}}
    <div class="header">
        <table style="width:100%; border: none;">
            <tr>
                <td style="width:14%; vertical-align: middle; text-align: left; border: none; padding: 0;">
                    @if(!empty($school['logo']))
                    <img src="{{ $school['logo'] }}" alt="{{ $school['name'] ?? '' }}"
                        style="max-width: 68px; height: auto;" />
                    @endif
                </td>
                <td style="width:72%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                    <div style="margin:0; font-size:16px; font-weight:700; text-transform:uppercase">
                        {{ $school['name'] ?? '' }}</div>
                    @if(!empty($school['address']))
                    <div style="font-size:11px">{{ $school['address'] }}</div>
                    @endif
                </td>
                <td style="width:14%; vertical-align: middle; text-align: right; border: none; padding: 0;"></td>
            </tr>
        </table>
    </div>

    <h2 style="text-align:center; margin:4px 0;">{{ $title ?? 'Question Paper' }}</h2>
    <div class="meta" style="text-align:center;">
        <span>Grade: <strong>{{ $meta['grade'] ?? '-' }}</strong></span>
        &nbsp;|&nbsp;
        <span>Subject: <strong>{{ $meta['subject'] ?? '-' }}</strong></span>
        &nbsp;|&nbsp;
        <span>Term: <strong>{{ $meta['term'] ?? '-' }}</strong></span>
        &nbsp;|&nbsp;
        <span>Period: <strong>{{ $meta['period'] ?? '-' }}</strong></span>
    </div>

    <div class="hr"></div>

    {{-- Candidate info lines --}}
    <table class="cand" style="width:100%; border: none; margin-bottom: 6px;">
        <tr>
            <td style="padding-right: 8px;">Name: _______________________________________</td>
            <td>Student Id: ___________________</td>
        </tr>
        <tr>
            <td>Date: _____________________</td>
            <td></td>
        </tr>
    </table>

    {{-- Instructions --}}
    <div style="margin-bottom: 6px;">
        <strong>Instructions:</strong>
        <p style="margin: 4px 0 0 16px; font-family:Verdana, Geneva, Tahoma, sans-serif;">
            {{ 'Write your name and Student ID clearly and choose the correct option for each question.' }}
        </p>
    </div>

    {{-- Questions --}}
    @php
    $letters = ['A','B','C','D','E','F'];
    $chunks = array_chunk($questions, 2); // two columns across the page
    @endphp

    @if(empty($questions))
    <p>No questions available.</p>
    @else
    <table style="width:100%; border: none;">
        @foreach($chunks as $ridx => $pair)
        <tr>
            @foreach($pair as $cidx => $q)
            @php $globalIndex = ($ridx * 2) + $cidx; @endphp
            <td style="width:50%; vertical-align: top; padding: 4px 8px; border: none;">
                <div class="qblock">
                    <div class="q"><strong>{{ $globalIndex + 1 }}.</strong> {!! $q['question'] ?? '' !!}</div>

                    @if(in_array($mode, ['questions', 'questions_answers']))
                    @if(!empty($q['options']) && is_array($q['options']))
                    @php
                    // build 2-column options
                    $opts = array_values($q['options']);
                    $left = [];
                    $right = [];
                    foreach ($opts as $i => $opt) {
                    if ($i % 2 === 0) { $left[] = [$i, $opt]; } else { $right[] = [$i, $opt]; }
                    }
                    // normalize rows
                    $rows = max(count($left), count($right));
                    @endphp
                    <table class="opts-table">
                        @for($ri = 0; $ri < $rows; $ri++) <tr>
                            <td>
                                @if(isset($left[$ri]))
                                @php [$oi, $ov] = $left[$ri]; @endphp
                                {{ $letters[$oi] ?? chr(65 + $oi) }}. {!! is_string($ov) ? $ov : json_encode($ov) !!}
                                @endif
                            </td>
                            <td>
                                @if(isset($right[$ri]))
                                @php [$oi, $ov] = $right[$ri]; @endphp
                                {{ $letters[$oi] ?? chr(65 + $oi) }}. {!! is_string($ov) ? $ov : json_encode($ov) !!}
                                @endif
                            </td>
        </tr>
        @endfor
    </table>
    @endif
    @endif

    @if($mode === 'questions_answers')
    <div style="margin-top: 3px; font-size:10.5px;">
        <strong>Answer:</strong>
        @if(isset($q['correct_answer']) && $q['correct_answer'] !== null)
        {{ $q['correct_answer'] }}
        @else
        N/A
        @endif
    </div>
    @endif

    @if($mode === 'answers')
    <div style="margin-top: 3px; font-size:11px;">
        <strong>{{ $globalIndex + 1 }}.</strong>
        @if(isset($q['correct_answer']) && $q['correct_answer'] !== null)
        {{ $q['correct_answer'] }}
        @else
        N/A
        @endif
    </div>
    @endif
    </div>
    </td>
    @endforeach

    @if(count($pair) === 1)
    <td style="width:50%; border: none;">&nbsp;</td>
    @endif
    </tr>
    @endforeach
    </table>
    @endif

</body>

</html>
