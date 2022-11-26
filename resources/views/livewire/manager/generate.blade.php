<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model.debounce.350ms="grade">
                                <option value=''>Class</option>
                                @foreach ($grades as $grade)
                                <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-8">
                             @if ($selectedRows)
                                <div class="row justify-content-center align-items-center g-2 mt-2">
                                    <div class="col-sm-4">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="deleteAll" type="button"
                                                class="btn btn-outline-danger w-sm">
                                                <i class="bx bx-trash"></i>
                                                Delete All
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="generatePin" type="button"
                                                class="btn btn-outline-primary w-sm">
                                                <i class="bx bx-caret-right"></i>
                                                Generate Pin
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="regeneratePin" type="button"
                                                class="btn btn-outline-success w-sm">
                                                <i class="bx bx-caret-right"></i>
                                                Regenerate Pin
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center g-2 mt-2">
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
                                        <th class="align-middle"> Name </th>
                                        <th class="align-middle">Reg. no </th>
                                        <th class="align-middle">Code </th>
                                        <th class="align-middle">Used</th>
                                        <th class="align-middle">Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $key => $student)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" value="{{ $student->id() }}"
                                                    type="checkbox" id="{{ $student->id() }}"
                                                    wire:model="selectedRows">
                                                <label class="form-check-label" for="{{ $student->id() }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript: void(0);" class="text-body fw-bold">{{ $key + 1
                                                }}</a>
                                        </td>
                                        <td>
                                            {{ $student->firstName() }} {{ $student->lastName() }}
                                        </td>
                                        <td>
                                            {{ $student->user->code() }}
                                        </td>
                                        <td>
                                            @if ($student->user->pin())
                                                {{ $student->user->pin() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($student->user->scratchCard?->usedTimes())
                                                {{ $student->user->scratchCard?->usedTimes() }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($student->user->pin() == null)
                                                 <button class="btn btn-primary waves-effect waves-light" type="button" wire:click="generateSinglePin('{{ $student->id() }}')">Generate</button>
                                            @else
                                                 <button class="btn btn-success waves-effect waves-light" type="button" wire:click="regenerateSinglePin('{{ $student->id() }}')">Regenerate</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $pins->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>