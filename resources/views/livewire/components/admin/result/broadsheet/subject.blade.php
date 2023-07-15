<div>
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @php
                        $grades = \App\Models\Grade::all();
                        $periods = \App\Models\Period::all();
                        $subjects = \App\Models\Subject::withoutGlobalScope(new \App\Scopes\AssignedSubjectsScope)->get();
                    @endphp

                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model.defer="grade_id" id="gradeSelect">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model.defer="subject_id" id="gradeSelect">
                                    <option value=''>Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{ $subject->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <select class="form-control " wire:model.defer="period_id" id="periodSelect">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="period_id" />
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
                            @endphp

                            @if ($studentResults)
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead id="ch">
                                        <tr>
                                            <th></th>
                                            <th>
                                                <th style="background-color: #502179; color: #ffffff" colspan="{{ count($midterm) + count($exam) }}" class="text-center">First Term</th>
                                            </th>
                                            <th>
                                                <th style="background-color: #502179; color: #ffffff" colspan="{{ count($midterm) + count($exam) }}" class="text-center">Second Term</th>
                                            </th>
                                            <th>
                                                <th style="background-color: #502179; color: #ffffff" colspan="{{ count($midterm) + count($exam) }}" class="text-center">Third Term</th>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>
                                                @foreach ($midterm as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                                @foreach ($exam as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                            </th>
                                            <th>
                                                @foreach ($midterm as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                                @foreach ($exam as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                            </th>
                                            <th>
                                                @foreach ($midterm as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                                @foreach ($exam as $key => $value)
                                                    <th class="text-center" style="font-size: 10px">{{ $value['full_name'] }}</th>
                                                @endforeach
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentResults as $student)
                                            <tr>
                                                <td>{{ $student['student_name'] }}</td>
                                                @foreach ($student['results'] as $results)
                                                   @foreach ($results as $result)
                                                        <td>
                                                            @foreach ($midterm as $midtermKey => $midtermValue)
                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                    @if ($result && isset($result[$midtermKey]))
                                                                        {{ $result[$midtermKey] }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            @endforeach

                                                            @foreach ($exam as $examKey => $examValue)
                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                    @if ($result && isset($result[$examKey]))
                                                                        {{ $result[$examKey] }}
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </td>
                                                   @endforeach
                                                @endforeach
                                                {{-- @foreach ($subjects as $subject)
                                                    @php
                                                        $subjectId = $subject['id'];
                                                        $subjectScores = array_filter($student['results'], function ($result) use ($subjectId) {
                                                            return $result['subject_id'] === $subjectId;
                                                        });
                                                        $subjectScores = reset($subjectScores); // Get the first matching result
                                                    @endphp

                                                    @foreach ($midterm as $midtermKey => $midtermValue)
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                            @if ($subjectScores && isset($subjectScores[$midtermKey]))
                                                                {{ $subjectScores[$midtermKey] }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    @endforeach

                                                    @foreach ($exam as $examKey => $examValue)
                                                        <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                            @if ($subjectScores && isset($subjectScores[$examKey]))
                                                                {{ $subjectScores[$examKey] }}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @endforeach --}}
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
