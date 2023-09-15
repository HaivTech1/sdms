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
                        <div class='col-sm-12 mb-2'>
                            <form wire:submit.prevent="createRole">
                                <div class="hstack gap-3">
                                    <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your role here...">
                                    <x-form.error for="title" />
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                    <div class="vr"></div>
                                    <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                                </div>
                            </form>

                        </div>

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
                                            <th class="align-middle"> Title</th>
                                            <th class="align-middle"></th>
                                            <th class="align-middle">Permissions</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $key => $role)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $role->id() }}"
                                                        type="checkbox" id="{{ $role->id() }}" wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $role->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $key + 1}}
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$role' field='title' :key='$role->id()' />
                                            </td>
                                            <td>
                                                {{-- <ul>
                                                    @foreach( as $key => $item)
                                                       <li><span class="">{{ $item->title }}</span></li>
                                                    @endforeach
                                                </ul> --}}
                                                {{ $role->permissions->count() }}
                                            </td>
                                            <td>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading{{ $role->id() }}">
                                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $role->id() }}" aria-expanded="true" aria-controls="collapse{{ $role->id() }}">
                                                                Click to expand
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $role->id() }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $role->id() }}" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <ul class="list-group">
                                                                    @foreach ($role->permissions as $permission)
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                            {{ $permission->title() }}
                                                                            <button type="button" class="btn btn-sm btn-danger delete-permission"  data-role-id="{{ $role->id }}" data-permission-id="{{ $permission->id }}">
                                                                                <i class="bx bx-x"></i>
                                                                            </button>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                             <td>
                                                <div class="d-flex justify-content-between">
                                                    @can('role_delete')
                                                        <form action="{{ route('role.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                        </form>
                                                    @endcan

                                                    <div class="dropdown">
                                                        <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <button class="dropdown-item" type="button" id="assingPermission" value="{{ $role->id() }}">
                                                                <i class="fas fa-compress-arrows-alt"></i> Assign Permission
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $roles->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade addPermission bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="createPermissions">
                                @csrf

                                <x-form.input type="hidden" value="" name="role_id" id="role_id" />
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <select name="permissions[]" class="select2 form-control" multiple="multiple" style="height: 300px" id="permissions">
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->id() }}">
                                                    {{ $permission->title() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                    <button type="submit" id="submit_permission" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).on('click', '#assingPermission', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var button = $(this);
                toggleAble(button, true);

                $.ajax({
                    url: "/role/permissions/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        toggleAble(button, false);

                        $.each(response.data, function(index, permission) {
                            $('#permissions option[value="' + permission.id + '"]').prop('selected', true);
                        });

                        $('#role_id').val(id);
                        $('.addPermission').modal('show');
                    },
                    error: function(xhr, status, error) {
                        toggleAble(button, false);
                        toastr.error(xhr.responseText, 'Failed!');
                    }
                });
            });

            $(document).on('submit', '#createPermissions', function(e){
                e.preventDefault();
                toggleAble('#submit_permission', true, 'Submitting...');
                var data = $('#createPermissions').serializeArray();
                var url = "{{ route('role.assignPermission') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#submit_permission', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createPermissions');
                    $('.addPermission').modal('toggle');
                    setTimeout(function () {
                        window.location.reload()
                    }, 2000);
                }).fail((res) => {
                    toggleAble('#submit_permission', false);
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
                
            });

            $(document).on('click', '.delete-permission', function() {
                var roleId = $(this).data('role-id');
                var permissionId = $(this).data('permission-id');

                toggleAble($(this), true);

                $.ajax({
                    url: '/role/' + roleId + '/permission/' + permissionId,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toggleAble($(this), false);
                        toastr.success(response.message, 'Success!');
                        setTimeout(function () {window.location.reload()}, 1500);
                    },
                    error: function(xhr, status, error) {
                        toggleAble($(this), false);
                        toastr.error(xhr.responseText, 'Failed!');
                    }
                });
            });
        </script>
    @endsection
</div>