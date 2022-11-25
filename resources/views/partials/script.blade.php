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

<!-- Bootstrap rating js -->
<script src="{{ asset('libs/bootstrap-rating/bootstrap-rating.min.js')}}"></script>

<script src="{{ asset('js/pages/rating-init.js') }}"></script>

<script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('js/pages/task-create.init.js') }}"></script>
<script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('js/pages/dashboard.init.js') }}"></script> --}}
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/notiflix.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<!-- plugin js -->
<script src="{{ asset('libs/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('libs/jquery-ui-dist/jquery-ui.min.js')}}"></script>
<script src="{{ asset('libs/fullcalendar/core/main.min.js')}}"></script>
<script src="{{ asset('libs/fullcalendar/bootstrap/main.min.js')}}"></script>
<script src="{{ asset('libs/fullcalendar/daygrid/main.min.js')}}"></script>
<script src="{{ asset('libs/fullcalendar/timegrid/main.min.js')}}"></script>
<script src="{{ asset('libs/fullcalendar/interaction/main.min.js')}}"></script>

<script src="{{ asset('libs/bootstrap-editable/js/index.js') }}"></script>


<!-- Calendar init -->
{{-- <script src="{{ asset('js/calendars-full.init.js')}}"></script> --}}

<script src="{{ asset('js/functions.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->
<script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- form advanced init -->
{{-- <script src="{{ asset('js/pages/form-advanced.init.js') }}"></script> --}}

<!-- Datatable init js -->
<script src="{{ asset('js/pages/datatables.init.js') }}"></script> 
<script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>

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

    window.addEventListener('show-student', event => {
    $('#student').modal('show');
    });
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

@yield('scripts')
@stack('modals')
@livewire('livewire-ui-spotlight')
@livewireScripts
<script src="{{ asset('js/alpine.js') }}" defer></script>