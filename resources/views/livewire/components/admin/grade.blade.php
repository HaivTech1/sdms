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
                        <div class='col-sm-12'>
                            <form wire:submit.prevent="createGrade">
                                <div class="hstack gap-3">
                                    <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your class here..."
                                        aria-label="Add your class here...">
                                    <x-form.error for="title" />
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                    <div class="vr"></div>
                                    <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                                </div>
                            </form>

                            {{-- grade details modal removed; use the standalone assign-subject modal via AJAX --}}
                        </div>

                        <div class='col-sm-12 mt-4'>
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
                                            <th class="align-middle"> Status</th>
                                            <th class="align-middle">No. of students</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($grades as $key => $grade)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $grade->id() }}"
                                                        type="checkbox" id="{{ $grade->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $grade->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold">{{ $key+1 }}</a>
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$grade' field='title' :key='$grade->id()'/>
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$grade' field='status' :key='$grade->id()'/>
                                            </td>
                                            <td>
                                                {{ $grade->students->count() }}
                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="right" title="Click to show class details" wire:click="GradeDetails({{ $grade->id() }})" class="dropdown-item">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-primary waves-effect waves-light assignSubjects"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    data-id="{{ $grade->id() }}"
                                                    title="Click to show assign subjects">
                                                    <i class="fa fa-list"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $grades->links('pagination::custom-pagination')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('script')
    <script>
        // Delegated click handler so it survives Livewire re-renders and doesn't require jQuery
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.assignSubjects');
            if (!btn) return;
            e.preventDefault();
            const gradeId = btn.dataset.id;
            // quick debug - replace with your modal/open logic or Livewire emit
            alert('Assign subjects for grade: ' + gradeId);
            if (window.Livewire) {
                Livewire.emit('openAssignSubjectsModal', gradeId);
            }
        });
    </script>
@endsection

@include('admin.assign-subject-modal')

@push('scripts')
    <script>
        // Provide the URL template for the AJAX partial loader; expects replaceable __ID__
        window.assignSubjectsUrlTemplate = '/admin/grades/__ID__/subjects/assign';
    </script>
@endpush

