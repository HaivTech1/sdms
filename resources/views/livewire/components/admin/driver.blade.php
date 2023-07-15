<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex gap-2">
                        <div>
                            <button data-bs-toggle="modal" data-bs-target=".vehicleModal" class="btn btn-sm btn-primary"><i class="bx bx-bus"></i> Vehicles Management</button>
                        </div>
                    </div>

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
                                                    <span>{{ $key+1 }}. </span>
                                                    <span class="badge soft-badge-primary">{{ $vehicle->name }}</span>
                                                    <span class="badge soft-badge-primary">{{ $vehicle->plate_no }}</span>
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
                                                <button class="dropdown-item" type="button" value="{{ $driver->id() }}" data-class="" id="assignVehicle">
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
    </div>

    <div class="modal fade vehicleModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vehicle management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <livewire:components.admin.vehicle.index>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>