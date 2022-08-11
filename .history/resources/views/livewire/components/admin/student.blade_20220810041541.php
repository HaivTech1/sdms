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
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> Class </th>
                                            <th class="align-middle"> Date of Birth </th>
                                            <th class="align-middle"> Gender </th>
                                            <th class="align-middle">Action</th>
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
                                                        <label class="form-check-label"
                                                            for="{{ $student->id() }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript: void(0);"
                                                        class="text-body fw-bold">{{ $key + 1 }}</a>
                                                </td>
                                                <td>
                                                    <a href="javascript: void(0);"
                                                        class="text-body fw-bold">{{ $student->title() }}</a>
                                                </td>
                                                <td>
                                                    <livewire:components.toggle-button :model='$student'
                                                        field='isAvailable' :key='$student->id()' />
                                                </td>
                                                <td>
                                                    <livewire:components.toggle-button :model='$student'
                                                        field='isVerified' :key='$student->id()' />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $students->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
