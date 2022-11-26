<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back to !</h5>
                                <p>{{ application('name') }}</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-6 col-lg-8">
                            <div class="avatar-md profile-user-wid">
                                <img src="{{ asset('storage/'.$user->image()) }}" alt="" class="img-thumbnail rounded-circle avatar-sm">
                            </div>
                            <div>
                                <h5>{{  $user->student->fullName() }}</h5>
                                <p class="text-muted mb-1">{{ $user->code() }}</p>
                                <p class="text-muted mb-0">{{ $user->student->grade->title() }}</p>

                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-size-15">{{ $user->student->subjects->count() }}</h5>
                                        <p class="text-muted mb-0">Subjects</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div>
                    <div class="row">
                    
                        <div class="col-lg-12">
                            <div class="p-4">
                                <p style="font-weight: bold; font-size: 20px">{{ application('name') }}</p>
                                <div class="mt-2">
                                    <div class="onoffswitch3">
                                        <input type="checkbox" name="onoffswitch3" class="onoffswitch3-checkbox" id="myonoffswitch3" checked>
                                        <label class="onoffswitch3-label" for="myonoffswitch3">
                                            <span class="onoffswitch3-inner">
                                                <span class="onoffswitch3-active">
                                                    <marquee class="scroll-text">
                                                        Avengers: Infinity War's Iron Spider Suit May Use Bleeding Edge Tech  
                                                        <span class="bx bx-caret-right"></span> 
                                                        Russo brothers ask for fans not to spoil Avengers: Infinity War 
                                                        <span class="bx bx-caret-right"></span>  
                                                        Bucky's Arm Miraculously Regenerates On Avengers: Infinity War Poster
                                                    </marquee>
                                                    <span class="onoffswitch3-switch">BREAKING NEWS <span class="bx bx-x"></span></span>
                                                </span>
                                                <span class="onoffswitch3-inactive"><span class="onoffswitch3-switch">SHOW BREAKING NEWS</span></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <img src="{{ asset('storage/'.application('image')) }}" alt="" class="avatar-md rounded-circle img-thumbnail">
                                                </div>
                                                <div class="flex-grow-1 align-self-center">
                                                    <div class="text-muted">
                                                        <p class="mb-2">{{ $user->student->guardian->fullName()}}</p>
                                                        <p class="mb-2">{{ $user->student->guardian->email()}}</p>
                                                        <p class="mb-0">{{ $user->student->guardian->relationship()}}</p>
                                                        <p class="mb-0">{{ $user->student->guardian->phoneNumber()}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="col-lg-4 align-self-center">
                                            <div class="text-lg-center mt-4 mt-lg-0">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div>
                                                            <p class="text-muted text-truncate mb-2">Session</p>
                                                            <h5 class="mb-0">{{ $session->title()}}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div>
                                                            <p class="text-muted text-truncate mb-2">Term</p>
                                                            <h5 class="mb-0">{{ $term->title()}}</h5>
                                                        </div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>