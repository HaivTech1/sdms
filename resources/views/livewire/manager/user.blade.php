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
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">email</th>
                                    <th class="align-middle">Id</th>
                                    <th class="align-middle">Status</th>
                                    <th></th>
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
                                                src="{{ asset('storage/'.$user->image()) }}" alt="{{ $user->name() }}">
                                        </div>
                                    </td>
                                    <td>
                                        <livewire:components.edit-title :model='$user' field='name' :key='$user->id()'/>
                                    </td>
                                    <td>
                                            <livewire:components.edit-title :model='$user' field='email' :key='$user->id()'/>
                                    </td>
                                    <td>
                                        {{ $user->code() }}
                                    </td>
                                    <td>
                                        <livewire:components.toggle-button :model='$user'
                                                        field='isAvailable' :key='$user->id()' />
                                    </td>
                                   
                                    <td>
                                        <div class="px-2 py-1 text-center text-gray-700 bg-green-200 rounded">
                                            <select wire:change="changeUser({{$user}}, $event.target.value)"
                                                class="form-control w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="1" @if($user->type() === 1) selected @endif>Super Admin
                                                </option>
                                                <option value="2" @if($user->type() === 2) selected @endif>Admin
                                                </option>
                                                <option value="3" @if($user->type() === 3) selected @endif>teacher
                                                </option>
                                                <option value="4" @if($user->type() === 4) selected @endif>Student
                                                </option>
                                            </select>
                                        </div>
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