<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create a New School Account</title>

    @include('partials.style')

</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-8">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome!</h5>
                                        <p>Setup School Details</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">

                            <div class="p-2">
                                <x-jet-validation-errors class="mb-4 text-danger" />
                                @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <form id="setup-form" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="formrow-firstname-input"
                                            name="name">
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="alias" value="{{ __('Alias') }}" />
                                            <x-form.input id="alias" type="text" class="block w-full mt-1"
                                                name="alias" autocomplete="alias" />
                                            <x-form.error for="alias" class="mt-2" />
                                        </div>
                                        <!-- Site Email -->
                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="email" value="{{ __('Email') }}" />
                                            <x-form.input id="email" type="email" class="block w-full mt-1"
                                                name="email" />
                                            <x-form.error for="email" class="mt-2" />
                                        </div>
                                        <!-- Site line 1 -->
                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="line1" value="{{ __('Mobile Number 1') }}" />
                                            <x-form.input id="line1" type="tel" class="block w-full mt-1"
                                                name="line1" autocomplete="line1" />
                                            <x-form.error for="line1" class="mt-2" />
                                        </div>
                                        <!-- Site line2 -->
                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="line2" value="{{ __('Mobile Line 2') }}" />
                                            <x-form.input id="line2" type="tel" class="block w-full mt-1"
                                                name="line2" autocomplete="line2" />
                                            <x-form.error for="line2" class="mt-2" />
                                        </div>
                                        <!-- Site slogan -->
                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="slogan" value="{{ __('Slogan') }}" />
                                            <x-form.input id="slogan" type="text" class="block w-full mt-1"
                                                name="slogan" autocomplete="slogan" />
                                            <x-form.error for="slogan" class="mt-2" />
                                        </div>

                                        <!-- Site motto -->
                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="motto" value="{{ __('Motto') }}" />
                                            <x-form.input id="motto" type="text" class="block w-full mt-1"
                                                name="motto" autocomplete="motto" />
                                            <x-form.error for="motto" class="mt-2" />
                                        </div>

                                        <!-- Site address -->
                                        <div class="col-md-6 mb-3">
                                            <x-form.label for="address" value="{{ __('Address') }}" />
                                            <x-form.input id="address" type="text" class="block w-full mt-1"
                                                name="address" autocomplete="address" />
                                            <x-form.error for="address" class="mt-2" />
                                        </div>

                                        <!-- Site description -->
                                        <div class="col-sm-12">

                                            <div class="mb-3">
                                                <x-form.label for="Postdesc" value="{{ __('Description') }}" />
                                                <textarea class="form-control" id="Postdesc" rows="5"
                                                    name="description" value="old('description')"
                                                    placeholder="Post Description"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                     <div class="row mt-4">
                                        <div class="col-md-4 mb-2">
                                            <x-form.input id="logo" class="block w-full mt-1" type="file" name="logo" :value="old('logo')"/>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <x-form.input id="fav" class="block w-full mt-1" type="file" name="fav" :value="old('fav')"/>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="image" id="img-show-container" style="display: none; width: 100px; height: 100px">
                                                <div class="fa fa-remove blue delete" onclick="resetImgUpl()"></div>
                                                <canvas id="img-show" class="img-thumbnail img-response"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button id="submit" type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">
        var blobs;
        $(document).ready(() => {
            // draw file onchange
            var input = document.querySelector('input[type=file]'); // see Example 4
            input.onchange = function () {
                var file = input.files[0];
                drawOnCanvas(file);   // see Example 6
                // displayAsImage(file); // see Example 7
            };


            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $('#setup-form').on('submit' ,function(e){
                    e.preventDefault();
                    let formData = new FormData($('#setup-form')[0]);
                    toggleAble('#submit', true, 'Submitting...');

                    $.ajax({
                        url: "{{ route('app.details') }}",
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
                            toggleAble('#submit', false);
                            resetForm('#setup-form');
                            window.location.reload();
                    }).catch((error) => {
                        Swal.fire({
                            title: "Oops!",
                            text: "Something went wrong!!!",
                            icon: "error",
                            showCancelButton:!0,
                            confirmButtonColor: "#f46a6a",
                        });
                        toggleAble('#submit', false);   
                    });
            });
        });

        function uploadImg(fn) {
            var input = document.querySelector('input[type=file]');
            var file = input.files[0];
            var form = new FormData(),
                xhr = new XMLHttpRequest();
                // form.append("filename", imageData);
            toBlob(document.querySelector('#img-show')).then(function(blob) {
                blobs = blob
                form.append('photo', blobs);
            // form.append('photo', file);
            form.append('_token', "{{csrf_token()}}");

            xhr.onload = () => {
                if (xhr.responseText) {
                fn()
                } else {
                alert('error try again')
                fn()
                }
            }

            xhr.open('post', "{{route('app.logo')}}", true);
            xhr.send(form)
            });
        }

        // function to draw image on selection
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

        // function to convert img to blob
        var toBlob = (canvas) => {
            return new Promise(function(resolve, reject) {
                canvas.toBlob(function(blob) {
                blob = blobToFile(blob, 'captured.jpg')
                resolve(blob) }, 'image/jpeg');
            })
        }

        // function to reset image display dom
        function resetImgUpl(){
            $('#logo').val(null)
            $('#img-show-container').hide()
        }

        // function to convert blob to file
        function blobToFile(theBlob, fileName){
            //A Blob() is almost a File() - it's just missing the two properties below which we will add
            theBlob.lastModifiedDate = new Date();
            theBlob.name = fileName;
            return theBlob;
        }
    </script>
    @endsection
    @include('partials.script')
</body>


</html>