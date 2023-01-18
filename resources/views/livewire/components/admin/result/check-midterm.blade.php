<div>
    <x-loading />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.grade_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="state.period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.period_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.term_id" />
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
                    <div class="row">
                        <div class="col-12">
                            @if ($state)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                @admin
                                                <th scope="col" class="text-center">Name of Student</th>
                                                @endadmin
                                                <th scope="col" class="text-center">
                                                    Class
                                                </th>
                                                <th scope="col" class="text-center">
                                                    Total Subjects
                                                </th>
                                                <th scope="col" class="text-center">
                                                    Recorded Subjects
                                                </th>

                                                <th scope="col" class="text-center" id="action">
                                                    Action
                                                </th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($students as $student)
                                            <tr>
                                                @admin
                                                <td class='text-left'>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                                @endadmin
                                                <td class='text-center'>{{ $student->grade->title() }}</td>
                                                <td class='text-center'>
                                                    <div class="btn-group dropend">
                                                        <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $student->totalSubjects() }} <i class="mdi mdi-chevron-right"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($student->subjects as $subject)
                                                                <p class="dropdown-item">{{ $subject->title() }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class='text-center'>
                                                    <div class="btn-group dropend">
                                                        <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $student->midTermResults->where('term_id', $term_id)->where('period_id', $period_id)->count() }} <i class="mdi mdi-chevron-right"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($student->midTermResults as $result)
                                                                <p class="dropdown-item">{{ $result->subject->title() }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class='d-flex justify-content-center align-items-center gap-2'>
                                                    <a href="{{ route('result.midterm.show', $student) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}"
                                                        type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Click to view result">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @admin
                                                        <button type="button" id='cummulative' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                            <i class="mdi mdi-upload d-block font-size-16"></i> 
                                                        </button>
                                                    @endadmin
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $students->links('pagination::custom-pagination')}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
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

</div>
