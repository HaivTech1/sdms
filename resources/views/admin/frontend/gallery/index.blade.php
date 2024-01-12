<x-app-layout>
    @section('title', application('name')." | ".$title)
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Frontend</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="row mb-2">
            <div class="col-sm-8">
                <button id="deleteButton" style="display: none;" class="btn btn-danger"><i class="bx bx-trash"></i>Delete</button>
            </div>
            <div class="col-sm-4">
                <div class="text-sm-end">
                    <button type="button"
                        data-bs-toggle="modal" data-bs-target=".createImage"
                        class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2"><i
                            class="mdi mdi-plus me-1"></i> 
                            Add Image
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Image</th>
                                <th class="align-middle">Title</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $key => $gallery)
                            <tr>
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input selectRow" value="{{ $gallery->id() }}"
                                            type="checkbox" id="{{ $gallery->id() }}"
                                        >
                                        <label class="form-check-label" for="{{ $gallery->id() }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <img 
                                    class="rounded-circle avatar-xs"
                                    data-id="{{ $gallery->id() }}"
                                    src="{{ asset($gallery->image()) }}"
                                    alt="{{ $gallery->title() }}">
                                </td>
                                <td>
                                    {{ $gallery->title() }}
                                </td>
                                <td>
                                    <livewire:components.toggle-button :model='$gallery' field='status' :key='$gallery->id()'/>
                                </td>
                                <td>
                                    <button data-id="{{ $gallery->id() }}" class="btn btn-sm btn-warning remove"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                     {{ $galleries->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>

        <div class="modal fade createImage" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create a new image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="imageForm"  method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <x-form.label for="title" value="{{ __('Title') }}" />
                                            <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                                :value="old('title')" id="title" autofocus />
                                            <x-form.error for="title" />
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="image" value="{{ __('Select File') }}" />
                                            <input type="file" id="path" name="image" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                <button type="submit" id="submit_image" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function () {
                $(document).on('submit', '#imageForm', function (e) {
                    e.preventDefault();
                    let formData = new FormData($('#imageForm')[0]);
                    toggleAble('#submit_image', true, 'Submitting...');
                    var url = $(this).attr('action');

                    $.ajax({
                        method: "POST",
                        url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble('#submit_image', false);
                        toastr.success(res.message, 'Success!');
                        $('.createImage').modal('toggle');

                        setTimeout(() =>{
                            window.location.reload();
                        }, 1500);
                    }).fail((err) => {
                        toggleAble('#submit_image', false);
                        toastr.error(err.responseJSON.message, 'Failed!');
                    });
                });

                $(document).on('click', '.remove', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);
                    var galleryId = $(this).data('id');
                    var row = $(this).closest('tr');

                    Swal.fire({
                            title: 'Confirm Deletion',
                            text: 'Are you sure you want to delete this item?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#502179',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            });

                            $.ajax({
                                url: "{{ route('admin.gallery.delete', ['gallery' => ':gallery_id']) }}".replace(':gallery_id', galleryId),
                                method: 'DELETE',
                                success: function(response) {
                                    toggleAble(button, false);
                                    Swal.fire('Deleted!', response.message, 'success');
                                    row.remove();
                                },
                                error: function(response) {
                                    toggleAble(button, false);
                                    console.log(response.responseJSON.message);
                                    toastr.error(response.responseJSON.message, 'Failed');
                                }
                            });
                            
                        }else{
                            toggleAble(button, false);
                        }
                    });
                });

                function updateDeleteButtonVisibility() {
                    var anyCheckboxChecked = $(".selectRow:checked").length > 0;
                    $("#deleteButton").toggle(anyCheckboxChecked);
                }

                $("#checkAll").change(function () {
                    $(".selectRow").prop('checked', $(this).prop("checked"));
                    updateDeleteButtonVisibility();
                });

                $(".selectRow").change(function () {
                    if (!$(this).prop("checked")) {
                        $("#checkAll").prop('checked', false);
                    }
                    updateDeleteButtonVisibility();
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $("#deleteButton").click(function () {
                    var button = $(this);
                    toggleAble(button, true, 'Deleting');

                    var selectedIds = [];
                    $(".selectRow:checked").each(function () {
                        selectedIds.push($(this).val());
                    });

                    if (selectedIds.length > 0) {
                        $.ajax({
                            url: '{{ route("admin.gallery.deleteMany") }}',
                            type: 'POST',
                            data: { ids: selectedIds },
                            success: function (response) {
                                toggleAble(button, false);
                                toastr.success(response.message, 'Success');

                                setTimeout(function () {
                                    window.location.reload();
                                }, 1500)
                            },
                            error: function (error) {
                                toggleAble(button, false);
                                toastr.error(response.responseJSON.message, 'Failed');
                            }
                        });
                    } else {
                        toggleAble(button, false);
                        alert('No items selected');
                    }
                });

                $("#deleteButton").hide();
            });
        </script>
    @endsection
</x-app-layout>