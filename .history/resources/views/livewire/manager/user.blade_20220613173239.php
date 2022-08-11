<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        @if($search)
                                        <div class="col-6">
                                            <button wire:click.prevent="resetSearch" type=" button"
                                                class="btn btn-danger waves-effect btn-label waves-light">
                                                <i class="bx bx-block label-icon "></i>
                                                clear search
                                            </button>
                                        </div>
                                        @endif
                                        @if($selectedRows)
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                                <button wire:click.prevent="disableAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-check-double"></i>
                                                    Disable All
                                                </button>
                                                <button wire:click.prevent="undisableAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-x-circle"></i>
                                                    Undisable All
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </diV>
                            </div>
                        </div>

                        <div class=" col-sm-4">
                            <div class="text-sm-end">
                                <a href="{{ route('user.create') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Add User</a>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20px;" class="align-middle">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                wire:model="selectPageRows">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th class="align-middle"></th>
                                    <th class="align-middle">User Name</th>
                                    <th class="align-middle">User email</th>
                                    <th class="align-middle">Account Status</th>
                                    <th class="align-middle">User Status</th>
                                    <th class="align-middle">User Points</th>
                                    <th class="align-middle">User Rank</th>
                                    <th></th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="{{ $user->id() }}" type="checkbox"
                                                id="{{ $user->id() }}" wire:model="selectedRows">
                                            <label class="form-check-label" for="{{ $user->id() }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <img class="rounded-circle avatar-xs"
                                                src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="text-body fw-bold">{{ $user->name() }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $user->email() }}</a>
                                    </td>
                                    <td>

                                        @if ($user->email_verified_at === null )
                                        <span class="badge badge-pill badge-soft-danger font-size-12">Not
                                            verified</span>
                                        @else
                                        <span class="badge badge-pill badge-soft-success font-size-12">Verified</span>
                                        @endif

                                    </td>
                                    <td>

                                        @if ($user->available_badge == 'Not Available' )
                                        <span class="badge badge-pill badge-soft-danger font-size-12">
                                            {{ $user->available_badge }}</span>
                                        @else
                                        <span class="badge badge-pill badge-soft-success font-size-12">
                                            {{ $user->available_badge }}</span>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="javascript: void(0);"
                                            class="text-body fw-bold">{{ $user->currentPoints() }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript: void(0);" class="text-body fw-bold">{{ $user->rank() }}</a>
                                    </td>
                                    <td>
                                        <div class="px-2 py-1 text-center text-gray-700 bg-green-200 rounded">
                                            <select wire:change="changeUser({{$user}}, $event.target.value)"
                                                class="form-control w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="1" @if($user->type() === 1) selected @endif>Admin
                                                </option>
                                                <option value="2" @if($user->type() === 2) selected @endif>Manager
                                                </option>
                                                <option value="3" @if($user->type() === 3) selected @endif>Writer
                                                </option>
                                                <option value="4" @if($user->type() === 4) selected @endif>Agent
                                                </option>
                                                <option value="5" @if($user->type() === 5) selected @endif>Default
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="dropdown-item" href="{{ route('user.show', $user) }}"><i
                                                class="fa fa-eye"></i></a>
                                        <a class="dropdown-item" href="{{ route('user.edit', $user) }}"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>