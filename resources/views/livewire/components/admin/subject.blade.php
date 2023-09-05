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
                                    <div class="d-flex gap-2">
                                        <div>
                                            <form action="{{ route('subject.download-pdf') }}" method="POST" target="_blank">
                                                @csrf
                                                <button data-bs-toggle="modal" data-bs-target=".generateSubjectList" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Generate Subject List</button>
                                            </form>
                                        </div>
                                        <div>
                                            <button data-bs-toggle="modal" data-bs-target=".generateResultSheet" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Generate Result Subject Format </button>
                                        </div>
                                    </div>

                                    <div class="row">

                                        @if ($selectedRows)
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-danger w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="activateAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Activate All
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
                                        @foreach ($subjects as $key => $subject)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $subject->id() }}"
                                                        type="checkbox" id="{{ $subject->id() }}"
                                                        wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $subject->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);" class="text-body fw-bold">{{ $key + 1
                                                    }}</a>
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$subject' field='title'
                                                    :key='$subject->id()' />
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$subject' field='status'
                                                    :key='$subject->id()' />
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $subjects->links('pagination::custom-pagination') }}
                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent='createSubject'>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <x-form.label for='title' value="{{ __('Title') }}" />
                                        <x-form.input id='title' class="block w-full mt-1" :value="old('title')"
                                            wire:model.defer='title' />
                                        <x-form.error for="title" />
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

    <div class="modal fade generateResultSheet" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate excel result format</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('subject.download-excel') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <select class="form-control" name="grade_id" id="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12" id="subject-box">

                                <div>
                            </div>

                            <div class="row">
                                <div class="d-flex justify-content-center flex-wrap mt-2">
                                    <button id="excel_upload_button" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Generate Sheet
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('#grade_id').on('change', function() {
                var id = $(this).val();
                
                $.ajax({
                    method: 'GET',
                    url: '{{ route('grade.subjects', ["grade_id" => ":grade_id"]) }}'.replace(':grade_id', id),
                }).done((response) => {
                    var subjects = response.subjects;
                    console.log(subjects);
                    var html = '';

                    $.each(subjects, function(index, subject) {
                        const checkboxContainer = document.createElement('div');
                        checkboxContainer.className = 'checkbox-checkbox d-flex align-items-center';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = "subject-selected[]";
                        checkbox.value = subject.id;
                        checkbox.id = `checkbox-${subject.id}`;
                        checkbox.style = 'width: 20px; height: 20px; margin-right: 5px;'

                        const label = document.createElement("label");
                        label.htmlFor = subject.id;
                        label.innerText = subject.title;

                        checkboxContainer.appendChild(checkbox);
                        checkboxContainer.appendChild(label);

                        const subjectBox = document.getElementById("subject-box");
                        subjectBox.appendChild(checkboxContainer);
                    });

                }).fail((error) => {
                    console.log(error.responseJSON.message);
                });
            });
        </script>
    @endsection
</div>