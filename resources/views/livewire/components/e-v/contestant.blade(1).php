<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                                <button wire:click.prevent="markAllAsAvailable" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-check-double"></i>
                                                    Available
                                                </button>
                                                <button wire:click.prevent="markAllAsUnavailable" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-x-circle"></i>
                                                    Unavailable
                                                </button>
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                                <button wire:click.prevent="markAllAsVerified" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-check-double"></i>
                                                    Verified
                                                </button>
                                                <button wire:click.prevent="markAllAsUnverified" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-x-circle"></i>
                                                    Unverified
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </diV>
                            </div>
                        </div>

                        <div class=" col-sm-4">
                            <div class="text-sm-end">
                                <a href="{{ route('contestant.create') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Add contestant</a>
                            </div>
                        </div><!-- end col-->
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
                                    <th class="align-middle">Contestant ID</th>
                                    <th class="align-middle">Contestant Name</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contestants as $contestant)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $contestant->id() }}"
                                                type="checkbox" id="{{ $contestant->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="{{ $contestant->id() }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $contestant->id() }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $contestant->name() }}</a>
                                    </td>
                                    <td>
                                        <a class="dropdown-item" href="{{ route('contestant.show', $contestant) }}"><i
                                                class="fa fa-eye"></i></a>
                                        <a class="dropdown-item" href="{{ route('contestant.edit', $contestant) }}"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $contestants->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>