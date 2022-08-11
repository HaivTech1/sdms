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
                                    <option value=''>Select Session</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Others</option>
                                </select>

                            </div>

                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model="sortBy">
                                    <option value=''>Select State</option>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>