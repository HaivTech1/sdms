<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class='row'>
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="gender">
                                    <option value=''>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Others</option>
                                </select>

                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="sortBy">
                                    <option value=''>Sort By</option>
                                    <option value="asc">ASC</option>
                                    <option value="desc">DESC</option>
                                </select>

                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="orderBy">
                                    <option value=''>Order By</option>
                                    <option value="first_name">First Name</option>
                                    <option value="last_name">Last Name</option>
                                </select>
                            </div>

                            @if ($selectedRows)
                                <div class="col-6">
                                    <div class="btn-group btn-group-example mb-3" role="group">
                                        <button wire:click.prevent="deleteAll" type="button"
                                            class="btn btn-outline-primary w-sm">
                                            <i class="bx bx-block"></i>
                                            Delete All
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>