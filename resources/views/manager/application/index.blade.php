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
            <div class="card" x-data="{ currentTab: $persist('general')}">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li @click.prevent="currentTab = 'general'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'general' ? 'active' : ''" data-bs-toggle="tab" href="#general" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">General</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'mail'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'mail' ? 'active' : ''" data-bs-toggle="tab" href="#mail" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Mail</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'payment'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'payment' ? 'active' : ''" data-bs-toggle="tab" href="#payment" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Payment method</span>    
                            </a>
                        </li>
                        <li @click.prevent="currentTab = 'notification'" class="nav-item">
                            <a class="nav-link" :class="currentTab === 'notification' ? 'active' : ''" data-bs-toggle="tab" href="#notification" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Actions</span>    
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane" :class="currentTab === 'general' ? 'active' : ''" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12 mb-3 mt-3">
                                    <div class="card">
                                        <div class="card-body" style="padding-bottom: 12px">
                                            <div class="row">
                                                @php($config = get_application_settings('maintenance_mode'))
                                                <div class="col-6">
                                                    <h5 class="text-capitalize">
                                                        <i class="bx bx-cog"></i>
                                                        {{ translate('messages.maintenance_mode') }}
                                                    </h5>
                                                </div>
                                                <div class="col-6">
                                                    <label class="switch ml-3 float-right">
                                                        <input type="checkbox" class="form-check-input status" onclick="maintenance_mode()"
                                                            {{ isset($config) && $config ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <livewire:manager.application>
                            </div> 
                        </div>

                        <div class="tab-pane" :class="currentTab === 'mail' ? 'active' : ''" id="mail" role="tabpanel">

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

                        <div class="tab-pane" :class="currentTab === 'payment' ? 'active' : ''" id="payment" role="tabpanel">
                            <div class="row">
                                <div class="row" style="padding-bottom: 20px">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body" style="padding: 20px">
                                                <h5 class="text-center">{{translate('messages.payment')}} {{translate('messages.method')}}</h5>
                                                @php($config = get_application_settings('cash'))
                                                <form action="{{route('appSetting.payment-method-update',['cash'])}}"
                                                    method="post">
                                                    @csrf
                                                    
                                                        <div class="form-group mb-2">
                                                            <label class="control-label">{{translate('messages.cash')}}</label>
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
                        <div class="tab-pane" :class="currentTab === 'notification' ? 'active' : ''" id="notification" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mt-2 mb-2">Toggle notification settings</h4>

                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Allow Father Notification</h5>
                                            <div>
                                                <input type="checkbox" id="father_notification" switch="success" data-field="father_notification" @if (get_settings('father_notification') === 1) checked @endif />
                                                <label for="father_notification" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Allow Mother Notification</h5>
                                            <div>
                                                <input type="checkbox" id="mother_notification" switch="success" data-field="mother_notification" @if (get_settings('mother_notification') === 1) checked @endif />
                                                <label for="mother_notification" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Allow Guardian Notification</h5>
                                            <div>
                                                <input type="checkbox" id="guardian_notification" switch="success" data-field="guardian_notification" @if (get_settings('guardian_notification') === 1) checked @endif />
                                                <label for="guardian_notification" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title mt-2 mb-2">Application settings</h4>
                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Registration Link</h5>
                                            <div>
                                                <input type="checkbox" id="registration_link" switch="success" data-field="registration_link" @if (get_settings('registration_link') === 1) checked @endif />
                                                <label for="registration_link" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Check students payment</h5>
                                            <div>
                                                <input type="checkbox" id="check_payment" switch="success" data-field="check_payment" @if (get_settings('check_payment') === 1) checked @endif />
                                                <label for="check_payment" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Activate mid term upload</h5>
                                            <div>
                                                <input type="checkbox" id="mid_upload" switch="success" data-field="mid_upload" @if (get_settings('mid_upload') === 1) checked @endif />
                                                <label for="mid_upload" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <h5 class="font-size-14 mb-3">Activate Exam upload</h5>
                                            <div>
                                                <input type="checkbox" id="exam_upload" switch="success" data-field="exam_upload" @if (get_settings('exam_upload') === 1) checked @endif />
                                                <label for="exam_upload" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>

                                        @superadmin
                                            <div class="col-sm-4">
                                                <h5 class="font-size-14 mb-3">App Debug</h5>
                                                <div>
                                                    <input type="checkbox" id="app_debug" switch="success" data-field="app_debug" @if (get_settings('app_debug') === 1) checked @endif />
                                                    <label for="app_debug" data-on-label="True" data-off-label="False"></label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <h5 class="font-size-14 mb-3">App ENV</h5>
                                                <div>
                                                    <input type="checkbox" id="app_env" switch="success" data-field="app_env" @if (get_settings('app_env') === 1) checked @endif />
                                                    <label for="app_env" data-on-label="Live" data-off-label="Local"></label>
                                                </div>
                                            </div>
                                        @endsuperadmin
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                            <div class="card-body">
                                <h1 class="card-title mt-2 mb-2">Marks format for midterm and exam control unit</h1>

                                <div class="row mb-2">
                                    <button type="button" onclick="copyDataFormat()" class="btn btn-sm btn-primary">Copy marks format</button>
                                </div>

                                <form id="settingForm" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="row">
                                        <table class="table table-bordered" id="settingTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(\App\Models\Setting::all() as $setting)
                                                    @if (!in_array($setting->key, ['mail_config', 'digital_payment', 'paystack', 'cash', 'over_ten', 'over_twenty', 'over_fourty', 'over_sixty', 'over_hundred', 'exam_grade', 'exam_remark']) && $setting->value != 1 && $setting->value != 0)
                                                        <?php $data = json_decode($setting->value, true); ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[{{ $loop->index }}][key]" value="{{ $setting->key }}" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[{{ $loop->index }}][value]"
                                                                    value="{{ implode(',', array_map(function ($key, $value) { return $key.':'.$value['full_name'].':'.$value['mark']; }, array_keys($data), $data)) }}"
                                                                    class="form-control"
                                                                    placeholder="Enter data in the format: code:title:mark eg - first_test:First Test:15,entry_2:Entry 2:20,ca:Continuous Assessment:30,project:Project:25"
                                                                />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="add" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                                @if (\App\Models\Setting::count() == 0)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="addmore[0][key]"
                                                                placeholder="Enter your name" class="form-control" />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="addmore[0][value]"
                                                                placeholder="Enter data in the format: code:title:mark eg - first_test:First Test:15,entry_2:Entry 2:20,ca:Continuous Assessment:30,project:Project:25" class="form-control" />
                                                        </td>
                                                        <td>
                                                            <button type="button" name="add" id="add" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                    </div>

                                    <div class="float-right">
                                        <button id="settingBtn" class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title mt-2 mb-2">Grading and Color control unit</h1>
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <button type="button" onclick="copyColorFormat()" class="btn btn-sm btn-primary">Copy color format</button>
                                        </div>
                                        <div class="col-sm-6">

                                            @foreach(colorArray() as $name => $hex)
                                                <button onclick="copyToColorClipboard('{{ $hex }}')" class="btn btn-sm text-white" style="background-color: {{$hex}};">{{$name}}</button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <form id="colorForm" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="row">
                                            <table class="table table-bordered" id="colorTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $settings = \App\Models\Setting::whereIn('key', [
                                                            'over_ten', 'over_twenty', 'over_fourty', 'over_sixty', 'over_hundred',
                                                        ])->get();
                                                    ?>
                                                    
                                                    @foreach( $settings as $setting)
                                                            <?php $data = json_decode($setting->value, true); ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="addmore[{{ $loop->index }}][key]" value="{{ $setting->key }}" class="form-control" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="addmore[{{ $loop->index }}][value]"
                                                                        value="{{ implode(',', array_map(function ($key, $value) { return $key.':'.$value['from'].':'.$value['color']; }, array_keys($data), $data)) }}"
                                                                        class="form-control"
                                                                        placeholder="Enter data in the format: markfrom:markto:color eg - 8.5:10:#ff0022"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="add" id="addColor" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                    @endforeach

                                                    @if ($settings->count() == 0)
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[0][key]"
                                                                    placeholder="Enter your name" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[0][value]"
                                                                    placeholder="Enter data in the format: markfrom:markto:color eg - 8.5:10:#ff0022" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="addColor" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            
                                        </div>

                                        <div class="float-right">
                                            <button id="colorBtn" class="btn btn-success" type="submit">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title mt-2 mb-2">Exam grade and remark control unit</h1>
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <button type="button" onclick="copyToGradeClipboard()" class="btn btn-sm btn-primary">Copy grade format</button>
                                        </div>
                                    </div>

                                    <form id="gradeForm" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="row">
                                            <table class="table table-bordered" id="gradeTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $settings = \App\Models\Setting::whereIn('key', [
                                                            'exam_grade', 'exam_remark',
                                                        ])->get();
                                                    ?>
                                                    
                                                    @foreach( $settings as $setting)
                                                            <?php $data = json_decode($setting->value, true); ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="addmore[{{ $loop->index }}][key]" value="{{ $setting->key }}" class="form-control" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="addmore[{{ $loop->index }}][value]"
                                                                        value="{{ implode(',', array_map(function ($key, $value) { return $key.':'.$value['from'].':'.$value['text']; }, array_keys($data), $data)) }}"
                                                                        class="form-control"
                                                                        placeholder="Enter data in the format: markfrom:markto:text eg - 8.5:10:A"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="add" id="addGrade" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                    @endforeach

                                                    @if ($settings->count() == 0)
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="addmore[0][key]"
                                                                    placeholder="Enter your name" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="text" name="addmore[0][value]"
                                                                    placeholder="Enter data in the format: markfrom:markto:text eg - 8.5:10:A" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="addGrade" class="btn btn-success"><i class="bx bx-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            
                                        </div>

                                        <div class="float-right">
                                            <button id="gradeBtn" class="btn btn-success" type="submit">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('alpine-plugins')
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    @endpush

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

            function copyToColorClipboard(hex) {
                const el = document.createElement('textarea');
                el.value = hex;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                toastr.success("{{translate('messages.text_copied')}}");
            }

            function copyToGradeClipboard() {
                const el = document.createElement('textarea');
                el.value = 'markfrom:markto:text';
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                toastr.success("{{translate('messages.text_copied')}}");
            }

        </script>

        <script>
            function maintenance_mode() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Be careful before you turn on/off maintenance mode',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#377dff',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                    $.get({
                        url: '{{ route('appSetting.maintenance-mode') }}',
                        contentType: false,
                        processData: false,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        toastr.success(data.message);
                    },
                    complete: function () {
                        $('#loading').hide();
                        },
                        });
                    } else {
                        location.reload();
                    }
                })
            };

            function readURL(input, viewer) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + viewer).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#customFileEg1").change(function() {
                readURL(this, 'viewer');
            });

            $("#favIconUpload").change(function() {
                readURL(this, 'iconViewer');
            });
        </script>

        <script>
            const inputFields = document.querySelectorAll('[data-field]');

            inputFields.forEach(inputField => {
                inputField.addEventListener('change', function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });

                    const field = this.dataset.field;
                    const value = this.checked ? 1 : 0;

                    const formData = new FormData();
                    formData.append(field, value);

                    $.ajax({
                        method: 'POST',
                        url: '/appSetting/update-notification',
                        data: formData, // use "data" instead of "body"
                        processData: false,
                        contentType: false
                    }).then(response => {
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000)
                    }).catch(error => {
                        toastr.error('There was a problem with the fetch operation:', error);
                    });
                });
            });
        </script>

        <script type="text/javascript">
            function copyDataFormat() {
                var format = 'code:name:mark,code:name:mark,code:name:mark,code:name:mark';
                var tempInput = document.createElement('textarea');
                tempInput.value = format;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                toastr.success('Copied!');
            }

            function copyColorFormat() {
                var format = 'markfrom:markto:color';
                var tempInput = document.createElement('textarea');
                tempInput.value = format;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                toastr.success('Copied!');
            }

            var i = 0;
            $("#add").click(function(){
                ++i;
                $("#settingTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter your name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="Enter your value" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
            });
        
            $(document).on('click', '.remove-tr', function(){  
                $(this).parents('tr').remove();
            });

            $('#settingForm').on('submit' , function(e){
                e.preventDefault();
                let formData = new FormData($('#settingForm')[0]);
                toggleAble('#settingBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/mark/format",
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#settingBtn', false);
                    toastr.success(response.message);
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000)
                }).catch((error) => {
                    console.log(error);
                    toggleAble('#settingBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });

            $('#colorForm').on('submit' , function(e){
                e.preventDefault();
                let formData = new FormData($('#colorForm')[0]);
                toggleAble('#colorBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/color/format",
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#colorBtn', false);
                    toastr.success(response.message);
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000)
                }).catch((error) => {
                    toggleAble('#colorBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });

            $('#gradeForm').on('submit' , function(e){
                e.preventDefault();
                let formData = new FormData($('#gradeForm')[0]);
                toggleAble('#gradeBtn', true, 'Saving...');
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/appSetting/grade/format",
                    method: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }).then((response) => {
                    toggleAble('#gradeBtn', false);
                    toastr.success(response.message);
                    setTimeout(() =>{
                        window.location.reload();
                    }, 1000)
                }).catch((error) => {
                    toggleAble('#gradeBtn', false);
                    toastr.error(error.responseJSON.message);
                });
            });
        </script>

        <script>
             var i = 0;
                $("#addColor").click(function(){
                    ++i;
                    $("#colorTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter your name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="Enter your value" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
                });
            
                $(document).on('click', '.remove-tr', function(){  
                    $(this).parents('tr').remove();
                });
        </script>

         <script>
             var i = 0;
                $("#addGrade").click(function(){
                    ++i;
                    $("#gradeTable").append('<tr><td><input type="text" name="addmore['+i+'][key]" placeholder="Enter your name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][value]" placeholder="Enter your value" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="bx bx-trash"></i></button></td></tr>');
                });
            
                $(document).on('click', '.remove-tr', function(){  
                    $(this).parents('tr').remove();
                });
        </script>

    @endsection
</x-app-layout>