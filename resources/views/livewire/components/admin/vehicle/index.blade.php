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
                            <th class="align-middle"> Status </th>
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
                    <form id="vehicleForm" method="POST" action="{{ route('driver.add.vehicle') }}">
                        @csrf

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
