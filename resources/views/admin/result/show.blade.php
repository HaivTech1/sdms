<x-app-layout>
    @section('title', application('name')." | Result Page")

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div style="border: 1px solid #000000; border-radius: 15px; padding: 10px">
                        <div class='parent'>
                            <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                                <img class='img-rounded img-responsive' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' />
                            </div>

                            <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                                <h1 style="font-size: 25px; font-weight: bold; text-decoration: uppercase"> {{
                                    application('name') }}</h1>
                                    <p class=''>
                                        {{ application('motto') }}
                                    </p>

                                    <p class=''>
                                        {{ application('address') }}
                                    </p>
                                    <p class=''>
                                        {{ application('line1') }}
                                    </p>

                                <div class="d-flex justify-content-center align-items-center" style="margin-top: 20px">
                                    <span class=''>{{ $term->title() }} Report Sheet For {{ $period->title() }}
                                        Session</span>
                                </div>
                            </div>

                            <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                                <img src='{{ asset('storage/students/'.$student->image()) }}' class='img-rounded img-responsive' alt='{{ $student->firstName()}}' />
                            </div>
                        </div>

                        <div style="border: 1px solid #000000; border-radius: 10px;">
                            <div class="d-flex justify-content-center align-items-center details">
                                <ul style="width: 33%">
                                    <li> NAME: <b class="s-name">{{ ucfirst($student->fullName()) }}</b>
                                    </li>
                                    <li> SEX: <b class="s-sex">{{ ucfirst($student->gender())}}</b> </li>
                                    <li> CLASS: <b class="s-cls">{{ $student->grade->title()}}</b> </li>
                                    {{-- <li> <span>REG NO.:</span> <b class="s-ses-term">20212BDSU649 </b>
                                    </li>
                                    <li> <span>Admission_no.:</span> <b class="s-ses-term">DLA/21/0241 </b>
                                    </li> --}}
                                    <li> <span>House:</span> <b class="s-ses-term">{{ $student->house->title()}} House </b>
                                    </li>

                                </ul>
                                <ul style="width: 32%">
                                    <li> CLASS POPULATION: <b class="s-cls-size">{{ $student->grade->count()}}</b> </li>

                                    <li> MARKS OBTAINABLE:<b class="s-avg">{{ $student->subjects->count() * 100 }}</b> </li>

                                    <li> MARKS OBTAINED:
                                        <b class="s-avg">
                                        {{ $totalExamScrore }}
                                        </b> 
                                    </li>

                                    <li> STUDENT AVERAGE: <b class="s-avg">{{ round($average) }}%</b> </li>

                                </ul>
                                <ul style="width: 35%">
                                    <li> No of TIMES SCHOOL OPENED: <b class="s-ge-pf">{{ $termDuration }}</b> </li>
                                    <li> No. of TIMES PRESENT: <b class="s-gr-pf">{{ $attendance }}</b> </li>
                                    <li> ATTENDANCE AVERAGE: <b class="s-gr-pf">{{ round($studentAttendanceAve) }}%</b> </li>

                                </ul>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around mt-2 resultd">
                            <div style="width: 65%" class="padding-right-10 cogd">
                                <div class="table-wrapper">
                                    <table class="table table-bordered table-condensed">
                                        <thead id="ch">
                                            <tr>
                                                <th>SUBJECTS</th>

                                                <th style="padding-left: 0.04px; padding-right: 0.04px; padding-bottom: 1px; text-align: center;"
                                                    colspan="4" class="rotate-45">CURRENT TERM SCORES<br><br>

                                                    <table style="border: 0px; " class="table table-condensed">

                                                        <tbody>
                                                            <tr>
                                                                <th style="font-size: 12px; padding: 6px; ">Ca
                                                                    1<br>20%&nbsp;
                                                                </th>
                                                                <th style="font-size: 12px; padding: 6px; ">Ca
                                                                    2<br>20%&nbsp;
                                                                </th>

                                                                <th style="font-size: 12px; padding: 6px; ">Exam<br>60%
                                                                </th>
                                                                <th style="font-size: 12px; padding: 6px; ">Total<br>100
                                                                </th>


                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                </th>

                                                @if ($term->id() === '2')
                                                    <th style='padding-buttom: -15px;' class="rotate-45">
                                                        <div style='margin-buttom: -20px;'>&nbsp;&nbsp;&nbsp;FIRST TERM
                                                            CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-45">
                                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-45">
                                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AVERAGE CUMULATIVE</div>
                                                    </th>
                                                @endif

                                                @if ($term->id() === '3')
                                                    <th style='padding-buttom: -15px;' class="rotate-45">
                                                        <div style='margin-buttom: -20px;'>&nbsp;&nbsp;&nbsp;First TERM
                                                            CUMULATIVE</div>
                                                    </th>
                                                    <th style='padding-buttom: -15px;' class="rotate-45">
                                                        <div style='margin-buttom: -20px;'>&nbsp;&nbsp;&nbsp;SECOND TERM
                                                            CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-45">
                                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL CUMULATIVE</div>
                                                    </th>
                                                    <th class="rotate-45">
                                                        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AVERAGE CUMULATIVE</div>
                                                    </th>
                                                @endif

                                                <th class="rotate-45">
                                                    <div>GRADE</div>
                                                </th>
                                                <th class="text-center">REMARK</th>
                                            </tr>
                                        </thead>
                                        @foreach ($results as $result)
                                            @php
                                                if ($term->id() === '2'){
                                                    $total = $result['total'] + $result['first_term_cummulative'];
                                                }elseif($term->id() === '3'){
                                                    $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                                }
                                            @endphp
                                            <thead>
                                                <tr>
                                                    <th>{{ $result['subject'] }}</th>
                                                    <td style="color:#000add">{{ $result['ca1'] }}</td>
                                                    <td style="color:#000add">{{ $result['ca2'] }}</td>
                                                    <td style="color:#000add">{{ $result['exam'] }}</td>
                                                    <td style="color:#000add">{{ $result['total'] }}</td>
                                                    @if ($term->id() === '2')
                                                        <td style="color:#000add">
                                                            {{ $result['first_term_cummulative'] }}
                                                        </td>
                                                        <td style="color:#000add">{{ $total }}</td>
                                                        <td style="color:#000add">{{ round(($total) / 2) }}</td>
                                                    @endif
                                                    @if ($term->id() === '3')
                                                         <td style="color:#000add">
                                                            {{ $result['first_term_cummulative'] }}
                                                        </td>
                                                        <td style="color:#000add">
                                                            {{ $result['second_term_cummulative'] }}
                                                        </td>
                                                        <td style="color:#000add">{{ $total }}</td>
                                                        <td style="color:#000add">{{ round(($total) / 3) }}</td>
                                                    @endif
                                                    <td style="color:#000add">
                                                        @if($term->id == 1)
                                                            {{ $result['grade'] }}
                                                        @elseif($term->id == 2)
                                                            @if ($total >= 70) 
                                                                A
                                                            @elseif ($total >= 60) 
                                                                B
                                                            @elseif($total >= 50) 
                                                                C
                                                            @elseif($total >= 45) 
                                                                D
                                                            @elseif($total >= 35) 
                                                                E
                                                            @elseif($total >= 20) 
                                                                F
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td><b>
                                                        @if($term->id == 1)
                                                            {{ $result['remark'] }}
                                                        @elseif($term->id == 2)
                                                            @if ($total / 2 >= 70) 
                                                                Distinction
                                                            @elseif ($total / 2 >= 60) 
                                                                V.good
                                                            @elseif($total / 2 >= 50) 
                                                                Credit
                                                            @elseif($total / 2 >= 45) 
                                                                Pass
                                                            @elseif($total / 2 >= 35) 
                                                                Fair
                                                            @elseif($total / 2 >= 20) 
                                                                Fail
                                                            @endif
                                                        @elseif($term->id == 3)
                                                            @if ($total / 3 >= 70) 
                                                                Distinction
                                                            @elseif ($total / 3 >= 60) 
                                                                V.good
                                                            @elseif($total / 3 >= 50) 
                                                                Credit
                                                            @elseif($total / 3 >= 45) 
                                                                Pass
                                                            @elseif($total / 3 >= 35) 
                                                                Fair
                                                            @elseif($total / 3 >= 20) 
                                                                Fail
                                                            @endif
                                                        @endif
                                                    </b></td>
                                                </tr>
                                                        
                                            </thead>
                                        @endforeach
                                    </table>
                                </div>

                                <h1>
                                    <i class="bx bx-comment"></i> PRINCIPAL/HEAD TEACHER COMMENT(S) /
                                    OBSERVATION(S)
                                </h1>

                                <div class="table-wrapper">
                                    
                                    <table class="table table-condensed">
                                        
                                        <tbody class="co">
                                            <tr>
                                                <td class="comment"><span class="cfn">
                                                    <p>
                                                        {{ ucfirst($student->fullName()) }}</span>'s
                                                        outcome this term is @if ($average > 50) Excellent, keep it up.
                                                    </p>
                                                    <p> Matching {{ ucfirst($student->fullName()) }}'s end of term result with students average,
                                                        it is an excellent performance and has the potential to improve more and her strength of mind is key factor in doing so. 
                                                    </p>
                                                    @else
                                                        not too encouraging
                                                     <strong class="txt-color-primary" style="font-size: 14px;">
                                                        It would be great to see some improvement in <b>Basic Science /
                                                            Technology,</b> 
                                                    </strong>
                                                    @endif 
                                    
                                                    

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
                                                                <strong>EXCELLENT</strong>&nbsp;:&nbsp;80-100&nbsp;:&nbsp;A1,
                                                                <strong>VERY&nbsp;GOOD</strong>&nbsp;:&nbsp;75-79&nbsp;:&nbsp;B2,
                                                                <strong>GOOD</strong>&nbsp;:&nbsp;70-74&nbsp;:&nbsp;B3,
                                                                <strong>CREDIT</strong>&nbsp;:&nbsp;60-69&nbsp;:&nbsp;C4,
                                                                <strong>CREDIT</strong>&nbsp;:&nbsp;55-59&nbsp;:&nbsp;C5,
                                                                <strong>CREDIT</strong>&nbsp;:&nbsp;50-54&nbsp;:&nbsp;C6,
                                                                <strong>PASS</strong>&nbsp;:&nbsp;45-49&nbsp;:&nbsp;D7,
                                                                <strong>PASS</strong>&nbsp;:&nbsp;40-45&nbsp;:&nbsp;E,
                                                                <strong>FAIL</strong>&nbsp;:&nbsp;0-39&nbsp;:&nbsp;F,
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
                                                                <strong>EXCELLENT</strong>&nbsp;:&nbsp;5,
                                                                <strong>VERY&nbsp;GOOD</strong>&nbsp;:&nbsp;4,
                                                                <strong>GOOD</strong>&nbsp;:&nbsp;3,
                                                                <strong>NORMAL</strong>&nbsp;&nbsp;2,
                                                                <strong>FAIR</strong>&nbsp;:&nbsp;1, <strong>NO TICK</strong>&nbsp;:&nbsp;not recorded
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


                                            @foreach ($cognitives as $cognitive)     
                                                <tbody class="beh-d">
                                                    <tr>
                                                        <th>{{ $cognitive->title() }}</th>
                                                        <td>
                                                         @if ($cognitive->rate == 5)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($cognitive->rate == 4)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($cognitive->rate == 3)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                             @if ($cognitive->rate == 2)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($cognitive->rate == 1)
                                                                <i class="fa txt-color-primary -checkmark-round">✔</i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                 
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div id="mis-info">
                                        <div class="a-promo hidden"> <span class="text-bold">PROMOTION :</span>&nbsp;
                                            <span class="rinfo frmb7">***</span> 
                                        </div>
                                        <div class="a-acad-hd"> <span class="text-bold a-title">CLASS TEACHER
                                                :</span>&nbsp;
                                            <span class="rinfo frmb7">{{ $student->grade->gradeClassTeacher[0]->title() }}. {{ $student->grade->gradeClassTeacher[0]->name() }} </span> 
                                        </div>
                                        
                                        <div class="end-date"> <span class="text-bold">THIS TERM ENDS:</span> 
                                            <span class="rinfo frmb7">{{ $endOfTerm }}</span> </div>
                                        <div class="resump-date"> <span class="text-bold">NEXT TERM BEGINS:</span> 
                                            <span class="rinfo frmb7">{{ $endOfNextTerm }}</span> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-center">{{ application('motto') }}</p>

                        <div class="row mt-2">
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
            </div>
        </div>
    </div>
</x-app-layout>