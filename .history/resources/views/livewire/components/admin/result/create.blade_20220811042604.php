<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <select class="form-control " wire:model="period_id">
                                <option value=''>Select Session</option>
                                @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-lg-3">
                            <select class="form-control select2" wire:model="term_id">
                                <option value=''>Select Term</option>
                                @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-lg-3">
                            <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control select2" wire:model="subject_id">
                                <option value=''>Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='row mt-4'>
                        <div class='col-xs-12 col-sm-12 col-md-12 text-center mb-4'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3> {{ application('name') }}</h3>
                                    <p class='text-danger'>
                                    {{ application('address') }}<br/>
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <span>Session: 
                                                @if ($selectedPeriod)
                                                    {{ $selectedPeriod->title() }}
                                                @else
                                                    Nil
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <span>Term: 
                                                @if ($selectedTerm)
                                                    {{ $selectedTerm->title() }}
                                                @else
                                                    Nil
                                                @endif
                                            </span>
                                        </div>
                                       
                                        <div class="col-sm-3">
                                            <span>Class:</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <span>Subject:</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class='col-sm-12'>
                            <form action="{{ route('result.store') }}" method="POST">
                                @csrf
                                <div class='table-responsive'>
                                    <table class="table align-middle table-nowrap table-check">
                                        <thead class="table-light">
                                            <tr>
                                                <th>CA1</th>
                                                <th>CA2</th>
                                                <th>CA3</th>
                                                <th>Examination</th>
                                                <th>Student Name</th>
                                                <th>Student Id</th>
                                            </tr>
                                        </thead>
                                        @foreach ($students as $index => $student)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number' name='ca1'  autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px'  class="text-center" type='number' name='ca2'  autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px'  class="text-center" type='number' name='ca3'  autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px'  class="text-center" type='number' name='exam' autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px'  class="text-center" type='text' name='period_id' value="{{ $period_id }}"  autofocus />
                                                        <x-form.input style='width: 50px'  class="text-center" type='text' name='term_id' value="{{ $term_id }}"  autofocus />
                                                        <x-form.input style='width: 50px'  class="text-center" type='text' name='grade_id' value="{{ $grade_id }}"  autofocus />
                                                        <x-form.input style='width: 50px'  class="text-center" type='text' name='subject_id' value="{{ $subject_id }}"  autofocus />
                                                        <x-form.input style='width: 50px'  class="text-center" type='text' name='student_id' value="{{  $student->id() }}"  autofocus />
                                                        {{ $student->firstName() }} {{ $student->lastName() }}
                                                    </td>
                                                    <td>{{ $student->id() }}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach 
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Upload</button>
                                </div>
                            </form>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>