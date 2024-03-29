<x-app-layout>
    @section('title', application('name')." | Mid Term Result Page")

    @section('styles')
        <style>
            .mainContainer {
                width: 60%;
            }
            .minorContainer{
                width: 30%
            }
            .majorContainer{
                display: flex; 
                flex-wrap: wrap;
                justify-content: space-between; 
                margin-top: 1px
            }
            .appName{
                font-size: 35px; 
                font-weight: bold; 
                text-transform : uppercase
            }

            
            @media screen and (max-width: 480px) {
                .mainContainer{
                    width: 100%;
                }
                .minorContainer{
                    width: 100%;
                }
                .majorContainer{
                    margin-top: 5px;
                    flex-direction: column;
                }
                .appName{
                    font-size: 15px;
                    margin: 10px;
                }
            }

            .rotate-header {
                transform: rotate(-180deg);
                writing-mode: vertical-lr;
                white-space: nowrap;
                font-size: 10px;
                font-weight: bold;
                text-align: left;
                vertical-align: middle;
                width: 5%; 
                font-weight: 900;
            }
        </style>
    @endsection

    <div class="row" id="resultPrintMargin">
        <div class="col-lg-12">
            <div class='parent'>
                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                    <img class='img-rounded img-responsive' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' />
                </div>

                <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                    <h1 class="appName"> {{ application('name') }}</h1>
                        <p style='font-size: 15px; font-family: Arial, Helvetica, sans-serif'>
                            {{ application('address') }}
                        </p>
                </div>

                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                    <img src='{{ asset('storage/'.$student->user->image()) }}' class='img-rounded img-responsive' alt='{{ $student->firstName()}}' />
                </div>
            </div>

            <div style="margin-bottom: 10px">
                <p style="font-weight: bold; text-align: center; text-transform : uppercase">Mid-Term Evaluation Report Sheet</p>
                <p style="font-weight: bold; text-align: center; text-transform : uppercase">{{ $term->title() }} {{ $period->title() }} Academic Session</p>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Surname</th>
                                <td>{{ ucfirst($student->lastName()) }}</td>
                                <th>Other Names:</th>
                                <td>{{ ucfirst($student->firstName()) }} {{ ucfirst($student->otherName()) }}</td>
                            </tr>
                            <tr>
                                <th>Class:</th>
                                <td>{{ $student->grade->title()}}</td>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th>House:</th>
                                <td>{{ ucfirst($student->house?->title()) }} </td>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="minorContainer">
                    <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <th>Sex</th>
                                <td>{{ ucfirst($student->gender())}}</td>
                            </tr>
                            <tr>
                                <th>No. In Class:</th>
                                <td>{{ $student->grade->students->count()}}</td>
                            </tr>
                            <tr>
                                <th>Age:</th>
                                <td>
                                    <?php
                                        $year = Carbon\Carbon::parse($student->dob())->age
                                    ?>
                                    {{$year}}
                                </td>
                            </tr>
                            <tr>
                                <th>Admission No.</th>
                                <td>{{ $student->user->code()}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-wrapper table-responsive">
                <table class="table table-bordered table-condensed">
                    @php
                        $midterm = get_settings('midterm_format');
                    @endphp
                    @if ($midterm !== null)
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                            </tr>
                            
                            <tr>
                                <th rowspan="3" style="width: 30%; padding-left: 10px">Subjects</th>
                                @foreach ($midterm as $key => $value)
                                    <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" class="rotate-header">{{ $value['full_name'] }}</th>
                                @endforeach
                                <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" class="rotate-header">Total</th>
                                <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" class="rotate-header">Percentage</th>
                            </tr>
                        </thead>
                        <tbody style="">

                                @php
                                    $totalSum = 0;
                                @endphp
                                <tr style="text-align: center; color: green;">
                                    <td></td>
                                    @foreach ($midterm as $key => $value)
                                        <th style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">
                                            {{ $value['mark'] }}
                                            @php
                                                $totalSum += $value['mark'];
                                            @endphp
                                        </th>
                                    @endforeach
                                    <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">{{ $totalSum }}</td>
                                    <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">100%</td>
                                </tr>
                            @foreach ($results as $result)
                                <tr>
                                    @if($result->subject->title() != null)
                                        <td style="padding-left: 10px">{{ $result->subject->title() }}</td>
                                    @endif
                                   @foreach ($midterm as $key => $value)
                                        @if (isset($result[$key]))
                                            <td style="font-size: 10px; font-weight: 400; text-align: center; color: {{ exam20Color($result[$key]) }}">{{ $result[$key] }}</td>
                                        @endif
                                    @endforeach
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->total() }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ round(divnum($result->total() * 100, $totalSum))}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>

            <div style="margin: 0 10px">
                <span style="font-weight: bold; font-size: 15px">Comment: </span><span>{{ $comment }}</span>
            </div>

            {{-- <div style="margin-top: 50px;">
                <div style="text-align: center">Signature & School Stamp:</div>
                <div style="margin-top: 5px; display: flex; justify-content: center">
                    <img class='' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' style="width: 150px" />
                </div>
            </div> --}}
        
        </div>
    </div>

    <div class="row">
        <div class="d-print-none">
            <div class="float-end">
                {{-- <button type="button" id="downloadPdf" class="btn btn-primary" onclick="generatePDF()">Download</button> --}}
                <a href="javascript:window.print()"
                    class="btn btn-success waves-effect waves-light me-1"><i
                        class="fa fa-print"></i>
                </a>
                @admin
                    <button class="btn btn-sm btn-primary w-md waves-effect waves-light" type="button" id='cummulative' onClick="publish('{{ $student->id() }}, {{ $period->id() }}, {{ $term->id() }}, {{ $student ->grade->id() }}')">
                        <i class="mdi mdi-upload d-block font-size-16"></i>
                    </button>
                @endadmin
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
                                width: 500,
                                height: 500
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

            function publish(student){
                var data = student.split(",");
                var student_id = data[0];
                var period_id = data[1];
                var term_id = data[2];
                var grade_id = data[3];
                toggleAble('#cummulative', true);

                $.ajax({
                    url: '{{ route('result.midterm.publish') }}' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#cummulative', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#cummulative', false);
                            toastr.error(res.message, 'Success!');
                        }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative', false);
                });              
            }
        </script>
    @endsection

</x-app-layout>