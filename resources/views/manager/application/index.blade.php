<x-app-layout>
    @section('title', application('name')." | Settings Page")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Setting</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">General</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Mail</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Payment method</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Notification</span>    
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <livewire:manager.application />
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel">

                                <div class="row pb-2">
                                    <div class="col-md-6 col-sm-8 card">
                                        <div class="card-body">
                                            <div>
                                                <p class="text-danger text-lg">{{ translate('test_your_email_integration') }}</p>
                                            </div>

                                            <form class="config_form">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="form-group mb-2">
                                                            <label for="inputPassword2" class="sr-only">
                                                                {{ translate('mail') }}</label>
                                                            <input type="email" id="test-email" class="form-control"
                                                                placeholder="Ex : jhon@email.com">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <button type="submit" id="config_test" class="btn btn-primary mb-2 btn-block">
                                                            <i class="bx bx-paper-plane"></i>
                                                            {{ translate('send_mail') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row gx-2 gx-lg-3">
                                    @php($config = \App\Models\Setting::where(['key' => 'mail_config'])->first())
                                    @php($data = $config ? json_decode($config['value'], true) : null)

                                    <form id="mail-setup" class="card-body" action="{{ route('appSetting.mail_config')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                        {{-- Main Status --}}
                                        <div class="col-sm-12 from-group mb-2 text-center">
                                            <label class="control-label h3">{{ translate('smtp_mail_config') }}</label>
                                        </div>
                                        <div class="col-sm-12 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('status') }}</label>
                                        </div>
                                        <div class="col-sm-12 from-group mb-2 mt-2">
                                            <input type="radio" name="status" value="1"
                                                {{ isset($data['status']) && $data['status'] == 1 ? 'checked' : '' }}>
                                            <label style="padding-left: 10px">{{ translate('Active') }}</label>
                                            <br>
                                        </div>
                                        <div class="col-sm-12 from-group mb-2">
                                            <input type="radio" name="status" value="0"
                                                {{ isset($data['status']) && $data['status'] == 0 ? 'checked' : '' }}>
                                            <label style="padding-left: 10px">{{ translate('Inactive') }}</label>
                                            <br>
                                        </div>
                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.mailer') }}
                                                {{ translate('messages.name') }}</label><br>
                                            <input type="text" placeholder="ex : Alex" class="form-control" name="name"
                                                value="{{ env('APP_MODE') != 'local' ? $data['name'] ?? '' : '' }}" required>
                                        </div>

                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.host') }}</label><br>
                                            <input type="text" class="form-control" name="host"
                                                value="{{ env('APP_MODE') != 'local' ? $data['host'] ?? '' : '' }}" required>
                                        </div>
                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.driver') }}</label><br>
                                            <input type="text" class="form-control" name="driver"
                                                value="{{ env('APP_MODE') != 'local' ? $data['driver'] ?? '' : '' }}" required>
                                        </div>
                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.port') }}</label><br>
                                            <input type="text" class="form-control" name="port"
                                                value="{{ env('APP_MODE') != 'local' ? $data['port'] ?? '' : '' }}" required>
                                        </div>

                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.username') }}</label><br>
                                            <input type="text" placeholder="ex : ex@yahoo.com" class="form-control" name="username"
                                                value="{{ env('APP_MODE') != 'local' ? $data['username'] ?? '' : '' }}" required>
                                        </div>

                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.email') }}
                                                {{ translate('messages.id') }}</label><br>
                                            <input type="text" placeholder="ex : ex@yahoo.com" class="form-control" name="email"
                                                value="{{ env('APP_MODE') != 'local' ? $data['email_id'] ?? '' : '' }}" required>
                                        </div>

                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.encryption') }}</label><br>
                                            <input type="text" placeholder="ex : tls" class="form-control" name="encryption"
                                                value="{{ env('APP_MODE') != 'local' ? $data['encryption'] ?? '' : '' }}" required>
                                        </div>

                                        <div class="col-sm-6 from-group mb-2">
                                            <label style="padding-left: 10px">{{ translate('messages.password') }}</label><br>
                                            <input type="text" class="form-control" name="password"
                                                value="{{ env('APP_MODE') != 'local' ? $data['password'] ?? '' : '' }}" required>
                                        </div>

                                        <button id="mail-btn" type="submit" class="btn btn-primary mb-2">{{ translate('messages.save') }}
                                        </button>

                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane" id="messages" role="tabpanel">
                                <div class="row">
                                    <div class="row" style="padding-bottom: 20px">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body" style="padding: 20px">
                                                    <h5 class="text-center">{{translate('messages.payment')}} {{translate('messages.method')}}</h5>
                                                    @php($config = get_application_settings('cash_on_delivery'))
                                                    <form action="{{route('appSetting.payment-method-update',['cash_on_delivery'])}}"
                                                        method="post">
                                                        @csrf
                                                        
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">{{translate('messages.cash_on_delivery')}}</label>
                                                            </div>
                                                            <div class="form-group mb-2 mt-2">
                                                                <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.active')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                                                <label
                                                                    style="padding-left: 10px">{{translate('messages.inactive')}}</label>
                                                                <br>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary mb-2">{{translate('messages.save')}}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body" style="padding: 20px">
                                                    <h5 class="text-center">{{translate('messages.payment')}} {{translate('messages.method')}}</h5>
                                                    @php($digital_payment = get_application_settings('digital_payment'))
                                                    <form action="{{route('appSetting.payment-method-update',['digital_payment'])}}"
                                                        method="post">
                                                        @csrf
                                                            <div class="form-group mb-2">
                                                                <label
                                                                    class="control-label text-capitalize">{{translate('messages.digital')}} {{translate('messages.payment')}}</label>
                                                            </div>
                                                            <div class="form-group mb-2 mt-2">
                                                                <input type="radio" class="digital_payment" name="status" value="1" {{$digital_payment?($digital_payment['status']==1?'checked':''):''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.active')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="radio" class="digital_payment" name="status" value="0" {{$digital_payment?($digital_payment['status']==0?'checked':''):''}}>
                                                                <label
                                                                    style="padding-left: 10px">{{translate('messages.inactive')}}</label>
                                                                <br>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary mb-2">{{translate('messages.save')}}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row digital_payment_methods" style="padding-bottom: 20px">

                                        <div class="col-md-6" style="margin-top: 26px!important;">
                                            <div class="card">
                                                <div class="card-body" style="padding: 20px">
                                                    <h5 class="text-center">{{translate('messages.paystack')}}</h5>
                                                    <span class="badge badge-soft-danger">{{translate('messages.paystack_callback_warning')}}</span>
                                                    @php($config=get_application_settings('paystack'))
                                                    <form
                                                        action="{{env('APP_MODE')!='demo'?route('appSetting.payment-method-update',['paystack']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">{{translate('messages.paystack')}}</label>
                                                            </div>
                                                            <div class="form-group mb-2 mt-2">
                                                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.active')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.inactive')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label
                                                                    style="padding-left: 10px">{{translate('messages.publicKey')}}</label><br>
                                                                <input type="text" class="form-control" name="publicKey"
                                                                    value="{{env('APP_MODE')!='demo'?$config['publicKey']:''}}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="text-capitalize" style="padding-left: 10px">{{translate('messages.secret')}} {{translate('messages.key')}} </label><br>
                                                                <input type="text" class="form-control" name="secretKey"
                                                                    value="{{env('APP_MODE')!='demo'?$config['secretKey']:''}}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="text-capitalize" style="padding-left: 10px">{{translate('messages.payment')}} {{translate('messages.url')}}</label><br>
                                                                <input type="text" class="form-control" name="paymentUrl"
                                                                    value="{{env('APP_MODE')!='demo'?$config['paymentUrl']:''}}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="text-capitalize" style="padding-left: 10px">{{translate('messages.merchant')}} {{translate('messages.email')}}</label><br>
                                                                <input type="text" class="form-control" name="merchantEmail"
                                                                    value="{{env('APP_MODE')!='demo'?$config['merchantEmail']:''}}">
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                    class="btn btn-primary mb-2">{{translate('messages.save')}}</button>
                                                                <button type="button" class="btn btn-info mb-2 pull-right" onclick="copy_text('{{url('/')}}/paystack-callback')">{{translate('messages.copy_callback')}}</button>        
                                                            </div>

                                                            
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn-primary mb-2">{{translate('messages.configure')}}</button>
                                                            

                                                            
                                                        @endif

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 pt-4">
                                            <div class="card">
                                                <div class="card-body" style="padding: 20px">
                                                    <h5 class="text-center">{{translate('messages.flutterwave')}}</h5>
                                                    @php($config=get_application_settings('flutterwave'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('appSetting.payment-method-update',['flutterwave']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">{{translate('messages.flutterwave')}}</label>
                                                            </div>
                                                            <div class="form-group mb-2 mt-2">
                                                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.active')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.inactive')}} </label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="text-capitalize"
                                                                    style="padding-left: 10px">{{translate('messages.publicKey')}}</label><br>
                                                                <input type="text" class="form-control" name="public_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="text-capitalize"
                                                                    style="padding-left: 10px">{{translate('messages.secret')}} {{translate('messages.key')}}</label><br>
                                                                <input type="text" class="form-control" name="secret_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="text-capitalize"
                                                                    style="padding-left: 10px">{{translate('messages.hash')}}</label><br>
                                                                <input type="text" class="form-control" name="hash"
                                                                    value="{{env('APP_MODE')!='demo'?$config['hash']:''}}">
                                                            </div>

                                                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{translate('messages.save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn-primary mb-2">{{translate('messages.configure')}}</button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 pt-4">
                                            <div class="card">
                                                <div class="card-body" style="padding: 20px">
                                                    <h5 class="text-center">{{translate('messages.paypal')}}</h5>
                                                    @php($config=get_application_settings('paypal'))
                                                    <form
                                                        action="{{env('APP_MODE')!='demo'?route('appSetting.payment-method-update',['paypal']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">{{translate('messages.paypal')}}</label>
                                                            </div>
                                                            <div class="form-group mb-2 mt-2">
                                                                <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.active')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.inactive')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label
                                                                    style="padding-left: 10px">{{translate('messages.paypal')}} {{translate('messages.client')}} {{translate('messages.id')}}</label><br>
                                                                <input type="text" class="form-control" name="paypal_client_id"
                                                                    value="{{env('APP_MODE')!='demo'?($config?$config['paypal_client_id']:''):''}}">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label style="padding-left: 10px">{{translate('messages.paypalsecret')}} </label><br>
                                                                <input type="text" class="form-control" name="paypal_secret"
                                                                    value="{{env('APP_MODE')!='demo'?$config['paypal_secret']??'':''}}">
                                                            </div>
                                                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                    class="btn btn-primary mb-2">{{translate('messages.save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn-primary mb-2">{{translate('messages.configure')}}</button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 pt-4">
                                            <div class="card">
                                                <div class="card-body" style="padding: 20px">
                                                    <h5 class="text-center">{{translate('messages.stripe')}}</h5>
                                                    @php($config=get_application_settings('stripe'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('appSetting.payment-method-update',['stripe']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">{{translate('messages.stripe')}}</label>
                                                            </div>
                                                            <div class="form-group mb-2 mt-2">
                                                                <input type="radio" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.active')}}</label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="radio" name="status" value="0" {{$config?($config['status']==0?'checked':''):''}}>
                                                                <label style="padding-left: 10px">{{translate('messages.inactive')}} </label>
                                                                <br>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label
                                                                    style="padding-left: 10px">{{translate('messages.published')}} {{translate('messages.key')}}</label><br>
                                                                <input type="text" class="form-control" name="published_key"
                                                                    value="{{env('APP_MODE')!='demo'?($config?$config['published_key']:''):''}}">
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label
                                                                    style="padding-left: 10px">{{translate('messages.api')}} {{translate('messages.key')}}</label><br>
                                                                <input type="text" class="form-control" name="api_key"
                                                                    value="{{env('APP_MODE')!='demo'?($config?$config['api_key']:''):''}}">
                                                            </div>
                                                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{translate('messages.save')}}</button>
                                                         @else
                                                            <button type="submit"
                                                                    class="btn btn-primary mb-2">{{translate('messages.configure')}}</button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="settings" role="tabpanel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @section('scripts')
        <script>

            $('#mail-setup').on('submit', function (e) {
               e.preventDefault();
               toggleAble('#mail-btn', true, 'Submitting...');

               var data = $(this).serializeArray();
               var url = $(this).attr('action');

               $.ajax({
                    method: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#mail-btn', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#guardianUpdate');
                        window.location.reload();
                    }else{
                        toggleAble('#mail-btn', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#mail-btn', false);
                });
            });
            
            function ValidateEmail(inputText) {
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (inputText.match(mailformat)) {
                    return true;
                } else {
                    return false;
                }
            }

            $('.config_form').on('submit', function(e){
                e.preventDefault();
                Swal.fire({
                    title: '{{ translate('Are you sure?') }}?',
                    text: "{{ translate('a_test_mail_will_be_sent_to_your_email') }}!",
                    showCancelButton: true,
                    confirmButtonColor: '#377dff',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '{{ translate('Yes') }}!'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('appSetting.mail.send') }}",
                            method: 'GET',
                            data: {
                                "email": $('#test-email').val()
                            },
                            beforeSend: function() {
                                toggleAble('#config_test', true, 'Sending...');

                            },
                            success: function(data) {
                                if (data.status) {
                                    toastr.success(
                                        '{{ translate('email_configured_perfectly!') }}!'
                                    );
                                }else {
                                    toastr.info(
                                        '{{ translate('email_status_is_not_active') }}!'
                                    );
                                }
                            },
                            complete: function() {
                                toggleAble('#config_test', false);
                            }
                        });
                    }
                })
            });
        </script>
        <script>
            @if(!isset($digital_payment) || $digital_payment['status']==0)
                $('.digital_payment_methods').hide();
            @endif
            $(document).ready(function () {
                $('.digital_payment').on('click', function(){
                    if($(this).val()=='0')
                    {
                        $('.digital_payment_methods').hide();
                    }
                    else
                    {
                        $('.digital_payment_methods').show();
                    }
                })
            });
            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();

                toastr.success("{{translate('messages.text_copied')}}");
            }

        </script>
    @endsection
</x-app-layout>