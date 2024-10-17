<x-app-layout>
    @section('title', application('name') . " | Session Setting")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Session Setting</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="headingOne">
                        <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne"
                        >
                            Action Tab
                        </button>
                    </h2>

                    <div
                        id="collapseOne"
                        class="accordion-collapse collapse show"
                        aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample"
                    >
                        <div class="accordion-body">
                            <button id="deleteAll" type="button" class="btn btn-sm btn-danger">
                                <i class="bx bx-trash"></i>
                                Delete All
                            </button>
                            
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target=".settingModal">
                                <i class="bx bx-edit"></i>
                                Create
                                New
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-sm-12'>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                            wire:model="selectPageRows">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Session</th>
                                <th class="align-middle">Term</th>
                                <th class="align-middle">Resumption Date</th>
                                <th class="align-middle">Vacation Date</th>
                                <th class="align-middle">No School Opened</th>
                                <th class="align-middle">Next Term Resumption</th>
                                <th class="align-middle">No of Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settings as $key => $setting)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" data-rows-group-id='settings' value="{{ $setting->id }}"
                                                type="checkbox" id="{{ $setting->id }}"
                                                data-id="{{ $setting->id }}"
                                            >
                                            <label class="form-check-label" for="{{ $setting->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $setting->period->title() }}
                                    </td>
                                    <td>
                                        {{ $setting->term->title() }}
                                    </td>
                                    <td>
                                        {{ $setting->resumption_date->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        {{ $setting->vacation_date->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        {{ $setting->no_school_opened }}
                                    </td>
                                    <td>
                                        {{ $setting->next_term_resumption->format('Y-m-d') }}
                                    </td> 
                                    <td>
                                         <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $setting->id }}">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $setting->id }}" aria-expanded="true" aria-controls="collapse{{ $setting->id }}">
                                                        Click to expand
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $setting->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $setting->id }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @if(isset($setting->class_count))
                                                            @php
                                                                $gradeCount = getGradesWithStudentCount($setting->class_count)
                                                            @endphp

                                                            @foreach ($gradeCount as $count)
                                                                <p>
                                                                    <span>{{ $count['grade_name']}}: </span>
                                                                    <span>{{ $count['student_count']}}</span>
                                                                </p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $settings->links('pagination::bootstrap-4') }}
            </div>
        </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade settingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create new term settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="settingTermForm" action="{{ route('appSetting.termSetting') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form.label for="period_id" value="{{ __('Session') }}" />
                            <select class="form-control select2" name="period_id">
                                <option value="">Select</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}">{{ $session->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="term_id" value="{{ __('Term') }}" />
                            <select class="form-control select2" name="term_id">
                                <option value="">Select</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}">{{ $term->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <x-form.label for="no_school_opened" value="{{ __('No. of time school Opened') }}" />
                            <x-form.input id="no_school_opened" class="block w-full mt-1" type="number"
                                name="no_school_opened" :value="old('no_school_opened')" id="no_school_opened"
                                autofocus />
                            <x-form.error for="no_school_opened" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.label for="resumption_date" value="{{ __('Resumption Date') }}" />
                            <x-form.input id="resumption_date" class="block w-full mt-1" type="date"
                                name="resumption_date" :value="old('resumption_date')" id="resumption_date" autofocus />
                            <x-form.error for="resumption_date" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.label for="vacation_date" value="{{ __('Vacation Date') }}" />
                            <x-form.input id="vacation_date" class="block w-full mt-1" type="date" name="vacation_date"
                                :value="old('vacation_date')" id="vacation_date" autofocus />
                            <x-form.error for="vacation_date" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.label for="next_term_resumption" value="{{ __('Next Term Resumption Date') }}" />
                            <x-form.input id="next_term_resumption" class="block w-full mt-1" type="date"
                                name="next_term_resumption" :value="old('next_term_resumption')"
                                id="next_term_resumption" autofocus />
                            <x-form.error for="next_term_resumption" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <h5><b>Total Number of Students Per Class</b></h5>
                            <div class="row mt-2">
                                @foreach ($grades as $grade)
                                    <div class="col-sm-12 d-flex align-items-center justify-content-between border p-1 my-1">
                                        <div>
                                            <h4>{{ $grade->title }}</h4>
                                        </div>
                                        <div>
                                            <x-form.input id="{{ $grade->id }}" name="class_count[{{ $grade->id }}][]" class="block w-full mt-1" type="number" value="{{ $grade->students()->count()}}" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                            <button id="settingTermBtn" type="submit"
                                class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @section('scripts')
        <script>

            $('#deleteAll').on('click', function(){
                var button = $(this);
                let selectedIds = [];

                $('input:checkbox[data-rows-group-id="settings"]:checked').each(function () {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length < 1) {
                    alert("Please select at lease one row", "error");
                    return;
                }

                Swal.fire({
                    title: "Delete Session Setting",
                    text: 'Are you sure you want to delete the session setting?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, proceed!",
                    cancelButtonText: "No, cancel",
                }).then((result) => {
                    var _token = "{{ csrf_token() }}";
                    if (result.isConfirmed) {
                       $.ajax({
                            url: "{{ route('admin.period.setting.deleteAll')}}",
                            type: "POST",
                            data: {
                                _token: _token,
                                ids: selectedIds
                            },
                            beforeSend: function () {
                                button.LoadingOverlay("show");
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: "Setting Deleted",
                                    text: data.message,
                                    icon: 'success'
                                });

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            },
                            error: function (data) {
                                button.LoadingOverlay("hide");
                                Swal.fire({
                                    title: "Action Failed!",
                                    text: data.responseJSON.message,
                                    icon: 'error',
                                });
                            },
                            complete: function (xhr, textStatus) {
                                button.LoadingOverlay("hide");
                            },
                        });
                    }
                });
            });

            $(document).on('submit', '#settingTermForm', function (e) {
                e.preventDefault();
                var button = $('#settingTermBtn');

                var url = $(this).attr('action');
                var data = $(this).serializeArray();
                var method = $(this).attr('method');

                $.ajax({
                    url,
                    method,
                    data,
                    beforeSend: function(){
                        button.LoadingOverlay('show');
                    },
                    success: function(res){
                        if (res.status === true) {
                            toggleAble('#settingTermBtn', false);
                            toastr.success(res.message, 'Success!');
                            resetForm('#settingTermForm')
                            $('.settingModal').modal('toggle');

                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    },
                    error: function(err){
                        button.LoadingOverlay('hide');
                        toastr.error(err.responseJSON.message, 'Failed!');
                    },
                    complete: function(err){
                        button.LoadingOverlay('hide');
                    }
                });
            });
        </script>
    @endsection

</x-app-layout>