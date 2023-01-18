<x-app-layout>
    @section('title', application('name')." | Primary Result Page")

    <div class="row">
        <div class="col-lg-12">
            <div class='parent'>
                <div class='col-xs-2 col-sm-2 col-md-2 text-center'>
                    <img class='img-rounded img-responsive' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' />
                </div>

                <div class='col-xs-8 col-sm-8 col-md-8 text-center'>
                    <h1 style="font-size: 35px; font-weight: bold; text-decoration: uppercase"> {{
                        application('name') }}</h1>
                        
                        <p style='font-size: 15px; font-family: Arial, Helvetica, sans-serif'>
                            {{ application('address') }}
                        </p>
                </div>

                <div class='col-xs-2 col-sm-2 col-md-2 text-center text-responsive'>
                    <img src='{{ asset('storage/'.$student->user->image()) }}' class='img-rounded img-responsive' alt='{{ $student->firstName()}}' />
                </div>
            </div>

            <div style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px">
                <p style="font-weight: bold; color: white; text-align: center">Evaluation Report Sheet</p>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center">
                <div style="border: 1px solid #000; padding: 0 15px; font-weight: bold; text-align: left">{{ $term->title() }}</div>
                <div style="border: 1px solid #000; padding: 0 15px; font-weight: bold; text-align: right">{{ $period->title() }}</div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 1px">
                <div style="width: 60%">
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
                            <tr>
                                <th>No. of Times Present</th>
                                <td>{{ $attendance }}</td>
                                <th>Out of:</th>
                                <td>{{ $termDuration }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div style="width: 30%">
                    <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <th>Sex</th>
                                <td>{{ ucfirst($student->gender())}}</td>
                            </tr>
                            <tr>
                                <th>No. In Class:</th>
                                <td>{{ $student->grade->count()}}</td>
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
                                <th>Admission</th>
                                <td>{{ $student->user->code()}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th colspan="6" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">2. PHYSICAL DEVELOPMENT</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th colspan="2" class="v-align">Height (m)</th>
                            <th colspan="2">Width (kg)</th>
                            <th rowspan="2" style="width: 20%"> </th>
                            <th rowspan="2">Nature of Illness</th>
                        </tr>
                        <tr>
                            <td>Beginning of Term</td>
                            <td>End of Term</td>
                            <td>Beginning of Term</td>
                            <td>End of Term</td>
                       
                        </tr>
                        <tr>
                            <td>{{ $endOfTerm }}</td>
                            <td>{{ $endOfTerm }}</td>
                            <td>{{ $endOfTerm }}</td>
                            <td>{{ $endOfTerm }}</td>
                            <td colspan="2"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-wrapper">
                @if ($term->id() === '1')
                    <table class="table table-bordered table-condensed">
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <th rowspan="3" style="width: 30%;">Subjects</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                            </tr>
                            <tr>
                                <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center">GRADE</th>
                                <th style="width: 5%; font-size: 10px; font-weight: 500; text-align: center" colspan="2">Remarks</th>
                            </tr>
                            </tr>
                            <tr style="text-align: center">
                                <th>20</th>
                                <th>20</th>
                                <th>10</th>
                                <th>10</th>
                                <th>60</th>
                                <th>40</th>
                                <th>100</th>
                                <th></th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="">
                            @foreach ($results as $result)
                                <tr>
                                    <td>{{ $result['subject'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca1'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca2'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca3'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['pr'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ct'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['exam'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['total'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ grade($result['total']) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ remark($result['total']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($term->id() === '2')
                    <table class="table table-bordered table-condensed">
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <th rowspan="3" style="width: 30%;">Subjects</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Activities</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                            </tr>
                            <tr>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">1st Term Score</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grand TOTAL</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Avg.</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg.</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center" colspan="2">Remarks</th>
                            </tr>
                            </tr>
                            <tr style="text-align: center">
                                <th>20</th>
                                <th>20</th>
                                <th>10</th>
                                <th>10</th>
                                <th>60</th>
                                <th>40</th>
                                <th>100</th>
                                <th>100</th>
                                <th>200</th>
                                <th></th>
                                <th></th>
                                <th>%</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="">
                            @foreach ($results as $result)
                                @php
                                    if ($term->id() === '2'){
                                        $total = $result['total'] + $result['first_term_cummulative'];
                                    }elseif($term->id() === '3'){
                                        $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $result['subject'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca1'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca2'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca3'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['pr'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ct'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['exam'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ color($result['total']) }}">{{ $result['total'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ color( $result['first_term_cummulative']) }}">{{ $result['first_term_cummulative'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ color(sum($result['total'], $result['first_term_cummulative'])) }}">{{ sum($result['total'], $result['first_term_cummulative']) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">{{ divnum(sum($result['total'], $result['first_term_cummulative']), 2) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; color: {{ color(grade(divnum(sum($result['total'], $result['first_term_cummulative']), 2))) }}">{{ grade(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">18</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center; width: 20%">{{ remark(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <table class="table table-bordered table-condensed">
                        <thead id="ch">
                            <tr>
                                <th colspan="15" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">3. COGNITIVE DOMAIN</th>
                            </tr>
                            <tr>
                                <th rowspan="3" style="width: 30%;">Subjects</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First Test</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Continuous Assessment </th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Re-Entry Test Class Activities</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">PROJECT</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">EXAM</th>
                                <th rowspan="2" style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL</th>
                            </tr>
                            <tr>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">1st TS</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">2nd TS</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Grand TOTAL</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Avg.</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">GRADE</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">Class Avg.</th>
                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center" colspan="2">Remarks</th>
                            </tr>
                            </tr>
                            <tr style="text-align: center">
                                <th>20</th>
                                <th>20</th>
                                <th>10</th>
                                <th>10</th>
                                <th>60</th>
                                <th>40</th>
                                <th>100</th>
                                <th>100</th>
                                <th>100</th>
                                <th>300</th>
                                <th>%</th>
                                <th></th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="">
                            @foreach ($results as $result)
                                @php
                                    if ($term->id() === '2'){
                                        $total = $result['total'] + $result['first_term_cummulative'];
                                    }elseif($term->id() === '3'){
                                        $total = $result['total'] + $result['first_term_cummulative'] + $result['second_term_cummulative'];
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $result['subject'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca1'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca2'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ca3'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['pr'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['ct'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['exam'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['total'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['first_term_cummulative'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ $result['second_term_cummulative'] }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">{{ grade(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}</td>
                                    <td style="font-size: 10px; font-weight: 500; text-align: center">18</td>
                                    <td style="font-size: 8px; font-weight: 500; text-align: center; width: 20%">{{ remark(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 1px">
                <div style="width: 70%">
                    <div style="display: flex; justify-content: space-between">
                        <div class="table-wrapper" style="width: 40%">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="v-align">BEHAVIOURS</th>
                                        <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">4. AFFECTIVE DOMAIN</th>
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
                         <div class="table-wrapper" style="width: 40%">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="v-align">BEHAVIOURS</th>
                                        <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">5. PSYCHOMOTIVE DOMAIN</th>
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
                </div>
                <div style="width: 20%">
                    <div class="table-wrapper">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">Grading</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="text-align: center">S/N</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">5</th>
                                    <td>Excellence</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">4</th>
                                    <td>Good</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">3</th>
                                    <td>Average</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">2</th>
                                    <td>Below Avarage</td>
                                </tr>
                                 <tr>
                                    <th style="text-align: center">1</th>
                                    <td>Unsatisfactory</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 1px">
                <div class="table-wrapper">
                    <table class="table table-condensed">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">INTERPRETATION OF RESULT</th>
                            </tr>
                             <tr>
                                <th style="padding: 0 25px">Color code</th>
                                <th style="padding: 0 25px">Over 60</th>
                                <th style="padding: 0 25px">Over 100</th>
                                <th style="padding: 0 25px">Grade</th>
                                <th style="padding: 0 25px">Remark</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            <tr>
                                <td>BLACK</td>
                                <td>48-60</td>
                                <td>80-100</td>
                                <td>A</td>
                                <td>EXCELLENT</td>
                            </tr>
                            <tr>
                                <td>BLACK</td>
                                <td>42-47.9</td>
                                <td>70-79.9</td>
                                <td>B</td>
                                <td>VERY GOOD</td>
                            </tr>
                            <tr>
                                <td>GREEN</td>
                                <td>42-47.9</td>
                                <td>70-79.9</td>
                                <td>B</td>
                                <td>GOOD</td>
                            </tr>
                            <tr>
                                <td>BLUE</td>
                                <td>34.8-35.9</td>
                                <td>70-79.9</td>
                                <td>B</td>
                                <td>PASS</td>
                            </tr>
                            <tr>
                                <td>BLUE</td>
                                <td>33.6-34.7</td>
                                <td>70-79.9</td>
                                <td>B</td>
                                <td>FAIR</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <div class="table-wrapper">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">ABBREVIATIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="text-align: center">FT</th>
                                    <td>FIRST TEST</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">CA1</th>
                                    <td>CONTINUOUS ASSESSMENT</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">CA2</th>
                                    <td>CLASS ACTVITIES</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">TS</th>
                                    <td>TERM SCORES</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  <div class="table-wrapper">
                    <table class="table table-condensed">
                        <thead style="text-align: center">
                            <tr>
                                <th colspan="5" style="padding: 0 25px; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">CLUB & SOCIETY</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            <tr>
                                <td colspan="5" style="height: 20px"></td>
                            </tr>
                              <tr>
                                <td colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">OFFICE HELD</td>
                            </tr>
                             <tr>
                                <td colspan="5" style="height: 20px"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 1px">
                 <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Class Teacher's Comment</th>
                            </tr>
                            <tr>
                                <th colspan="5" style="height: 20px"></th>
                            </tr>
                            <tr>
                                <th>Headmistress' Comment</th>
                            </tr>
                            <tr>
                                <th colspan="5" style="height: 20px"></th>
                            </tr>
                        </thead>
                    </table>
            </div>

            <div style="display: flex; justify-content: center; margin-top: 50px; position: relative">
                <img class='' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' style="position: absolute; width: 100px; left: 250px;  bottom: 0;" />
                <div style="border-bottom: 1px solid #000000; width: 300px;"></div>
                <div>Signature & School Stamp:</div>
                <div style="border-bottom: 1px solid #000000; width: 300px;"></div>
                <img class='' src='{{ asset('storage/'.application('image')) }}' alt='{{ application(' name')}}' style="position: absolute; width: 100px; right: 250px;  bottom: 0;" />
            </div>
            
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