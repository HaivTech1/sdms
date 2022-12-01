<!doctype html>
<html lang="en">
    <head>
       <x-partials.head />
    </head>

    <body>
        <x-partials.nav/>

        @if (isset($header))
            <header class="mx-6 mt-6 text-gray-600 shadow bg-theme-blue-100">
                <div class="px-4 py-6 wrapper">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{ $slot }}

        <x-partials.footer />

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </body>
</html>
