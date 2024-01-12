<div>
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @php
                        $grades = \App\Models\Grade::all();
                        $periods = \App\Models\Period::all();
                        $terms = \App\Models\Term::all();
                    @endphp

                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="grade_id" id="gradeSelect">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="period_id" id="periodSelect">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="period_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="term_id" id="gradeTerm">
                                    <option value=''>Term</option>
                                    @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" id="fetch_btn" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                        Fetch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">

                            @php
                                $midterm = get_settings('midterm_format');
                                $exam = get_settings('exam_format');
                                $spanCount = count($midterm) + count($exam) + 1;
                            @endphp

                            @if ($studentResults && $subjects)
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Student Name</th>
                                            @foreach ($subjects as $subject)
                                                <th colspan="{{ $spanCount }}" class="text-center">{{ $subject['title'] }}</th>
                                            @endforeach
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            @foreach ($subjects as $subject)
                                                @foreach ($midterm as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                                @foreach ($exam as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                                <th class="text-center" style="font-size: 10px">Total</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($studentResults as $key => $student)
                                           <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $student['student_name'] }}</td>
                                                @foreach ($subjects as $subject)
                                                    @php
                                                        $subjectResult = null;
                                                        foreach ($student['results'] as $result) {
                                                            if ($result['subject_id'] == $subject['id']) {
                                                                $subjectResult = $result;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @foreach ($midterm as $midtermKey => $midtermValue)
                                                        <td style="text-align: center">
                                                            @if ($subjectResult && isset($subjectResult[$midtermKey]))
                                                                <p style="color: {{ exam20Color($subjectResult[$midtermKey]) }}">{{ $subjectResult[$midtermKey] }}</p>
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    @foreach ($exam as $examKey => $examValue)
                                                        <td style="text-align: center">
                                                            @if ($subjectResult && isset($subjectResult[$examKey]))
                                                                <p style="color: {{ exam60Color($subjectResult[$examKey]) }}">{{ $subjectResult[$examKey] }}</p>
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    @endforeach

                                                    {{-- <td style="text-align: center">
                                                        @if ($subjectResult)
                                                            <p style="color: {{ exam200Color($subjectResult['exam']) }}">{{ $subjectResult['exam'] }}</p>
                                                        @else
                                                            0
                                                        @endif
                                                    </td> --}}
                                                    <td style="font-weight: 500; color: {{ exam100Color(calculateResult($subjectResult)) }}">{{ calculateResult($subjectResult) }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
