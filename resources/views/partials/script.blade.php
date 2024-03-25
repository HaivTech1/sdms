<audio id="myAudio">
    <source src="{{  asset('sound/notification.mp3') }}" type="audio/mpeg">
</audio>

<div class="modal fade" id="popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 style="color: rgba(96,96,96,0.68)">
                                <i class="tio-shopping-cart-outlined"></i> <p>You have new registration, Check Please!</p>
                            </h2>
                            <hr>
                            <br />

                            <button onclick="check_registration()" class="btn btn-primary">Ok, let me check</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script src="{{ asset('js/pages/dashboard.init.js') }}"></script> --}}
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/notiflix.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-left",
            "progressBar": false
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

    $('#summernote').summernote({
        height: 100
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

<script type="text/javascript">
    window.addEventListener('show-details', event => {
        $('#details').modal('show');
    });

    window.addEventListener('show-student', event => {
        $('#student').modal('show');
    });

    window.addEventListener('show-scratch', event => {
        $('#scratch').modal('show');
    });

     window.addEventListener('close-modal', event => {
        $('#deleteResultModal').modal('hide');
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

<script>
    const supportsVideo = !!document.createElement('video').canPlayType;
    if (supportsVideo) {
            const videoContainer = document.getElementById('videoContainer');
            const video = document.getElementById('video');
            const videoControls = document.getElementById('video-controls');
            const playpause = document.getElementById('playpause');
            const stop = document.getElementById('stop');
            const mute = document.getElementById('mute');
            const volinc = document.getElementById('volinc');
            const voldec = document.getElementById('voldec');
            const progress = document.getElementById('progress');
            const progressBar = document.getElementById('progress-bar');
            const fullscreen = document.getElementById('fs');


            // Hide the default controls
            video.controls = false;

            // Display the user defined video controls
            videoControls.style.display = 'block';

            playpause.addEventListener('click', (e) => {
                if (video.paused || video.ended) {
                    video.play();
                } else {
                    video.pause();
                }
            });

            stop.addEventListener('click', (e) => {
                video.pause();
                video.currentTime = 0;
                progress.value = 0;
            });

            mute.addEventListener('click', (e) => {
                video.muted = !video.muted;
            });

            volinc.addEventListener('click', (e) => {
                alterVolume('+');
            });

            voldec.addEventListener('click', (e) => {
                alterVolume('-');
            });

            function alterVolume(dir) {
                const currentVolume = Math.floor(video.volume * 10) / 10;
                if (dir === '+' && currentVolume < 1) {
                    video.volume += 0.1;
                } else if (dir === '-' && currentVolume > 0) {
                    video.volume -= 0.1;
                }
            }

            video.addEventListener('loadedmetadata', () => {
                progress.setAttribute('max', video.duration);
            });

            video.addEventListener('timeupdate', () => {
                progress.value = video.currentTime;
                progressBar.style.width = `${Math.floor(video.currentTime * 100 / video.duration)}%`;
            });


            video.addEventListener('timeupdate', () => {
                if (!progress.getAttribute('max')) progress.setAttribute('max', video.duration);
                progress.value = video.currentTime;
                progressBar.style.width = `${Math.floor(video.currentTime * 100 / video.duration)}%`;
            });

            progress.addEventListener('click', (e) => {
                const rect = progress.getBoundingClientRect();
                const pos = (e.pageX  - rect.left) / progress.offsetWidth;
                video.currentTime = pos * video.duration;
            });

            if (!document?.fullscreenEnabled) {
                fullscreen.style.display = 'none';
            }

            fullscreen.addEventListener('click', (e) => {
                handleFullscreen();
            });

            function handleFullscreen() {
                if (document.fullscreenElement !== null) {
                    // The document is in fullscreen mode
                    document.exitFullscreen();
                    setFullscreenData(false);
                } else {
                    // The document is not in fullscreen mode
                    videoContainer.requestFullscreen();
                    setFullscreenData(true);
                }
            }

            function setFullscreenData(state) {
                videoContainer.setAttribute('data-fullscreen', !!state);
            }

            document.addEventListener('fullscreenchange', (e) => {
                setFullscreenData(!!document.fullscreenElement);
            });


    }
</script>

<script>
    $('#checkAll').change(function () {
        var isChecked = $(this).prop('checked');
        $('.actionCheck').prop('checked', isChecked);
        $('#publishSelected').toggle($('.actionCheck:checked').length > 0);
    });

    $('.actionCheck').change(function () {
        $('#publishSelected').toggle($('.actionCheck:checked').length > 0);
        $('#checkAll').prop('checked', $('.actionCheck:checked').length === $('.actionCheck').length);
    });

    $("#input-search").on("keyup", function () {
        var rex = new RegExp($(this).val(), "i");
        $(".search-table .search-items:not(.header-item)").hide();
        $(".search-table .search-items:not(.header-item)")
            .filter(function () {
                return rex.test($(this).text());
            })
        .show();
    });
</script>

@stack('modals')
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
<script src="{{ asset('js/alpine.js') }}" defer></script>
@stack('alpine-plugins')
@livewireScripts
@livewire('livewire-ui-spotlight')
@yield('scripts')
