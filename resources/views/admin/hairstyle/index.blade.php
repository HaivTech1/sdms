<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hairstyles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Manage Hairstyles</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".hairstyleModal">Add Hairstyle</button>
                    </div>

                    <div id="hairstyles-wrap" data-list-url="{{ route('admin.hairstyle.list') }}">
                        @include('admin.hairstyle._hairstyles_list', ['hairstyles' => $hairstyles])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade hairstyleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new hairstyle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="hairstyleForm" action="{{ route('admin.hairstyle.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="title" value="{{ __('Title') }}" />
                                <x-form.input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title')" />
                                <x-form.error for="title" />
                            </div>
                            <div class="col-sm-12 mb-3">
                                <x-form.label for="description" value="{{ __('Note') }}" />
                                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                <x-form.error for="description" />
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="side_view_input" class="form-label">Side View:</label>
                                    <input type="file" id="side_view_input" class="form-control" name="side_view" accept="image/*" onchange="previewImage('side_view_input', 'side_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="side_view_preview" src="#" alt="Side view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="front_view_input" class="form-label">Front View:</label>
                                    <input type="file" id="front_view_input" class="form-control" name="front_view" accept="image/*" onchange="previewImage('front_view_input', 'front_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="front_view_preview" src="#" alt="Front view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="back_view_input" class="form-label">Back View:</label>
                                    <input type="file" id="back_view_input" class="form-control" name="back_view" accept="image/*" onchange="previewImage('back_view_input', 'back_view_preview')">
                                    <div style="display: flex; justify-content: center; margin-top: 5px">
                                        <img id="back_view_preview" src="#" alt="Back view preview" style="display:none; max-width: 100px; max-height: 100px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Activate</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center; margin-top: 5px">
                                <button id="createHair" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            function previewImage(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview.setAttribute('src', e.target.result);
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.setAttribute('src', '#');
                    preview.style.display = 'none';
                }
            }

            (function($){
                const $wrap = $('#hairstyles-wrap');
                const listUrl = $wrap.data('list-url');

                function loadList(url){
                    try { $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader())); } catch(e){}
                    $.get(url).done(function(html){ $wrap.html(html); }).fail(function(){ Swal.fire('Error','Failed to load hairstyles','error'); }).always(function(){ $wrap.find('.overlay-loader').remove(); });
                }

                // submit create via AJAX
                $('#hairstyleForm').on('submit', function(e){
                    e.preventDefault();
                    const fd = new FormData(this);
                    const $btn = $('#createHair');
                    toggleAble($btn, true, 'Creating...');
                    $.ajax({ url: $(this).attr('action'), data: fd, method: 'POST', processData: false, contentType: false })
                        .done(function(){ toggleAble($btn, false); $('.hairstyleModal').modal('hide'); Swal.fire('Added','Hairstyle added','success'); loadList(listUrl); })
                        .fail(function(xhr){ toggleAble($btn, false); Swal.fire('Error', xhr.responseJSON?.message || 'Failed to create', 'error'); });
                });

                // pagination links
                $wrap.on('click', '.pagination a', function(e){ e.preventDefault(); loadList($(this).attr('href')); });

                // delegated delete handler
                $wrap.on('click', '.delete-hair', function(e){
                    e.preventDefault();
                    const id = $(this).data('hair-id');
                    if(!id) return;
                    Swal.fire({
                        title: 'Delete hairstyle?',
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                    }).then(function(res){
                        if(!res.isConfirmed) return;
                        try { $wrap.append($('<div class="overlay-loader">').css({position: 'absolute', top:0, left:0, width:'100%', height:'100%', background:'rgba(255,255,255,0.6)', 'z-index': 9999}).append(divLoader())); } catch(e){}
                        $.ajax({
                            url: "{{ url('/admin/hairstyle') }}/" + id,
                            method: 'POST',
                            data: { _method: 'DELETE', _token: '{{ csrf_token() }}' }
                        }).done(function(){ Swal.fire('Deleted','Hairstyle removed','success'); loadList(listUrl); }).fail(function(xhr){ Swal.fire('Error', xhr.responseJSON?.message || 'Failed to delete', 'error'); }).always(function(){ $wrap.find('.overlay-loader').remove(); });
                    });
                });

            })(jQuery);
        </script>
    @endsection
</x-app-layout>
