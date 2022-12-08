<x-app-layout>
    @section('title', application('name')." | Class Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Frontend</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Design</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Banner section
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <form id="bannerForm" enctype="multipart/form-data" method="POST">
                            
                            <div class="row">
                                <div class="col-sm-3 mb-3">
                                    <x-form.label for="title" value="{{ __('Title') }}" />
                                    <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                        :value="old('title')" id="title" autofocus />
                                    <x-form.error for="title" />
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <x-form.label for="sub_title" value="{{ __('Sub title') }}" />
                                    <x-form.input id="sub_title" class="block w-full mt-1" type="text" name="sub_title"
                                        :value="old('sub_title')" id="sub_title" autofocus />
                                    <x-form.error for="sub_title" />
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <x-form.label for="description" value="{{ __('Description') }}" />
                                    <x-form.input id="description" class="block w-full mt-1" type="text"
                                        name="description" :value="old('description')" id="description"
                                        autofocus />
                                    <x-form.error for="description" />
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <x-form.label for="button_text" value="{{ __('Button text') }}" />
                                    <x-form.input id="button_text" class="block w-full mt-1" type="text"
                                        name="button_text" :value="old('button_text')" id="button_text"
                                        autofocus />
                                    <x-form.error for="button_text" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="feature_one_title" value="{{ __('Feature one Title') }}" />
                                    <x-form.input id="feature_one_title" class="block w-full mt-1" type="text"
                                        name="feature_one_title" :value="old('feature_one_title')" id="feature_one_title"
                                        autofocus />
                                    <x-form.error for="feature_one_title" />
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="feature_one" value="{{ __('Feature one') }}" />
                                    <x-form.input id="feature_one" class="block w-full mt-1" type="text"
                                        name="feature_one" :value="old('feature_one')" id="feature_one"
                                        autofocus />
                                    <x-form.error for="feature_one" />
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="feature_two_title" value="{{ __('Feature two title') }}" />
                                    <x-form.input id="feature_two_title" class="block w-full mt-1" type="text"
                                        name="feature_two_title" :value="old('feature_two_title')" id="feature_two_title"
                                        autofocus />
                                    <x-form.error for="feature_two_title" />
                                </div>
                                 <div class="col-sm-4 mb-3">
                                    <x-form.label for="feature_two" value="{{ __('Feature two') }}" />
                                    <x-form.input id="feature_two" class="block w-full mt-1" type="text"
                                        name="feature_two" :value="old('feature_two')" id="feature_two"
                                        autofocus />
                                    <x-form.error for="feature_two" />
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="feature_three_title" value="{{ __('Feature three title') }}" />
                                    <x-form.input id="feature_three_title" class="block w-full mt-1" type="text"
                                        name="feature_three_title" :value="old('feature_three_title')" id="feature_three_title"
                                        autofocus />
                                    <x-form.error for="feature_three_title" />
                                </div>
                                 <div class="col-sm-4 mb-3">
                                    <x-form.label for="feature_three" value="{{ __('Feature three') }}" />
                                    <x-form.input id="feature_three" class="block w-full mt-1" type="text"
                                        name="feature_three" :value="old('feature_three')" id="feature_three"
                                        autofocus />
                                    <x-form.error for="feature_three" />
                                </div>  
                                   
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="wide_banner" value="{{ __('Wide Banner') }}" />
                                    <x-form.input id="wide_banner" class="block w-full mt-1" type="file"
                                        name="wide_banner" :value="old('wide_banner')" id="wide_banner"
                                        autofocus />
                                    <x-form.error for="wide_banner" />
                                </div>
                                <div class="col-sm-6">
                                    <div class="image" id="img-show-container"
                                        style="display: none; width: 100px; height: 100px">
                                        <canvas id="img-show" class="img-fluid d-block rounded-circle"></canvas>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <img id="img_display" style="width: 100px; height: 100px" class="img-fluid d-block rounded-circle" />
                                </div>
                            </div>

                            <div class="float-right">
                                <button class="btn btn-success upload-image"
                                    type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        About section
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form id="aboutForm" enctype="multipart/form-data" method="POST">
                            
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="title" value="{{ __('Title') }}" />
                                    <x-form.input id="about_title" class="block w-full mt-1" type="text" name="title"
                                        :value="old('title')" id="title" autofocus />
                                    <x-form.error for="title" />
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="description_one" value="{{ __('Description two') }}" />
                                    <x-form.input id="description_one" class="block w-full mt-1" type="text" name="description_one"
                                        :value="old('description_one')" id="description_one" autofocus />
                                    <x-form.error for="description_one" />
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="description_two" value="{{ __('Description Two') }}" />
                                    <x-form.input id="description_two" class="block w-full mt-1" type="text"
                                        name="description_two" :value="old('description_two')" id="description_two"
                                        autofocus />
                                    <x-form.error for="description_two" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <x-form.label for="big_image" value="{{ __('Big Image') }}" />
                                    <x-form.input id="big_image" class="block w-full mt-1" type="file"
                                        name="big_image" :value="old('big_image')" id="big_image"
                                        autofocus />
                                    <x-form.error for="big_image" />
                                </div>

                                 <div class="col-sm-4 mb-3">
                                    <x-form.label for="small_image_one" value="{{ __('Small Image 1') }}" />
                                    <x-form.input id="small_image_one" class="block w-full mt-1" type="file"
                                        name="small_image_one" :value="old('small_image_one')" id="small_image_one"
                                        autofocus />
                                    <x-form.error for="small_image_one" />
                                </div>

                                 <div class="col-sm-4 mb-3">
                                    <x-form.label for="small_image_two" value="{{ __('Small Image 2') }}" />
                                    <x-form.input id="small_image_two" class="block w-full mt-1" type="file"
                                        name="small_image_two" :value="old('small_image_two')" id="small_image_two"
                                        autofocus />
                                    <x-form.error for="small_image_two" />
                                </div>
                               
                            </div>

                            <div class="float-right">
                                <button class="btn btn-success upload-image"
                                    type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                       Choose
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                         <form id="chooseForm" enctype="multipart/form-data" method="POST">
                            
                            <div class="row">
                                <table class="table table-bordered" id="dynamicTable">  
                                    <tr>

                                        <th>Title</th>

                                        <th>Description</th>

                                        <th>Image</th>

                                        <th>Action</th>

                                    </tr>
                                    <tr>  

                                        <td><input type="text" name="addmore[0][topic]" placeholder="Enter your topic" class="form-control" /></td>  

                                        <td><input type="text" name="addmore[0][intention]" placeholder="Enter your intention" class="form-control" /></td>  

                                        <td><input type="file" name="addmore[0][logo]" placeholder="Enter your logo" class="form-control" /></td>  

                                        <td><button type="button" name="add" id="add" class="btn btn-success"><i class="bx bx-plus"></i></button></td>  

                                    </tr>  

                                </table> 
                            </div>

                            <div class="float-right">
                                <button class="btn btn-success upload-form"
                                    type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                $.ajax({
                    method: 'GET',
                    url: 'design/show/banner',
                    success: function(response) {
                        $('#title').val(response.banner.title);
                        $('#sub_title').val(response.banner.sub_title);
                        $('#description').val(response.banner.description);
                        $('#button_text').val(response.banner.button_text);
                        $('#feature_one_title').val(response.banner.feature_one_title);
                        $('#feature_two_title').val(response.banner.feature_two_title);
                        $('#feature_three_title').val(response.banner.feature_three_title);
                        $('#feature_one').val(response.banner.feature_one);
                        $('#feature_two').val(response.banner.feature_two);
                        $('#feature_three').val(response.banner.feature_three);
                    }
                });

                $.ajax({
                    method: 'GET',
                    url: 'design/show/about',
                    success: function(response) {
                        $('#about_title').val(response.about.title);
                        $('#description_one').val(response.about.description_one);
                        $('#description_two').val(response.about.description_two);
                    }
                });

                $('#bannerForm').on('submit' ,function(e){
                    e.preventDefault();
                    let formData = new FormData($('#bannerForm')[0]);
                    toggleAble('.upload-image', true, 'Submitting...');

                    $.ajax({
                        url: "{{ route('design.banner') }}",
                        method: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).then((response) => {
                        Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success",
                                showCancelButton: !0,
                                confirmButtonColor: "#556ee6",
                                cancelButtonColor: "#f46a6a",
                            });
                            toggleAble('.upload-image', false);
                            resetForm('#bannerForm');
                            window.location.reload();
                    }).catch((error) => {
                        Swal.fire({
                            title: "Oops!",
                            text: "Something went wrong!!!",
                            icon: "error",
                            showCancelButton:!0,
                            confirmButtonColor: "#f46a6a",
                        });
                        toggleAble('.upload-image', false);
                    });
                });

                $('#aboutForm').on('submit' ,function(e){
                    e.preventDefault();
                    let formData = new FormData($('#aboutForm')[0]);
                    toggleAble('.upload-image', true, 'Submitting...');

                    $.ajax({
                        url: "{{ route('design.about') }}",
                        method: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).then((response) => {
                        Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success",
                                showCancelButton: !0,
                                confirmButtonColor: "#556ee6",
                                cancelButtonColor: "#f46a6a",
                            });
                            toggleAble('.upload-image', false);
                            resetForm('#bannerForm');
                            window.location.reload();
                    }).catch((error) => {
                        Swal.fire({
                            title: "Oops!",
                            text: "Something went wrong!!!",
                            icon: "error",
                            showCancelButton:!0,
                            confirmButtonColor: "#f46a6a",
                        });
                        toggleAble('.upload-image', false);
                    });
                });

                $('#chooseForm').on('submit' ,function(e){
                    e.preventDefault();
                    let formData = new FormData($('#chooseForm')[0]);
                    toggleAble('.upload-form', true, 'Submitting...');

                    $.ajax({
                        url: "{{ route('design.choose') }}",
                        method: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                    }).then((response) => {
                        Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success",
                                showCancelButton: !0,
                                confirmButtonColor: "#556ee6",
                                cancelButtonColor: "#f46a6a",
                            });
                            toggleAble('.upload-form', false);
                            resetForm('#chooseForm');
                            window.location.reload();
                    }).catch((error) => {
                        Swal.fire({
                            title: "Oops!",
                            text: "Something went wrong!!!",
                            icon: "error",
                            showCancelButton:!0,
                            confirmButtonColor: "#f46a6a",
                        });
                        toggleAble('.upload-form', false);
                    });
                });
               

                var options = { 
                    complete: function(response) 
                    {
                        if($.isEmptyObject(response.responseJSON.error)){
                            $("input[name='title']").val('');
                            $("input[name='sub_title']").val('');
                            $("input[name='description']").val('');
                            $("input[name='button_text']").val('');
                            swal.fire({
                                title: "Good job!",
                                text: "Banner section created successfully!",
                                icon: "success",
                                showCancelButton: !0,
                                confirmButtonColor: "#556ee6",
                                cancelButtonColor: "#f46a6a",
                            });
                        }else{
                            printErrorMsg(response.responseJSON.error);
                        }
                    }
                };


                function printErrorMsg (msg) {
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display','block');
                    $.each( msg, function( key, value ) {
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });
                }

                var banner = document.querySelector('input[name="wide_banner"]');
                banner.onchange = function () {
                    var file = banner.files[0];
                    drawOnCanvas(file);
                };

            

                function drawOnCanvas(file) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var dataURL = e.target.result,
                        c = document.querySelector('#img-show'), // see Example 4
                        ctx = c.getContext('2d'),
                        img = new Image();

                        $('#img-show-container').show()

                        img.onload = function() {
                            c.width = img.width;
                            c.height = img.height;
                            ctx.drawImage(img, 0, 0);
                        };
                        img.src = dataURL;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>

        <script type="text/javascript">
            var i = 0;
            $("#add").click(function(){
                ++i;
                $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][topic]" placeholder="Enter your topic" class="form-control" /></td><td><input type="text" name="addmore['+i+'][intention]" placeholder="Enter your intention" class="form-control" /></td><td><input type="file" name="addmore['+i+'][logo]" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
            });
        
            $(document).on('click', '.remove-tr', function(){  
                $(this).parents('tr').remove();
            });  

        </script>
    @endsection

</x-app-layout>