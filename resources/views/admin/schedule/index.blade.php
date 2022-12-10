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

    @section('scripts')

        <script>

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })

            fetchSchedule();

            function fetchSchedule(){
                $.ajax({
                    type: 'GET',
                    url: '{{ route('schedule.fetch') }}',
                    dataType: 'json',
                    success: function(response) {
                        $('tbody').html("");
                        $.each(response.schedules, function(index, schedule) {
                            $('tbody').append(
                                `
                                <tr>
                                    <td> `+schedule.id+`</td>
                                    <td> `+schedule.slug+` </td>
                                    <td> `+startTime(schedule.time_in)+` </td>
                                    <td> `+startTime(schedule.time_out)+` </td>
                                    <td>
                                        <button value="`+schedule.id+`" data-toggle="modal"
                                            class="btn btn-success btn-sm edit_btn btn-flat"><i
                                                class='fa fa-edit'></i>
                                        </button>
                                        <button value="`+schedule.id+`" data-toggle="modal"
                                            class="btn btn-danger btn-sm delete_btn btn-flat"><i
                                                class='fa fa-trash'></i>
                                        </button>
                                    </td>
                                </tr>
                                `
                            );
                        })
                    }
                });
            }

            function startTime(s) {
                var today = new Date(s);
                var h = today.getHours(s);
                var m = today.getMinutes(s);
                var s = today.getSeconds(s);
                var time = h + ":" + m + ":" + s;
                return time;
            }

            $(document).on('click', '.edit_btn', function(e){
                e.preventDefault();
                var sch_id = $(this).val();
                $('.editSchedule').modal('show');

                $.ajax({
                    type: "GET",
                    url: '/schedule/edit-schedule/'+sch_id,
                    success: function(response){
                        $('#schedule_id').val(response.schedule.id);
                        $('#edit_name').val(response.schedule.slug);
                        $('#edit_time_in').val(startTime(response.schedule.time_in));
                        $('#edit__time_out').val(startTime(response.schedule.time_out));
                    }
                });
            })

            $(document).on('submit', '#updateSchdule', function(e){
                e.preventDefault();
                toggleAble('#edit_btn', true, 'Submitting...');
                var id = $('#schedule_id').val();
                let editFormData = new FormData($('#updateSchdule')[0]);

                $.ajax({
                    type: 'POST',
                    url: '/schedule/update-schedule/'+id,
                    data: editFormData,
                    contentType: false,
                    processData: false,
                }).then((response) => {
                    toggleAble('#edit_btn', false);
                    toastr.success(response.message);
                    window.location.reload();
                }).catch((error) => {
                    toggleAble('#edit_btn', false);
                    toastr.error(error);
                })
            })
        </script>
        
    @endsection
</x-app-layout>

@include('partials.add_schedule')
@include('partials.edit_schedule')

@foreach ($schedules as $schedule)
@include('partials.edit_delete_schedule')
@endforeach