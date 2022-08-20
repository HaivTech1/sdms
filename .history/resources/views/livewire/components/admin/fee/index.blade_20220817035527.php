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
                                                <a href="javascript: void(0);" class="text-body fw-bold">{{ $key + 1
                                                    }}</a>
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$fee' field='title'
                                                    :key='$fee->id()' />
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
                            <form action="{{ route('fee.store') }}" method='post'>
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <x-form.label for='title' value="{{ __('Title') }}" />
                                        <x-form.input id='title' class="block w-full mt-1" :value="old('title')"
                                            name='title' />
                                        <x-form.error for="title" />
                                    </div>

                                    <div class="col-sm-12 mt-2">
                                        <x-form.label for='fees' value="{{ __('Classes') }}" />
                                        <select name="fees[]" class="form-control select2-multiple" multiple>
                                            <option>Select classes</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="fees" />
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-secondary">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>