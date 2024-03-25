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
                <div class="search-box me-2 mb-2 d-inline-block">
                    <div class="position-relative">
                        <input type="text" class="form-control input_type" placeholder="Search..." id="input-search">
                        <i class="bx bx-search-alt search-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="text-sm-end">
                    <button type="button"
                        data-bs-toggle="modal" data-bs-target=".createAbout"
                        class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2"><i
                            class="mdi mdi-plus me-1"></i> 
                            Add About
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row search-row">
                        @foreach ($settings as $setting)
                            @switch($setting->input_type)
                                @case('text')
                                    <div class="col-sm-6 mb-3 search-items">
                                        <x-form.label for="{{ $setting->column_name }}" value="{{ $setting->name }}" />
                                        <x-form.input id="name" class="block w-full mt-1 {{ $setting->column_name }} edit_about_setting" name="{{ $setting->column_name }}"
                                            :value="$setting->value" id="{{ $setting->column_name }}" data-key="{{ $setting->column_name }}" />
                                    </div>
                                    @break
                                @case('textarea')
                                    <div class="col-sm-6 mb-3 search-items">
                                        <x-form.label for="{{ $setting->column_name }}" value="{{ $setting->name }}" />
                                        <textarea rows="5" id="value summernote" class="form-control {{ $setting->column_name }} edit_about_setting"
                                             id="{{ $setting->column_name }}" data-key="{{ $setting->column_name }}"> {{ $setting->value }}
                                        </textarea>
                                    </div>
                                @break
                                @case('file')
                                    <div class="col-sm-6 mb-3 search-items">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <x-form.label for="{{ $setting->column_name }}" value="{{ $setting->name }}" />
                                                <x-form.input id="{{ $setting->column_name }}" class="block w-full mt-1 {{ $setting->column_name }} edit_about_setting" type="file"
                                                  id="{{ $setting->column_name }}" data-key="{{ $setting->column_name }}" />
                                            </div>
                                            <div class="col-sm-4">
                                                <img 
                                                    class="rounded-circle avatar-lg"
                                                    src="{{ asset('storage/'.$setting->value) }}"
                                                    alt="{{ $setting->name }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                @break
                                @default
                            @endswitch 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade createAbout" id="createAbout" tabindex="-1" aria-labelledby="createAboutLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAboutLabel">Create About</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="AboutForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="name" value="Name" />
                                    <x-form.input id="name" class="block w-full mt-1 name" type="text" name="name"
                                        :value="old('name')" id="name" />
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="description" value="Description" />
                                    <x-form.input id="description" class="block w-full mt-1 description" type="text" name="description"
                                        :value="old('description')" id="description" />
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="column_name" value="Column Name" />
                                    <x-form.input id="column_name" class="block w-full mt-1 column_name" type="text" name="column_name"
                                        :value="old('column_name')" id="column_name" />
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="model" value="Model" />
                                    <x-form.input id="model" class="block w-full mt-1 model" type="text" name="model"
                                        :value="old('model')" id="model" />
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="input_type" value="Input Type" />
                                    <select class="form-control input_type" name="input_type" :value="old('input_type')">
                                        <option>Select type</option>
                                        @foreach (input_types() as $option)
                                            <option value="{{ $option['name'] }}">{{ $option['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3 type_text" style="display: none">
                                    <x-form.label for="value" value="Value" />
                                    <x-form.input id="value" class="block w-full mt-1 value" type="text"
                                        :value="old('value')" id="value" />
                                </div>

                                 <div class="col-sm-6 mb-3 type_file" style="display: none">
                                    <x-form.label for="value" value="Value" />
                                    <x-form.input id="value" class="block w-full mt-1 value" type="file"
                                        :value="old('value')" id="value" />
                                </div>

                                 <div class="col-sm-6 mb-3 type_textarea" style="display: none">
                                    <x-form.label for="value" value="Value" />
                                    <textarea id="value summernote" class="form-control value"
                                        :value="old('value')" name="value"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="create_btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    @section('scripts')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $('.input_type').on('change', function(e){
                var value =  $(this).val();
                var inputContainer = document.getElementById('inputContainer');

                var textInput = $('.type_text');
                var fileInput = $('.type_file');
                var textAreaInput = $('.type_textarea');

                textInput.hide();
                fileInput.hide();
                textAreaInput.hide();

                switch (value) {
                    case 'Text':
                        textInput.show().find('input').attr('name', 'value');
                        break;
                    case 'Textarea':
                        textAreaInput.show().find('textarea').attr('name', 'value');
                        break;
                    case 'File':
                        fileInput.show().find('input').attr('name', 'value');
                        break;
                }

            });

            $('#create_btn').on('click', function(e) {
                var button = $(this);
                toggleAble(button, true, "Creating...");

                let formData = new FormData($('#AboutForm')[0]);
                var url = "{{ route('admin.about.store') }}";

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    $('.createAbout').modal('hide');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }).fail((err) => {
                    toggleAble(button, false);
                    console.log(err);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('.edit_about_setting').on('blur', function() {
                var updatedValue;

                if ($(this).is(':file')) {
                    updatedValue = $(this)[0].files[0];
                } else {
                    updatedValue = $(this).val();
                }

                if (!updatedValue) {
                    return;
                }

                var dataKey = $(this).data('key');
                let formData = new FormData();
                formData.append('key', dataKey);
                formData.append('value', updatedValue);

                $.ajax({
                    url: "{{ route('admin.about.update') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message, "Success!");
                    },
                    error: function(error) {
                        console.error('Error updating value:', error);
                        toastr.error(error.responseJSON.message, "Failed!");
                    }
                });
            });


            $("#input-search").on("keyup", function () {
                var searchValue = $(this).val().toLowerCase();
                $(".search-row .search-items").hide();

                $(".search-row .search-items").filter(function () {
                    var labelValue = $(this).find('label').text().toLowerCase();
                    return labelValue.includes(searchValue);
                }).show();
            });

        </script>
    @endsection
</x-app-layout>