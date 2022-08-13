<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('libs/%40chenfengyuan/datepicker/datepicker.min.js') }}"></script>


<script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('js/pages/task-create.init.js') }}"></script>
<script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('js/pages/dashboard.init.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/notiflix.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>


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
    })
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

<script type="text/javascript">
    window.addEventListener('show-details', event => {
        $('#details').modal('show');
    });

    // window.addEventListener('show-student', event => {
    //     $('#student').modal('show');
    // });
</script>

<script>
    $(document).ready(function() {
        // Select2 Multiple
        $('.select2-multiple').select2({
            placeholder: "Select",
            allowClear: true
        });

    });
</script>

@stack('modals')

@livewireScripts

<script src="{{ asset('js/alpine.js') }}"></script>
