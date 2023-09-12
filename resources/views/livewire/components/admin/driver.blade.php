<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Registered drivers</p>
                                            <h4 class="mb-0">{{ count($allDrivers) }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Active drivers</p>
                                            <h4 class="mb-0">{{ count($activeDrivers) }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Unactive drivers</p>
                                            <h4 class="mb-0">{{ count($unactiveDrivers) }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        @if($search)
                                        <div class="col-6">
                                            <button wire:click.prevent="resetSearch" type=" button"
                                                class="btn btn-danger waves-effect btn-label waves-light">
                                                <i class="bx bx-block label-icon "></i>
                                                clear search
                                            </button>
                                        </div>
                                        @endif
                                        @if($selectedRows)
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-danger w-sm">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                                <button wire:click.prevent="disableAll" type="button"
                                                    class="btn btn-outline-warning w-sm">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                                <button wire:click.prevent="undisableAll" type="button"
                                                    class="btn btn-outline-success w-sm">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                                <button wire:click.prevent="sendDetails" type="button"
                                                    class="btn btn-outline-info w-sm">
                                                    <i class="bx bx-key"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

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
                                    <th class="align-middle"></th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Email</th>
                                    <th class="align-middle">Vehicle</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $driver->id() }}" type="checkbox"
                                                id="{{ $driver->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="{{ $driver->id() }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <img class="rounded-circle avatar-xs"
                                                src="{{ asset('storage/'.$driver->image()) }}"
                                                alt="{{ $driver->name() }}">
                                        </div>
                                    </td>
                                    <td>
                                        <livewire:components.edit-title :model='$driver' field='name'
                                            :key='$driver->id()' />
                                    </td>
                                    <td>
                                        <livewire:components.edit-title :model='$driver' field='email'
                                            :key='$driver->id()' />
                                    </td>
                                    <td>
                                        @foreach ($driver->vehicleDriver  as $key => $vehicle)
                                            <ul class="">
                                                <li>
                                                    <span class="mr-1">({{ $key+1 }}) </span>
                                                    <span class="mr-2">{{ $vehicle->name }} - </span>
                                                    <span>{{ $vehicle->plate_no }}</span>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button class="dropdown-item" type="button" value="{{ $driver->id() }}" id="assignVehicle">
                                                    <i class="fas fa-compress-arrows-alt"></i> Assign Vehicle
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $drivers->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>

        <div class="modal fade addVehicle bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="createVehicleDriver">
                                    @csrf

                                    <x-form.input type="hidden" value="" name="driver_id" id="driver_id" />
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select name="vehicle_id" class="form-control" id="vehicles">
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                        <button type="submit" id="submit_vehicle" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).on('click', '#assignVehicle', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var button = $(this);
                toggleAble(button, true);

                $.ajax({
                    url: "{{ route('vehicle.list') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        toggleAble(button, false);
                        var vehicles = response.vehicles
                        console.log(id);

                        $.each(vehicles, function(index, vehicle) {
                           $('#vehicles').append($('<option>', {
                                value: vehicle.id,
                                text: vehicle.name
                            }));
                        });

                        $('#driver_id').val(id);
                        $('.addVehicle').modal('show');
                    }
                });
            });

             $(document).on('submit', '#createVehicleDriver', function(e){
                e.preventDefault();
                var button = $('#submit_vehicle');
                toggleAble(button, true, 'Submitting...');
                var data = $(this).serializeArray();
                var url = "{{ route('driver.assignVehicle') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createVehicleDriver');
                    $('.addVehicle').modal('toggle');
                    setTimeout(function () {
                        window.location.reload()
                    }, 2000);
                }).fail((res) => {
                    toggleAble(button, false);
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
                
            });
        </script>
    @endsection
</div>