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
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">email</th>
                                    <th class="align-middle">Id</th>
                                    <th class="align-middle">Status</th>
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
                                        {{ $teacher->code() }}
                                    </td>
                                    <td>
                                        <livewire:components.toggle-button :model='$teacher' field='isAvailable'
                                            :key='$teacher->id()' />
                                    </td>
                                    <td>
                                        <div class="col-sm-4">
                                            <button type="button" value="{{ $teacher->id() }}" id="assignClass">
                                                <i class="fas fa-compress-arrows-alt"></i>
                                            </button>
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

    @include('partials.add_class')
    @section('scripts')

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $(document).on('click', '#assignClass', function(e) {
            e.preventDefault();
            var id = $(this).val();

            $('#user_id').val(id);
            $('.addClass').modal('show');
        });

        $(document).on('submit', '#assignClasses', function (e) {
            e.preventDefault();
            toggleAble('#submit_button', true, 'Submitting...');
            var data = $('#assignClasses').serializeArray();
            var url = "{{ route('teacher.assignClass') }}";

            $.ajax({
                type: "POST",
                url,
                data
            }).done((res) => {
                if (res.status === 'success') {
                    toggleAble('#submit_button', false);
                    toastr.success(res.message, 'Success!');
                    $('.addClass').modal('show');
                } else {
                    toggleAble('#submit_button', false);
                    toastr.error(res.message, 'Failed!');
                }
                resetForm('#assignClasses');
            }).fail((res) => {
                console.log(res.responseJSON.message);
                toastr.error(res.responseJSON.message, 'Failed!');
                toggleAble('#submit_button', false);
            });
        })
    </script>

    @endsection
</div>