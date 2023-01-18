<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card-body">            
                    <form wire:submit.prevent='selectStudent'>
                        <div class="row">
                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mt-2">
                                <select class="form-control select2" wire:model.defer="state.student_id">
                                    <option value=''>Select Student</option>
                                    @foreach ($students as $student)
                                    <option value="{{  $student->id() }}">{{ $student->firstName() }} {{
                                        $student->lastName() }}
                                    </option>
                                    @endforeach
                                    <x-form.error for="state.student_id" />
                                </select>
                            </div>

                            <div class="col-lg-2 mt-2">
                                <select class="form-control " wire:model.defer="state.period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                    <x-form.error for="state.period_id" />
                                </select>

                            </div>

                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model.defer="state.term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                    <x-form.error for="state.term_id" />
                                </select>

                            </div>

                            <div class="col-lg-3">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class='row mt-4'>
                        <div class='col-xs-12 col-sm-12 col-md-12 text-center mb-4'>
                            <div class="row">
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
                                            <span>Class:
                                                @if ($selectedGrade)
                                                {{ $selectedGrade->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Student:
                                                @if ($selectedStudent)
                                                {{ $selectedStudent->firstName() }} {{ $selectedStudent->lastName() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($selectedTerm)
                            <form action="{{ route('result.storeSinglePrimaryUpload') }}" method="POST">
                                @csrf

                                <div class='col-sm-12'>
                            
                                    <x-form.input style='width: 50px' class="text-center" type='hidden' name='period_id'
                                        value="{{ $selectedPeriod->id() }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden' name='term_id'
                                        value="{{ $selectedTerm->id() }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden' name='grade_id'
                                        value="{{ $grade_id }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden' name='student_id'
                                        value="{{  $selectedStudent->id() }}" autofocus />

                                    <div class='table-responsive'>
                                        <table class="table align-middle table-nowrap table-check">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>CA1</th>
                                                    <th>CA2</th>
                                                    <th>CA3</th>
                                                    <th>Project</th>
                                                    <th>Examination</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>20</th>
                                                    <th>20</th>
                                                    <th>10</th>
                                                    <th>10</th>
                                                    <th>40</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($selectedStudent->subjects as $subject)
                                                <tr>
                                                    <td>
                                                        {{ $subject->title() }}
                                                        <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                            name='subject_id[]' value="{{ $subject->id() }}" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca1[]' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca2[]' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca3[]' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='pr[]' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='exam[]' value="" autofocus />
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                        <button type="submit"
                                            class="btn btn-primary block waves-effect waves-light pull-right">
                                            Upload Result
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        
                    </div>
            </div>
        </div>
    </div>
</div>