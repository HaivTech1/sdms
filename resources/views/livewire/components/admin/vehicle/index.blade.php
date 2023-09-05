<div>
    <div class="row mt-2 mb-2">
        @if ($selectedRows)
            <div class="col-sm-6">
                <div class="btn-group btn-group-example" role="group">
                    <button wire:click.prevent="deleteAll" type="button"
                        class="btn btn-outline-danger w-sm">
                        <i class="bx bx-trash"></i>
                        Delete All
                    </button>
                </div>
            </div>
        @endif
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
                            <th class="align-middle"> Name </th>
                            <th class="align-middle"> Plate Number</th>
                            <th class="align-middle"> Seats </th>
                            <th class="align-middle"> Type </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $key => $vehicle)
                        <tr>
                            <td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" value="{{ $vehicle->id() }}"
                                        type="checkbox" id="{{ $vehicle->id() }}"
                                        wire:model="selectedRows">
                                    <label class="form-check-label" for="{{ $vehicle->id() }}"></label>
                                </div>
                            </td>
                            <td>
                                {{ $vehicle->name() }}
                            </td>
                            <td>
                                {{ $vehicle->plateNo() }}
                            </td>
                            <td>
                                {{ $vehicle->seat() }}
                            </td>
                            <td>
                                {{ $vehicle->type() }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-danger btn-sm" wire:click="delete({{ $vehicle->id() }})"><i class="bx bx-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class='col-sm-4'>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add new vehicle</h4>
                    <form id="vehicleForm" method="POST" action="{{ route('vehicle.store') }}">
                        @csrf
                        <div class="col-sm-12 mb-3">
                            <x-form.label for="name" value="{{ __('Name') }}" />
                            <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                :value="old('name')" id="name" placeholder="First Name" autofocus />
                            <x-form.error for="name" />
                        </div>

                         <div class="col-sm-12 mb-3">
                            <x-form.label for="plate_no" value="{{ __('Plate number') }}" />
                            <x-form.input id="plate_no" class="block w-full mt-1" type="text" name="plate_no"
                                :value="old('plate_no')" id="plate_no" placeholder="First plate_no" autofocus />
                            <x-form.error for="plate_no" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="seats" value="{{ __('Seats') }}" />
                            <x-form.input id="seats" class="block w-full mt-1" type="text" name="seats"
                                :value="old('seats')" id="seats" placeholder="First seats" autofocus />
                            <x-form.error for="seats" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="type" value="{{ __('Type') }}" />
                            <select class="form-control" name="type">
                                <option>Select</option>
                                <option value="car">Car</option>
                                <option value="bus">Bus</option>
                            </select>
                        </div>

                         <div class="d-flex flex-wrap gap-2">
                            <button id="submit_vehicle" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>
             $(document).on('submit', '#vehicleForm', function (e) {
                e.preventDefault();

                var button = $('#submit_vehicle');
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
                        resetForm('#vehicleForm')
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
