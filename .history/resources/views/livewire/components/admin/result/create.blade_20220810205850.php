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
                    <div class='row'>
                       <form wire:submit.prevent='createResult'>
                            @foreach ($students as $student)
                                <div class='table-responsive'>
                                    <table class="table align-middle table-nowrap table-check">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Student Id</th>
                                                <th>CA1</th>
                                                <th>CA2</th>
                                                <th>Examination</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                                <td>fsgsdgs</td>
                                                <td>fsgsdgs</td>
                                                <td>fsgsdgs</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>