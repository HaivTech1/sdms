<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

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
                                <div class="alert alert-info text-left mb-4" role="alert">
                                    {{ __('Forgot your child\'s password? No problem. Please provide the student ID.') }}

                                </div>

                                <div>
                                    <div class="mb-3">
                                        <label for="reg_no" class="form-label">Student ID</label>
                                        <input type="text" class="form-control" id="reg_no"
                                            placeholder="E.g SLNP/24/2025" name="reg_no" :val>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light resetButton"
                                            type="submit">Request New Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>
                            <a href="{{ route('login') }}" class="fw-medium text-primary">Back to Login</a>
                        </p>
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>{{ application('name')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

        <script>
            $('.resetButton').on('click', function (e) {
                e.preventDefault();

                var $btn = $(this);
                var reg_no = $.trim($('#reg_no').val()).toUpperCase();

                if (!reg_no) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Required',
                        text: 'Student ID is required.'
                    });
                    return;
                }
                
                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Request',
                    html: 'Send password reset for Student ID:<br><b>' + reg_no + '</b>?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send it',
                    cancelButtonText: 'Cancel'
                }).then(function (result) {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: "{{ route('request.password') }}",
                        type: 'POST',
                        data: {
                            reg_no: reg_no,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            $btn.prop('disabled', true).text('Requesting...');
                            Swal.fire({
                                title: 'Requesting...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Request Sent',
                                text: response.message || 'Your request has been submitted.'
                            });
                        },
                        error: function (xhr) {
                            var msg = 'An error occurred. Please try again.';
                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.errors && xhr.responseJSON.errors.reg_no) {
                                    msg = xhr.responseJSON.errors.reg_no[0];
                                } else if (xhr.responseJSON.message) {
                                    msg = xhr.responseJSON.message;
                                }
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg
                            });
                        },
                        complete: function () {
                            $btn.prop('disabled', false).text('Request New Password');
                        }
                    });
                });
            });

        </script>


</html>
