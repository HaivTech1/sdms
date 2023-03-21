<x-app-layout>
    @section('title', application('name')." | Create User")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">User</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="title" value="{{ __('Title') }}" />
                                        <select class="form-control select2" name="title" value="old('title')">
                                            <option>Select</option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Miss">Miss.</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Prof">Prof</option>
                                        </select>
                                        <x-form.error for="title" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="name" value="{{ __('Name') }}" />
                                        <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                            id="name" :value="old('name')" autofocus />
                                        <x-form.error for="name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="email" value="{{ __('Email') }}" />
                                        <x-form.input id="email" class="block w-full mt-1" type="text" name="email"
                                            id="email" :value="old('email')" autofocus />
                                        <x-form.error for="email" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone_number"
                                             name="phone_number" :value="old('phone_number')" required>
                                        <x-form.error for="phone_number" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="password" value="{{ __('Password') }}" />
                                        <input type="password" class="form-control" id="userpassword"
                                         name="password" required>
                                        <x-form.error for="password" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="row justify-content-center align-items-center g-2">
                                            <div class="col">
                                                <x-form.label for="image" value="{{ __('Image') }}" />
                                                <x-form.input id="image" class="block w-full mt-1" placeholder="image"
                                                    type="file" name="image" />
                                                <x-form.error for="image" />
                                            </div>
                                            <div class="col">
                                             <div class="image" id="img-show-container" style="display: none; width:50px; height: 50px; border-radius: 50%">
                                                <div class="bx bx-trash-alt btn delete" onclick="resetImgUpl()"></div>
                                                <canvas id="img-show" class="img-thumbnail img-response"></canvas>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="type" value="{{ __('Type') }}" />
                                        <select class="form-control select2" name="type" value="old('type')">
                                            <option>Select</option>
                                            <option value="2">Administrator</option>
                                            <option value="3">Teacher</option>
                                            <option value="5">Bursal</option>
                                        </select>
                                        <x-form.error for="type" />
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                User</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">
             $(document).ready(() => {
                var blobs;
                // draw file onchange
                var input = document.querySelector('input[type=file]'); // see Example 4
                    input.onchange = function () {
                    var file = input.files[0];
                    drawOnCanvas(file);   // see Example 6
                    // displayAsImage(file); // see Example 7
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

                 // function to reset image display dom
                function resetImgUpl(){
                    $('#image').val(null)
                    $('#img-show-container').hide()
                }
            });
        </script>
    @endsection
</x-app-layout>