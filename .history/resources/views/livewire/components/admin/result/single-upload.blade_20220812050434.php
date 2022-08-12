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
                                @if (count($results) > 0)
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
                                                    <th>Uploaded by</th>
                                                    <th>Uploaded Date</th>
                                                </tr>
                                            </thead>
                                            @foreach ($results as $index => $result)
                                                <tbody wire:ignore>
                                                    <tr id='{{ $result->id() }}'>
                                                        <td>
                                                            <livewire:components.edit-title :model='$result' field='ca1' :key='$result->id()' />
                                                        </td>
                                                        <td>
                                                            <livewire:components.edit-title :model='$result' field='ca2' :key='$result->id()' />
                                                        </td>
                                                        <td>
                                                            <livewire:components.edit-title :model='$result' field='ca3' :key='$result->id()' />
                                                        </td>
                                                        <td>
                                                            <livewire:components.edit-title :model='$result' field='exam' :key='$result->id()' />
                                                        </td>
                                                        <td>
                                                            {{ $result->student->firstName() }} {{ $result->student->lastName() }}
                                                        </td>
                                                        <td>{{ $result->student->id() }}</td>
                                                        <td>{{ $result->author()->name() }}</td>
                                                        <td>{{ $result->createdAt() }}</td>
                                                        {{-- <td>
                                                            <a href="{{ route('result.show', $result) }}" class="dropdown-item">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td> --}}
                                                    </tr>
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>