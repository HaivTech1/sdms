<div>
    <div class="row mt-2 mb-2">
        @if ($selectedRows)
            <div class="col-sm-1">
                <div class="btn-group btn-group-example" role="group">
                    <button wire:click.prevent="deleteAll" type="button"
                        class="btn btn-outline-danger w-sm">
                        <i class="bx bx-trash"></i>
                        Delete All
                </button>
                </div>
            </div>
        @endif
        <div class="col-sm-1">
            <form action="{{ route('trip.download-pdf') }}" method="POST">
                @csrf
                <div class="btn-group btn-group-example" role="group">
                    <button type="submit"
                        class="btn btn-sm btn-primary w-sm">
                        Trips list
                    </button>
                </div>
            </form>
        </div>
        <div class="col-sm-1">
            <div class="btn-group btn-group-example" role="group">
                <button type="button" data-bs-toggle="modal" data-bs-target=".generateTripPaidList" 
                    class="btn btn-sm btn-success w-sm">
                    Paid List
                </button>
            </div>
        </div>
        <div class="col-sm-1">
            <div class="btn-group btn-group-example" role="group">
                <button type="button" data-bs-toggle="modal" data-bs-target=".generateTripUnPaidList"
                    class="btn btn-sm btn-danger w-sm">
                    Debtors list
                </button>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-8'>
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
                            <th class="align-middle"> Address </th>
                            <th class="align-middle"> Space</th>
                            <th class="align-middle"> Price </th>
                            <th class="align-middle"> Status </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $key => $trip)
                        <tr>
                            <td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" value="{{ $trip->id() }}"
                                        type="checkbox" id="{{ $trip->id() }}"
                                        wire:model="selectedRows">
                                    <label class="form-check-label" for="{{ $trip->id() }}"></label>
                                </div>
                            </td>
                            <td>
                                {{ $trip->address() }}
                            </td>
                            <td>
                                {{ $trip->studentsCount() }}
                            </td>
                            <td>
                                {{ trans('global.naira') }} {{ number_format($trip->price(), 2) }}
                            </td>
                            <td>
                                <livewire:components.toggle-button :model='$trip' field='status' :key='$trip->id()' />
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-danger btn-sm" wire:click="delete({{ $trip->id() }})"><i class="bx bx-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $trips->links('pagination::custom-pagination') }}
            </div>
        </div>

        <div class='col-sm-4'>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add new trip</h4>
                    <form id="tripForm" method="POST" action="{{ route('trip.store') }}">
                        @csrf
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="address" value="{{ __('Address') }}" />
                            <x-form.input id="address" class="block w-full mt-1" type="text" name="address"
                                :value="old('address')" id="address" autofocus />
                            <x-form.error for="address" />
                        </div>

                         <div class="col-sm-12 mb-3">
                            <x-form.label for="price" value="{{ __('Price') }}" />
                            <x-form.input id="price" class="block w-full mt-1" type="text" name="price"
                                :value="old('price')" id="price" autofocus />
                            <x-form.error for="price" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="no_of_students" value="{{ __('No of space') }}" />
                            <x-form.input id="no_of_students" class="block w-full mt-1" type="text" name="no_of_students"
                                :value="old('no_of_students')" id="no_of_students" autofocus />
                            <x-form.error for="no_of_students" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="split">Enable Split Payment: </label>
                                <input type="checkbox" id="split" name="split" value="1">
                            </div>
                        </div>

                        <div class="form-group mb-2" id="splitTypeField" style="display: none">
                            <label for="split_type">Split Type:</label>
                            <select name="split_type" id="split_type" class="form-control">
                                <option value="">Select payment type</option>
                                <option value="daily">Daily</option>
                                <option value="monthly">Monthly</option>
                                <option value="termly">Termly</option>
                            </select>
                        </div>

                         <div class="d-flex flex-wrap gap-2">
                            <button id="submit_trip" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade generateTripPaidList" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate trip paid list</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modalErrorr"></div>

                        <div class="row">
                            <form action="{{ route('trip.generate.paid') }}" method="POST">
                                @csrf
                                
                                @php
                                    $grades = \App\Models\Grade::all();
                                    $periods = \App\Models\Period::all();
                                    $terms = \App\Models\Term::all();
                                @endphp

                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" name="trip_id">
                                            <option value=''>Select Trip</option>
                                            @foreach ($trips as $trip)
                                            <option value="{{  $trip->id() }}">{{  $trip->address() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="grade_id">
                                            <option value=''>Class</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <select class="form-control" name="period_id">
                                            <option value=''>Session</option>
                                            @foreach ($periods as $period)
                                            <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="term_id">
                                            <option value=''>Term</option>
                                            @foreach ($terms as $term)
                                            <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center flex-wrap mt-2">
                                    <button id="generate_paid_list" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Generate List
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade generateTripUnPaidList" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate trip unpaid list</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modalErrorr"></div>

                        <div class="row">
                            <form action="{{ route('trip.generate.unpaid') }}" method="POST">
                                @csrf
                                
                                @php
                                    $grades = \App\Models\Grade::all();
                                    $periods = \App\Models\Period::all();
                                    $terms = \App\Models\Term::all();
                                @endphp

                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" name="trip_id">
                                            <option value=''>Select Trip</option>
                                            @foreach ($trips as $trip)
                                            <option value="{{  $trip->id() }}">{{  $trip->address() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="grade_id">
                                            <option value=''>Class</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <select class="form-control" name="period_id">
                                            <option value=''>Session</option>
                                            @foreach ($periods as $period)
                                            <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" name="term_id">
                                            <option value=''>Term</option>
                                            @foreach ($terms as $term)
                                            <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center flex-wrap mt-2">
                                    <button id="generate_paid_list" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Generate List
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')

        <script>
            $(document).ready(function() {
                $('#split').change(function() {
                    if ($(this).is(':checked')) {
                        $('#splitTypeField').show();
                    } else {
                        $('#splitTypeField').hide();
                    }
                });
            });
        </script>

        <script>
            $(document).on('submit', '#tripForm', function (e) {
                e.preventDefault();

                var button = $('#submit_trip');
                toggleAble(button, true, 'Submitting...');
                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data,
                }).done((res) => {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#tripForm')
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000)
                }).fail((err) => {
                    toggleAble(button, false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });
        </script>
    @endsection
</div>
