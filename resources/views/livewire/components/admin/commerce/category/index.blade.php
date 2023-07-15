<div>
    
        <div class="row mt-2 mb-2">
            <div class="col-sm-8">
                <form wire:submit.prevent="createCategory">
                    <div class="hstack gap-3">
                        <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your category here..."
                            aria-label="Add your category here...">
                        <x-form.error for="title" />
                        <button type="submit" class="btn btn-secondary">Add</button>
                        <div class="vr"></div>
                        <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                    </div>
                </form>
            </div>
            
            @if ($selectedRows)
                <div class="col-sm-2">
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
        <div class='col-sm-12'>
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
                            <th class="align-middle"> Title </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                        <tr>
                            <td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" value="{{ $category->id() }}"
                                        type="checkbox" id="{{ $category->id() }}"
                                        wire:model="selectedRows">
                                    <label class="form-check-label" for="{{ $category->id() }}"></label>
                                </div>
                            </td>
                            <td>
                                {{ $category->title() }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-danger btn-sm" wire:click="delete({{ $category->id() }})"><i class="bx bx-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
