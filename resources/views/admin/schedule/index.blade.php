<x-app-layout>
    @section('title', application('name')." | Schedule Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Schedules</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-8">
                                <div class="row">

                                </div>
                            </div>
                            <div class=" col-sm-4">
                                <div class="text-sm-end">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".addNew">Add Schedule</button>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-sm-12'>
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table align-middle table-nowrap table-check">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="align-middle">#</th>
                                                <th class="align-middle"> Shift</th>
                                                <th class="align-middle"> Time in</th>
                                                <th class="align-middle"> Time Out</th>
                                                <th class="align-middle">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schedules as $schedule)
                                            <tr>
                                                <td> {{ $schedule->id }} </td>
                                                <td> {{ $schedule->slug }} </td>
                                                <td> {{ $schedule->time_in }} </td>
                                                <td> {{ $schedule->time_out }} </td>
                                                <td>

                                                    <a href="#edit{{ $schedule->slug }}" data-toggle="modal"
                                                        class="btn btn-success btn-sm edit btn-flat"><i
                                                            class='fa fa-edit'></i>
                                                        Edit</a>
                                                    <a href="#delete{{ $schedule->slug }}" data-toggle="modal"
                                                        class="btn btn-danger btn-sm delete btn-flat"><i
                                                            class='fa fa-trash'></i> Delete</a>

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
</x-app-layout>

@include('partials.add_schedule')

@foreach ($schedules as $schedule)
@include('partials.edit_delete_schedule')
@endforeach