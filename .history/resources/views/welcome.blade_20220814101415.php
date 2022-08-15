<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Colony') }}</title>

    @include('partials.style')

</head>

<body>
    <div class="home-btn d-none d-sm-block">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-dark">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-dark mr-2">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 p-2 text-dark">Register</a>
            @endif
            @endauth
        </div>
        @endif
    </div>

    <section class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="home-wrapper">
                        <div class="mb-5">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="{{ asset('storage/'.application('image'))}}" alt="" height="20"
                                    class="auth-logo-dark mx-auto">
                                <img src="assets/images/logo-light.png" alt="" height="20"
                                    class="auth-logo-light mx-auto">
                            </a>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="/images/terminal.png" alt="terminal" class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-5">{{ application('name')}}</h3>
                        <p>{{ application('description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('partials.script')

</body>

</html>