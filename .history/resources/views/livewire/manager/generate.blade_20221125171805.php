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
                                        <div class="col-sm-12">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                                <button wire:click.prevent="disableAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-check-double"></i>
                                                    Disable All
                                                </button>
                                                <button wire:click.prevent="undisableAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-x-circle"></i>
                                                    Undisable All
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </diV>
                            </div>
                        </div>
                        <div class=" col-sm-4">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Generate Codes
                            </button>
                        </div>
                    </div>

                    <div class="collapse hide mb-2" id="collapseExample">
                        <div class="card border shadow-none card-body text-muted mb-0">
                                <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="form-control select2" wire:model.debounce.350ms="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                          
                            <div class="col-lg-1">
                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                    <th class="align-middle">User Name</th>
                                    <th class="align-middle">Pincode</th>
                                    <th class="align-middle">Count</th>
                                    <th class="align-middle">pin Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pins as $pin)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $pin->id() }}" type="checkbox"
                                                id="{{ $pin->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="{{ $pin->id() }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $pin->user->name() }}
                                    </td>
                                    <td>
                                        {{ $pin->user->pin() }}
                                    </td>
                                    <td>
                                        {{ $pin->count() }}
                                    </td>
                                    <td>
                                        <livewire:components.toggle-button :model='$pin' field='status'
                                            :key='$pin->id()' />
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $pins->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>