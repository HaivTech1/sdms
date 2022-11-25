<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign in</title>

    @include('partials.style')

</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome</h5>
                                        <p>Create a New School Account.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{ url('/') }}">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('storage/'. application('image')) }}" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="needs-validation" method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <x-form.label for="title" value="{{ __('Title') }}" />
                                        <select class="form-control select2" name="title">
                                            <option>Select</option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Miss">Miss.</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Prof">Prof</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" 
                                            name="name" required>
                                        <div class="invalid-feedback">
                                            Please Enter Username
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="useremail"
                                            name="email" required>
                                        <div class="invalid-feedback">
                                            Please Enter Email
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone_number"
                                             name="phone_number" required>
                                        <div class="invalid-feedback">
                                            Please Enter Phone Number
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="userpassword"
                                             name="password" required>
                                        <div class="invalid-feedback">
                                            Please Enter Password
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmation Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                             name="password_confirmation"
                                            required>
                                        <div class="invalid-feedback">
                                            Please Enter Password
                                        </div>
                                    </div>


                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light"
                                            type="submit">Register</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.script')
</body>


</html>