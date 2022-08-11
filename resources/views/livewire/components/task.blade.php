<div>
    <x-loading />

    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-lg-4">
                            <x-search />
                        </div>

                        <div class="col-lg-8">
                            <div class="row">
                                @if($selectedRows)
                                <div class="col-6">
                                    @if( Auth::user()->isTeamOwner() )
                                    <div class="text-center">
                                        <div class="d-flex flex-wrap gap-3 align-items-center">
                                            <div class="btn-group-vertical" role="group"
                                                aria-label="Vertical button group">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupVerticalDrop1" type="button"
                                                        class="btn btn-primary" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                        <a class="dropdown-item"
                                                            wire:click.prevent="ApproveAll">Approved
                                                            Task</a>
                                                        <a class="dropdown-item"
                                                            wire:click.prevent="CompleteAll">Complete
                                                            Task</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </diV>
                    </div>
                </div>

                <div class=" col-sm-4">
                    <div class="text-sm-end">
                        <a href="{{ route('task.create') }}"
                            class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                class="mdi mdi-plus me-1"></i> Add Task</a>
                    </div>
                </div><!-- end col-->
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Upcoming</h4>

                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <tbody>
                                @forelse($waitings as $waiting)
                                <tr>
                                    <td style="width: 40px;">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $waiting->id() }}" type="checkbox"
                                                id="{{ $waiting->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="upcomingtaskCheck01"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="javascript: void(0);"
                                                class="text-dark">{{ $waiting->name() }}</a></h5>
                                    </td>
                                    <td>

                                        @foreach($waiting->team->users as $user)
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="{{ asset('storage/profile-photos/'. $user->profile_photo_path) }}"
                                                        alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span
                                                class="badge rounded-pill badge-soft-secondary font-size-11">{{ $waiting->status_badge }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-3 text-sm" colspan="2">
                                        Your team has no waiting tasks.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">In Progress</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <tbody>
                                @forelse($approveds as $approved)
                                <tr>
                                    <td style="width: 40px;">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $approved->id() }}"
                                                type="checkbox" id="{{ $approved->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="upcomingtaskCheck01"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="javascript: void(0);"
                                                class="text-dark">{{ $approved->name() }}</a></h5>
                                    </td>
                                    <td>

                                        @foreach($approved->team->users as $user)
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="{{ asset('storage/profile-photos/'. $user->profile_photo_path) }}"
                                                        alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span
                                                class="badge rounded-pill {{$approved->status_badge === 'Approved' ? 'badge-soft-warning' : 'badge-soft-secondary'}} font-size-11">{{ $approved->status_badge }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-3 text-sm" colspan="2">
                                        Your team has no progress tasks.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Completed</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <tbody>
                                @forelse($completeds as $completed)
                                <tr>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="javascript: void(0);"
                                                class="text-dark">{{ $completed->name() }}</a></h5>
                                    </td>
                                    <td>

                                        @foreach($completed->team->users as $user)
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="{{ asset('storage/profile-photos/'. $user->profile_photo_path) }}"
                                                        alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span
                                                class="badge rounded-pill {{$completed->status_badge === 'Completed' ? 'badge-soft-success' : 'badge-soft-secondary'}}  font-size-11">{{ $completed->status_badge }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-3 text-sm" colspan="2">
                                        Your team has no completed tasks.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>