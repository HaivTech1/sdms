<div class="card overflow-hidden">
    <div class="bg-primary bg-soft">
        <div class="row">
            <div class="col-7">
                <div class="text-primary p-3">
                    <h5 class="text-primary">Welcome Back {{ auth()->user()->user_type }}!</h5>
                    <p>to {{ application('name')}}</p>
                </div>
            </div>
            <div class="col-5 align-self-end">
                <img src="assets/images/profile-img.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-sm-8">
                <div data-simplebar style="max-height: 230px;">
                    <a href="{{ route('teams.create') }}" class="text-reset notification-item">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                    <i class="bx bx-dialpad"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1" key="t-your-order">{{ __('Create New Team') }}</h6>
                            </div>
                        </div>
                    </a>

                    <!-- Team Switcher -->
                    @if( Auth::user()->isTeamOwner() )
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ Auth::user()->currentTeam->name }}
                    </div>
                    @endif

                </div>
            </div>

            <div class="col-sm-4">

            </div>
        </div>
    </div>
</div>