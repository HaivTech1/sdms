<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="description" content="{{ application('description') }}" />
    <meta property="keywords" content="@yield('keywords')" />

    {{-- facebook Meta --}}
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="{{ asset('storage/'.application('image')) }}" />
    <meta property="og:image:type" content="image/jpeg" />


    {{-- twitter Meta --}}
    <meta property="twitter:card" content="@yield('summary_large_image')" />
    <meta property="twitter:site" content="{{ config('services.twitter.handle') }}" />
    <meta property="twitter:image" content="{{ asset('storage/'.application('image')) }}" />
    <meta property="twitter:description" content="@yield('description')" />
    <meta property="twitter:title" content="@yield('title')" />
    <meta name="theme-color" content="#6777ef" />

    <title>Site under maintenance</title>

    @include('partials.style')

</head>

<body>
    
    @include('partials.script')
</body>


</html>