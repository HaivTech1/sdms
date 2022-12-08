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
                                </diV>
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
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Title</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clubs as $key => $club)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $club->id() }}"
                                                        type="checkbox" id="{{ $club->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $club->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $key + 1}}
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$club' field='title'
                                                    :key='$club->id()' />
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$club' field='status' :key='$club->id()'/>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $clubs->links('pagination::custom-pagination') }}
                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent="createClub">
                                <div class="hstack gap-3">
                                    <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your club here..."
                                        aria-label="Add your club here...">
                                    <x-form.error for="title" />
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                    <div class="vr"></div>
                                    <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>