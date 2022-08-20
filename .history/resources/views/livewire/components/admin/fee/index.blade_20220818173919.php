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
                        <div class=" col-sm-4">
                            <div class="d-flex justify-content-between text-sm-end">
                                <label class="form-check-label" for="gridCheck">
                                    Make Payment
                                </label>
                                <div class="form-check form-switch form-switch-lg mb-3">
                                    <input class=" form-check-input" wire:model="createFee" type="checkbox"
                                        role="switch" @if ($createFee) checked @endif />

                                </div>
                                <label class="form-check-label" for="gridCheck">
                                    Create Fee
                                </label>
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
                                            <th class="align-middle"> Price</th>
                                            <th class="align-middle"> Session</th>
                                            <th class="align-middle"> Term</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fees as $key => $fee)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $fee->id() }}"
                                                        type="checkbox" id="{{ $fee->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $fee->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $key + 1}}
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$fee' field='title'
                                                    :key='$fee->id()' />
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$fee' field='price'
                                                    :key='$fee->id()' />
                                            </td>
                                            <td>
                                                {{ $fee->period->title() }}
                                            </td>
                                            <td>
                                                {{ $fee->term->title() }}
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$fee' field='status'
                                                    :key='$fee->id()' />
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $fees->links('pagination::custom-pagination') }}
                        </div>
                        <div class='col-sm-4'>
                            @if ($createFee)
                            <div wire:ignore>

                            </div>
                            @else
                            gsdgds
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>