<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-print-none">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model.debounce.350ms="grade">
                                <option value=''>Class</option>
                                @foreach ($grades as $grade)
                                <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pin-card mb-2">
                        @foreach ($pins as $pin)
                        <div class="col-sm-4">
                            <h1 class="text-center">{{ $pin->user->student->fullName() }}</h1>
                            <div class="card-scratch">
                                <img
                                    class="demo-bg"
                                    src="/images/logo.png"
                                    alt=""
                                >
                                <img src="{{ asset('storage/'.application('image')) }}" style="width: 40px; height: 40px; border-radius: 50%" />
                                <div class="demo-content">
                                    <h1>{{ application('name') }}</h1>
                                    <span>Pin: <b style="color: red">{{ $pin->user->pin() }}</b></span>
                                    <span style="font-size: 5px">{{ $pin->term->title() }} - {{ $pin->period->title() }}</span>
                                    <br />
                                    <span style="font-size: 8px">visit: haivtech.com.ng</span>
                                </div>
                            </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>