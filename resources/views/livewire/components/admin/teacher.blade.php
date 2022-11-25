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
                                        <div class="col-6">
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
                                    <th class="align-middle"></th>
                                    <th class="align-middle">Teacher's Name</th>
                                    <th class="align-middle">Teacher's email</th>
                                    <th class="align-middle">Teacher's Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $teacher->id() }}" type="checkbox"
                                                id="{{ $teacher->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="{{ $teacher->id() }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <img class="rounded-circle avatar-xs"
                                                src="{{ asset('storage/'.$teacher->image()) }}"
                                                alt="{{ $teacher->name() }}">
                                        </div>
                                    </td>
                                    <td>
                                        <livewire:components.edit-title :model='$teacher' field='name'
                                            :key='$teacher->id()' />
                                            @if ($teacher->gradeClassTeacher()->count() < 1)
                                                <span class="badge badge-soft-danger">Assign Class</span>
                                            @endif
                                    </td>
                                    <td>
                                        <livewire:components.edit-title :model='$teacher' field='email'
                                            :key='$teacher->id()' />
                                    </td>
        
                                    <td>
                                        <livewire:components.toggle-button :model='$teacher' field='isAvailable'
                                            :key='$teacher->id()' />
                                    </td>

                                    <td>
                                        <div class="col-sm-4">
                                            <button type="button" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasWithBothOptions{{ $teacher->id() }}"
                                                aria-controls="offcanvasWithBothOptions">
                                                <i class="fas fa-compress-arrows-alt"></i>
                                            </button>

                                            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1"
                                                id="offcanvasWithBothOptions{{ $teacher->id() }}"
                                                aria-labelledby="offcanvasWithBothOptionsLabel">
                                                <div class="offcanvas-header">
                                                    <button type="button" class="btn-close text-reset"
                                                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                </div>
                                                <div class="offcanvas-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4>Assign Class for {{  $teacher->title() }} {{  $teacher->name() }}</h4>
                                                            <form id="assignClasses">
                                                                @csrf

                                                                <x-form.input type="hidden" value="{{ $teacher->id() }}"
                                                                    name="user_id" />

                                                                <div class="col-sm-12 mt-2">
                                                                    <select name="grade_id[]"
                                                                        class="form-control select2-multiple" multiple>
                                                                        @foreach ($grades as $id => $grade)
                                                                        <option value="{{ $id }}">
                                                                            {{ $grade }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <x-form.error for="grade_id" />
                                                                </div>

                                                                <div class="col-sm-12 mt-2">
                                                                    <div class="float-right">
                                                                        <button id="submit_button1" type="submit"
                                                                            class="btn btn-primary">Add</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>

                                                        <div class="col-sm-12 mt-4">
                                                            <h1>List of classes assigned</h1>

                                                            <ul>
                                                                @foreach ($teacher->gradeClassTeacher as $grade)
                                                                    <li><span class="badge badge-soft-info">{{ $grade->title() }}</span></li>
                                                                @endforeach
                                                            </ul>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $teachers->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')

    <script>
        $('#assignClasses').submit((e) => {
            toggleAble('#submit', true, 'Submitting...');
            e.preventDefault()
            var data = $('#assignClasses').serializeArray();
            var url = "{{ route('teacher.assignClass') }}";

            $.ajax({
                type: "POST",
                url,
                data
            }).done((res) => {
                if (res.status === 'success') {
                    toggleAble('#submit_button1', false);
                    toastr.success(res.message, 'Success!');
                } else {
                    toggleAble('#submit_button1', false);
                    toastr.error(res.message, 'Failed!');
                }
                resetForm('#assignClasses');
                setInterval(function () {
                    location.reload()
                }, 1000);

            }).fail((res) => {
                console.log(res.responseJSON.message);
                toastr.error(res.responseJSON.message, 'Failed!');
                toggleAble('#submit_button1', false);
            });
        })
    </script>

    @endsection
</div>