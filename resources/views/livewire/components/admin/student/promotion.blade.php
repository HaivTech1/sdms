<div>
    
     <x-loading />

    
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-6">
                    <x-search />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="py-4">
                        <p class="text-danger text-center">Please note that promotion must be done from the higher class to the lower class</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <x-form.label for="from" value="{{ __('Promote From') }}" />
                            <select class="form-control select2" wire:model.debounce.350ms="from">
                                <option value=''>Class</option>
                                @foreach ($grades as $grade)
                                <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                @endforeach
                            </select>
                            <x-form.error for="from" />
                        </div>

                        <div class="col-lg-6">
                            <x-form.label for="to" value="{{ __('Promote To') }}" />
                            <select class="form-control select2" wire:model.defer="to">
                                <option value=''>Class</option>
                                @foreach ($grades as $grade)
                                <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                @endforeach
                            </select>
                            <x-form.error for="to" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <x-form.error for="selectedRows" />
                            </div>

                            @if ($from)
                                <div class="py-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;" class="align-middle">
                                                        @if (count($students) > 0)
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" wire:model="selectPageRows">
                                                                <label class="form-check-label" for="checkAll"></label>
                                                            </div>
                                                        @endif
                                                    </th>
                                                    <th scope="col" class="text-center">Name of Student</th>
                                                    <th scope="col" class="text-center">
                                                        Class
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($students as $student)
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" value="{{ $student->id() }}"
                                                                type="checkbox" id="{{ $student->id() }}"
                                                                wire:model="selectedRows">
                                                            <label class="form-check-label" for="{{ $student->id() }}"></label>
                                                        </div>
                                                    </td>
                                                    <td class='text-left'>{{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}</td>
                                                    <td class='text-center'>{{ $student->grade->title() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- {{ $students->links('pagination::custom-pagination')}} --}}
                            @endif
                        </div>

                        @if ($from)
                            <div class="col-lg-12 d-flex justify-content-center gap-2 mt-2">
                                <button type="buttton" class="btn btn-success waves-effect waves-light" wire:click="promoteAll">
                                    Promote
                                </button>
                                <button type="buttton" class="btn btn-danger waves-effect waves-light" wire:click="repeatAll">
                                    Repeat
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
