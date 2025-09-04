<!doctype html>
<html lang="en">
    <head>
       <x-partials.head />
    </head>

    <body class="home-style4">

        <!-- <div id="loader" class="loader">
            <div class="loader-container">
                <div class='loader-icon'>
                    <img src="{{ URL::asset('storage/' .application('image')) }}" alt="logo">
                </div>
            </div>
        </div> -->

        <x-partials.nav/>

       <div class="main-content">
            @if (isset($header))
                <div class="rs-breadcrumbs breadcrumbs-overlay">
                    <div class="breadcrumbs-img">
                        <!-- <img src="{{ asset('storage/'.getAboutSetting('header_image')) }}" alt="Breadcrumb" style="height: 300px;"> -->
                    </div>
                    <div class="breadcrumbs-text white-color">
                        <h1 class="page-title">{{ $header }}</h1>
                        <ul>
                            <li>
                                <a class="active" href="{{ url('/') }}">{{ application('name') }}</a>
                            </li>
                            <li>{{ $header }}</li>
                        </ul>
                    </div>
                </div>
            @endif

            {{ $slot }}
       </div>


        <x-partials.footer />

        <div id="scrollUp">
            <i class="fa fa-angle-up"></i>
        </div>
        <x-partials.script />
    </body>
</html>
