<div>
    <x-loading />

    <div class="row">
         <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">

                                        @php
                                            $sessions = \App\Models\Period::all();
                                            $terms = \App\Models\Term::all();
                                            $grades = \App\Models\Grade::all();
                                        @endphp

                                        <form wire:submit.prevent='fetchStat'>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <select class="form-control select2" wire:model.defer="session">
                                                        <option value=''>Select Session</option>
                                                        @foreach ($sessions as $session)
                                                            <option value="{{ $session->id }}">{{ $session->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-2">
                                                    <select class="form-control select2" wire:model.defer="grade">
                                                        <option value=''>Select Semester</option>
                                                        @foreach ($terms as $term)
                                                            <option value="{{ $term->id }}">{{ $term->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-2">
                                                    @admin
                                                        <select class="form-control select2" wire:model.defer="grade">
                                                            <option value=''>Select Grade</option>
                                                            @foreach ($grades as $grade)
                                                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endadmin
                                                    @teacher
                                                        <select class="form-control select2" wire:model.defer="grade">
                                                            <option value=''>Select Grade</option>
                                                            @foreach (auth()->user()->gradeClassTeacher as $grade)
                                                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endteacher
                                                </div>

                                                <div class="col-lg-2">
                                                    <x-search />
                                                </div>

                                                <div class="col-lg-2">
                                                    <Button class="btn btn-sm btn-primary">Fetch</Button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                     <div class='row'>
                        <div class='col-sm-12'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> All Attendance </th>
                                            <th class="align-middle">No. of time present </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $key => $attendance)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $attendance['name'] }}
                                            </td>
                                            <td>
                                                {{ $attendance['total_attendance'] }}
                                            </td>
                                            <td>
                                                {{ $attendance['present_count'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>