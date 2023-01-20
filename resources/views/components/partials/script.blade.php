<script src="{{ asset("frontend/js/vendor/modernizr-3.6.0.min.js") }}"></script>
{{-- <script src="{{ asset("frontend/js/vendor/jquery-1.12.4.min.js") }}"></script> --}}
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset("frontend/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("frontend/js/popper.min.js") }}"></script>
<script src="{{ asset("frontend/js/slick.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.magnific-popup.min.js") }}"></script>
<script src="{{ asset("frontend/js/waypoints.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.counterup.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.nice-select.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.countdown.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.appear.min.js") }}"></script>
<script src="{{ asset("frontend/js/main.js") }}"></script>
<script src="{{ asset("frontend/js/vendor/modernizr-3.6.0.min.js") }}"></script>
<script src="{{ asset("frontend/js/vendor/jquery-1.12.4.min.js") }}"></script>
<script src="{{ asset("frontend/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("frontend/js/popper.min.js") }}"></script>
<script src="{{ asset("frontend/js/slick.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.magnific-popup.min.js") }}"></script>
<script src="{{ asset("frontend/js/waypoints.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.counterup.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.nice-select.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.countdown.min.js") }}"></script>
<script src="{{ asset("frontend/js/jquery.appear.min.js") }}"></script>
<script src="{{ asset("frontend/js/main.js") }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/notiflix.js') }}"></script>

<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-top-right",
            "progressBar": true
        }

        window.addEventListener('success', event => {
            toastr.success(event.detail.message, 'Success!');
        });

        window.addEventListener('error', event => {
            toastr.error(event.detail.message, 'Failed!');
        });

        window.addEventListener('info', event => {
            toastr.info(event.detail.message, 'Info!');
        });
    });
</script>

<script>
    @if (Session::has('messege'))
        var type = "{{ Session::get('alert-type', 'success') }}"
        switch (type) {
            case 'info':
                Notiflix.Report.Info("{{ Session::get('title') }}", "{{ Session::get('messege') }}",
                    "{{ Session::get('button') }}", );
                break;
            case 'success':
                Notiflix.Report.Success("{{ Session::get('title') }}", "{{ Session::get('messege') }}",
                    "{{ Session::get('button') }}", );
                break;
            case 'warning':
                Notiflix.Report.Warning("{{ Session::get('title') }}", "{{ Session::get('messege') }}",
                    "{{ Session::get('button') }}", );
                break;
            case 'error':
                Notiflix.Report.Failure("{{ Session::get('title') }}", "{{ Session::get('messege') }}",
                    "{{ Session::get('button') }}", );
                break;
        }
    @endif
</script>
@yield('scripts')
