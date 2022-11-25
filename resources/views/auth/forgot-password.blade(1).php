<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Password</title>

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
                                        <h5 class="text-primary"> Reset Password</h5>
                                        <p>Reset Password with {{ application('name')}}.</p>
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

                            @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                            @endif

                            <x-jet-validation-errors class="mb-4 text-danger" />

                            <div class="p-2">
                                <div class="alert alert-success text-center mb-4" role="alert">
                                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}

                                </div>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="useremail"
                                            placeholder="Enter email" name="email" :val>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                            type="submit">Reset</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Don't have an account ? <a href="{{route('register') }}" class="fw-medium text-primary">
                                    Signup now </a> </p>
                            <p>© <script>
                                document.write(new Date().getFullYear())
                                </script>{{ application('name')}}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        < @include('partials.script') </body>


</html>