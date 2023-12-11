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
                                            <th class="align-middle"> Key</th>
                                            <th class="align-middle">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($settings as $key => $setting)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $setting->id() }}"
                                                        type="checkbox" id="{{ $setting->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $setting->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold">{{ $key+1 }}</a>
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$setting' field='key' :key='$setting->id()'/>
                                            </td>
                                            <td>
                                                @if($setting->value === '1' || $setting->value === '0')
                                                    <livewire:components.toggle-button :model='$setting' field='value'
                                                    :key='$setting->id()' />
                                                @else
                                                    <livewire:components.edit-title :model='$setting' field='value' :key='$setting->id()'/>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $settings->links('pagination::custom-pagination')}}
                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent="createSetting">
                                <div class="gap-3">
                                    <div class="mb-2">
                                        <input class="form-control me-auto" wire:model.defer="key" placeholder="Add your key here..." />
                                    </div>

                                    <div class="mb-2">
                                        <input class="form-control me-auto" wire:model.defer="value" placeholder="Add your value here..." />
                                    </div>

                                    <button type="submit" class="btn btn-secondary">Add</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>