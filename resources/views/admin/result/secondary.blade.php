<x-app-layout>
    @section('title', application('name')." | Result Page")

    @section('styles')
        <style>
            .rotate-header {
                transform: rotate(-180deg);
                writing-mode: vertical-lr;
                white-space: nowrap;
                font-size: 10px;
                font-weight: bold;
                text-align: left;
                vertical-align: middle;
                font-weight: 900;
            }
        </style>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div style="border: 1px solid #000000; padding: 4px 10px">
                    
                        <div class='parent'>
                            <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                                <img class='img-rounded img-responsive' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' />
                            </div>

                            <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                                <h1 style="font-size: 25px; font-weight: 800; text-decoration: uppercase"> {{
                                    application('name') }}</h1>
                                    <p class=''>
                                        {{ application('address') }}
                                    </p>
                                    <p class=''>
                                        {{ application('line1') }}, {{ application('line2') }}
                                    </p>

                                <div class="d-flex justify-content-center align-items-center" style="margin-top: 20px; font-weight: 700; font-size: 20px; text-decoration: uppercase"">
                                    <span class=''> Report Sheet For {{ $term->title() }}, {{ $period->title() }}
                                        Academic Session</span>
                                </div>
                            </div>

                            <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                                <img src='{{ asset('storage/'.$student->user->image()) }}' class='img-rounded img-responsive' alt='{{ $student->firstName()}}' />
                            </div>
                        </div>

                        <div style="border: 1px solid #000000">
                            <div class="d-flex justify-content-center align-items-center details">
                                <ul style="width: 33%">
                                    <li> Name: <b class="s-name">{{ ucfirst($student->fullName()) }}</b>
                                    </li>
                                    <li> Gender: <b class="s-sex">{{ ucfirst($student->gender())}}</b> </li>
                                    <li> Class: <b class="s-cls">{{ $student->grade->title()}}</b> </li>
                                    <li> Admission no.: <b class="s-ses-term">{{ $student->user->code() }} </b>
                                    </li>
                                </ul>
                                <ul style="width: 32%">
                                    <li> Class population: <b class="s-cls-size">{{ $student->grade->students->count()}}</b> </li>

                                    <li> Mark obtainable:<b class="s-avg">{{ $student->subjects->count() * 100 }}</b> </li>

                                    <li> Mark obtained: <b class="s-avg grand_total"></b></li>

                                    <li> Aggregate: <b class="s-avg aggregate"></b> </li>

                                </ul>
                                <ul style="width: 35%">
                                    <li> No. of times school opened: <b class="s-ge-pf">{{ $studentAtendance->attendance_duration ?? 0 ?? ''}} days</b> </li>
                                    <li> No. of times present: <b class="s-gr-pf">{{ $studentAttendance->attendance_present ?? '' }}</b> </li>
                                    <li> Attendance Average: <b class="s-gr-pf">{{ calculatePercentage($studentAttendance->attendance_duration ?? 0, $studentAttendance->attendance_present ?? 0, 100) ?? '' }}%</b> </li>
                                    <li> Position in class: <b class="s-gr-pf">{!!  $position !!}</b> </li>
                                </ul>
                            </div>
                        </div>

                        @php
                            $midterm = get_settings('midterm_format');
                            $exam = get_settings('exam_format');

                            $remarkFormat = get_settings('exam_remark');
                            $gradingFormat = get_settings('exam_grade');

                            $midtermTotal = 0;
                            $examTotal = 0;

                            if (is_array($midterm)) {
                                foreach ($midterm as $key => $value) {
                                    if (isset($value['mark'])) {
                                        $midtermTotal += $value['mark'];
                                    }
                                }
                            }

                            if (is_array($exam)) {
                                foreach ($exam as $key => $value) {
                                    if (isset($value['mark'])) {
                                        $examTotal += $value['mark'];
                                    }
                                }
                            }

                            $expectedTotal = $examTotal + $midtermTotal;

                            $mapping = generate_mapping($gradingFormat, $remarkFormat);
                        @endphp

                        <div class="d-flex justify-content-around mt-2 resultd">
                            <div style="width: 65%" class="padding-right-10 cogd">
                                <div class="table-wrapper">
                                    <table class="table table-bordered table-condensed">
                                        <thead id="ch">
                                            <tr>
                                                <th>SUBJECTS</th>

                                                <th style="padding-left: 0.04px; padding-right: 0.04px; padding-bottom: 0; text-align: center; margin-bottom: 0"
                                                    colspan="9">
                                                    CURRENT TERM SCORES
                                                    
                                                    <br>

                                                    <table style="" class="table">
                                                        <thead>
                                                            <tr>
                                                                @foreach ($midterm as $key => $value)
                                                                    <th class="rotate-header">{{ $value['full_name'] }}</th>
                                                                @endforeach
                                                                @foreach ($exam as $key => $value)
                                                                    <th class="rotate-header">{{ $value['full_name'] }}</th>
                                                                @endforeach
                                                                <th class="rotate-header" style="font-size: 12px">Total </th>
                                                                <th class="rotate-header" style="font-size: 12px">Position </th>
                                                            </tr>
                                                            <tr>
                                                                @foreach ($midterm as $key => $value)
                                                                    <th>{{ $value['mark'] }}</th>
                                                                @endforeach
                                                                @foreach ($exam as $key => $value)
                                                                    <th>{{ $value['mark'] }}</th>
                                                                @endforeach
                                                                <th style="font-size: 12px">{{ $expectedTotal }}</th>
                                                                <th style="font-size: 12px"></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </th>

                                                @if ($term->id() === '2')
                                                    <th style='padding-bottom: -15px;' class="rotate-header">
                                                        <div style='margin-bottom: -20px;'>FIRST TERM
                                                            CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-header">
                                                        <div>TOTAL CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-header">
                                                        <div>AVERAGE CUMULATIVE</div>
                                                    </th>
                                                @endif

                                                @if ($term->id() === '3')
                                                    <th style='padding-bottom: -15px;' class="rotate-header">
                                                        <div style='margin-bottom: -20px;'>First TERM
                                                            CUMULATIVE</div>
                                                    </th>
                                                    <th style='padding-bottom: -15px;' class="rotate-header">
                                                        <div style='margin-bottom: -20px;'>SECOND TERM
                                                            CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-header">
                                                        <div>TOTAL CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-header">
                                                        <div>AVERAGE CUMULATIVE</div>
                                                    </th>
                                                @endif

                                                <th class="rotate-header">
                                                    <div>GRADE</div>
                                                </th>
                                                <th class="rotate-header">REMARK</th>
                                            </tr>
                                        </thead>
                                        @foreach ($results as $result)
                                            <tbody>
                                                <tr>
                                                    <th>{{ $result['subject'] }}</th>
                                                    @foreach ($midterm as $key => $value)
                                                        @if (isset($result[$key]))
                                                            <td style="font-size: 10px; font-weight: 400; text-align: center; color: {{ exam20Color($result[$key]) }}">{{ $result[$key] }}</td>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($exam as $key => $value)
                                                        @if (isset($result[$key]))
                                                            @php
                                                                $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                                            @endphp
                                                            <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ $color }}">{{ $result[$key] }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ $result['total'] }}</td>
                                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ calculateStudentSubjectPosition($student->id(), \App\Models\PrimaryResult::class, $period->id(), $term->id(), $student->grade->id(), $result['subject_id']); }}</td>
                                                    @if ($term->id() === '1')
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ examGrade($result['total']) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">{{ examRemark($result['total']) }}</td>
                                                    @endif
                                                    @if ($term->id() === '2')
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['first_term_cummulative']) }}">{{ $result['first_term_cummulative'] }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ sum($result['total'], $result['first_term_cummulative']) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ divnum(sum($result['total'], $result['first_term_cummulative']), 2) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ examGrade(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ examRemark(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}</td>
                                                    @endif
                                                    @if ($term->id() === '3')
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['first_term_cummulative']) }}">{{ $result['first_term_cummulative'] }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['second_term_cummulative']) }}">{{ $result['second_term_cummulative'] }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ examGrade(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}</td>
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">{{ examRemark(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>

                                <h1>
                                    <i class="bx bx-comment"></i> Class Teacher's Comment
                                </h1>
                                <div class="table-wrapper">
                                    <table class="table table-condensed">
                                        
                                        <tbody class="co">
                                            <tr>
                                                <td class="comment"><span class="cfn">
                                                    <p>
                                                        {{ $studentAttendance->comment ?? '' }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h1>
                                    <i class="bx bx-comment"></i> PRINCIPAL/HEAD TEACHER COMMENT
                                </h1>
                                <div class="table-wrapper">
                                    <table class="table table-condensed">
                                        
                                        <tbody class="co">
                                            <tr>
                                                <td class="comment"><span class="cfn">
                                                    <p>
                                                        {{ $comment }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                 <div class="" style="font-size: 10px;">
                                        <div class="row">
                                            <div class="col-sm-6" style="width: 50%">
                                                <h1>
                                                    <i class="bx bx-test-tube"></i> COGNITIVE KEYS
                                                </h1>
                                                <table class="table table-condensed">
                                                    
                                                    <tbody class="ck">
                                                        <tr>
                                                            <td class="comment" style="font-size: 8px;">
                                                                @foreach($mapping as $key => $value)
                                                                    <strong>{{ strtoupper($key) }}</strong>:{{ $value }},
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-6" style="width: 50%">
                                                <h1>
                                                    <i class="bx bx-test-tube"></i> AFFECTIVE/PSYCHOMOTOR KEYS
                                                </h1>
                                                <table class=" table table-condensed">
                                                    <tbody id="">
                                                        <tr>
                                                            <td class="comment" style="font-size: 8px;">
                                                                <strong>EXCELLENT</strong>:5,
                                                                <strong>VERYGOOD</strong>:4,
                                                                <strong>GOOD</strong>:3,
                                                                <strong>NORMAL</strong>2,
                                                                <strong>FAIR</strong>:1, 
                                                                <strong>NO TICK</strong>:not recorded
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div style="width: 35%">
                                <div>
                                    <div class="table-wrapper">
                                        <table class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="v-align">BEHAVIOURS</th>
                                                    <th colspan="5" class="text-center">RATING</th>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>4</td>
                                                    <td>3</td>
                                                    <td>2</td>
                                                    <td>1</td>
                                                </tr>
                                            </thead>

                                            @foreach ($psychomotors as $psychomotor)     
                                                <tbody class="beh-d">
                                                    <tr>
                                                        <th>{{ $psychomotor->title() }}</th>
                                                        <td>
                                                         @if ($psychomotor->rate == 5)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($psychomotor->rate == 4)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($psychomotor->rate == 3)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                             @if ($psychomotor->rate == 2)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($psychomotor->rate == 1)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                 
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div>
                                    <div class="table-wrapper">
                                        <table class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="v-align">SKILLS</th>
                                                    <th colspan="5" class="text-center">RATING</th>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>4</td>
                                                    <td>3</td>
                                                    <td>2</td>
                                                    <td>1</td>
                                                </tr>
                                            </thead>


                                            @foreach ($affectives as $affective)     
                                                <tbody class="beh-d">
                                                    <tr>
                                                        <th>{{ $affective->title() }}</th>
                                                        <td>
                                                         @if ($affective->rate == 5)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($affective->rate == 4)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($affective->rate == 3)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                             @if ($affective->rate == 2)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($affective->rate == 1)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                 
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="display: flex; justify-content: center">
                            <div class="d-print-none">
                                <div class="float-end">
                                    <a href="javascript:window.print()"
                                        class="btn btn-success btn-lg waves-effect waves-light me-1"><i
                                            class="fa fa-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     @section('scripts')
        <script>
            function generatePDF() {
                toggleAble('#downloadPdf', true);

                const style = document.createElement('style');
                style.innerHTML = 'td, th { line-height: 2; padding: 5px}';
                document.head.appendChild(style);
                const container = document.getElementById("resultPrintMargin");

                html2canvas(container, {
                    scale: 2,
                    allowTaint: false,
                    }).then(function(canvas) {
                    const imgData = canvas.toDataURL("image/png");

                    const pdfDocDefinition = {
                        pageSize: 'A4',
                        watermark: {text: ''+@json(application('name')), color: 'gray', opacity: 0.1, bold: true, fontSize: 30,},
                        pageOrientation: 'portrait',
                        content: [
                            {
                                image: imgData,
                                width: 520,
                                height: 800
                            }
                        ],
                        styles: {
                            header: {
                                fontSize: 18,
                                bold: false,
                                margin: [0, 0, 0, 0]
                            },
                            body: {
                                fontSize: 12,
                                margin: [0, 0, 0, 0]
                            }
                        }
                    };

                    pdfMake.createPdf(pdfDocDefinition).open();
                });
                document.head.removeChild(style);
                toggleAble('#downloadPdf', false);
            }
        </script>

        <script>
            $(document).ready(function() {
                var grandTotal = 0;
                var numSubjects = {{ count($results) }};
                var grand = numSubjects * 100
                @foreach ($results as $result)
                    var total = {{ $result['total'] }};
                    grandTotal += total;
                @endforeach
                    var aggregate = grandTotal / numSubjects;
                    aggregate = aggregate.toFixed(2);

                $('.grand_total').text(grandTotal);
                $('.aggregate').text(aggregate);
            });
        </script>
    @endsection
</x-app-layout>