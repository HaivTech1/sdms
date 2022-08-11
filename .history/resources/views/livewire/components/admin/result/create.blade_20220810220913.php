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
                            <select class="form-control select2" wire:model="grade">
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
                       <div class='col-sm-12'>
                            <form wire:submit.prevent='createResult'>
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
                                        @foreach ($students as $student)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number' wire:model.defer='state.ca1' autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number' wire:model.defer='state.ca2' autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number' wire:model.defer='state.ca3' autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number' wire:model.defer='state.exam' autofocus />
                                                    </td>
                                                    <td>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                                    <td>{{ $student->id() }}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach 
                                    </table>
                                </div>
                                <div class="d-flex">
                                    <button class='float-right'>Upload</button>
                                </div>
                            </form>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>