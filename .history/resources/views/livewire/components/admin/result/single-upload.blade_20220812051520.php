<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                            <div class="col-lg-3">
                                <x-form.input class="text-center" type='text'  list="datalistOptions"
                                        name='period_id' value="{{ $period_id }}" wire:model="student_id" />
                                    <datalist id="datalistOptions">
                                        @foreach ($students as $student)
                                            <option value="{{  $student->id() }}">{{  $student->firstName() }} {{  $student->lastName() }}</option>
                                        @endforeach
                                    </datalist>
                                <select class="form-control select2" wire:model="student_id">
                                    <option value=''>Select Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{  $student->id() }}">{{  $student->firstName() }} {{  $student->lastName() }}</option>
                                    @endforeach
                                </select>
    
                            </div>

                            <div class="col-lg-2">
                                <select class="form-control select2" wire:model="subject_id">
                                    <option value=''>Subject</option>
                                    @foreach ($subjects as $subject)
                                    <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-lg-2">
                                <select class="form-control " wire:model="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
    
                            <div class="col-lg-2">
                                <select class="form-control select2" wire:model="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
                        </form>
                    </div>
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
                                            <span>Subject:
                                                @if ($selectedSubject)
                                                {{ $selectedSubject->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($student_id)
                            <div class='col-sm-12'>
                                <form action="{{ route('result.store') }}" method="POST">
                                    @csrf

                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                        name='period_id' value="{{ $period_id }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                        name='term_id' value="{{ $term_id }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                        name='grade_id' value="{{ $grade_id }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                        name='subject_id' value="{{ $subject_id }}" autofocus />
                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                        name='student_id' value="{{  $student_id }}" autofocus />

                                    <div class='table-responsive'>
                                        <table class="table align-middle table-nowrap table-check">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>CA1</th>
                                                    <th>CA2</th>
                                                    <th>CA3</th>
                                                    <th>Examination</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca1' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca2' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca3' value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='exam' value="" autofocus />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                        <button type="submit"
                                            class="btn btn-primary block waves-effect waves-light pull-right">
                                            Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>