<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="description" content="@yield('description')" />
    <meta property="keywords" content="@yield('keywords')" />

    {{-- facebook Meta --}}
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="@yield('metaImage')" />
    <meta property="og:image:type" content="image/jpeg" />


    {{-- twitter Meta --}}
    <meta property="twitter:card" content="@yield('summary_large_image')" />
    <meta property="twitter:site" content="{{ config('services.twitter.handle') }}" />
    <meta property="twitter:image" content="@yield('metaImage')" />
    <meta property="twitter:description" content="@yield('description')" />
    <meta property="twitter:title" content="@yield('title')" />
    <meta name="theme-color" content="#6777ef" />

    {{-- Title --}}
    <title>@yield('title', ''.application('name'))</title>

    @include('partials.style')

</head>

<body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('partials.header')

        <!-- ========== Left Sidebar Start ========== -->

        @include('partials.sidenav')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                <div class="container-fluid">
                    @if (isset($header))
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                    @endif
                    {{ $slot }}

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!-- Transaction Modal -->
            @include('shared.transactionModal')
            <!-- end modal -->

            <!-- subscribeModal -->
            <!-- @include('shared.subscriptionModal') -->
            <!-- end modal -->

            @include('partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @include('partials.script')
</body>

</html>