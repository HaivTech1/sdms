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
        </style>
    @endsection

    <div class="row">
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
                                        $year = Carbon\Carbon::parse($student->dob)->age
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
                    <thead id="ch">
                        <tr>
                            <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">COGNITIVE DOMAIN</th>
                        </tr>
                        <tr>
                            <th rowspan="3" style="width: 30%; padding-left: 10px">Subjects</th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Re-Entry 1</th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">1st Organized Test </th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Re-Entry 2</th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Continuous Assessment</th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Project</th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Total</th>
                            <th rowspan="2" style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">Percentage</th>
                        </tr>
                    </thead>
                    <tbody style="">
                            <tr style="text-align: center; color: green;">
                                <td></td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">20</td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">10</td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">60</td>
                                <td style="width: 5%; font-size: 10px; font-weight: 900; text-align: center">100</td>
                            </tr>
                        @foreach ($results as $result)
                            <tr>
                                <td style="padding-left: 10px">{{ $result->subject->title() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->entry1() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->firstTest() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->entry2() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->ca() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->project() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result->total() }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">{{ round(divnum($result->total() * 100, 60))}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <div style="margin-top: 50px;">
                <div style="text-align: center">Signature & School Stamp:</div>
                <div style="margin-top: 5px; display: flex; justify-content: center">
                    <img class='' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' style="width: 150px" />
                </div>
            </div> --}}
            
            <div class="row">
                <div class="d-print-none">
                    <div class="float-end">
                        <a href="javascript:window.print()"
                            class="btn btn-success waves-effect waves-light me-1"><i
                                class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>