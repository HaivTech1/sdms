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
                                        
                                        @if($selectedRows)
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
                                        @foreach($periods as $key => $period)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $period->id() }}"
                                                        type="checkbox" id="{{ $period->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $period->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold">{{ $key+1 }}</a>
                                            </td>
                                            <td>
                                                {{-- @livewire('componets.admin.edit-title', compact('period'), key($period->id)) --}}
                                                <livewire:components.admin.edit-title :model='$period' :key='$period->id()'/>
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$period' field='status' :key='$period->id()'/>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $periods->links('pagination::custom-pagination')}}
                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent="createPeriod">
                                <div class="hstack gap-3">
                                    <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your session here..."
                                        aria-label="Add your session here...">
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