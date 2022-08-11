<x-app-layout>
    @section('title', application('name')." | Create User")

    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">User</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="name" value="{{ __('Name') }}" />
                                        <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                            id="name" placeholder="Name" :value="old('name')" autofocus />
                                        <x-form.error for="name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="email" value="{{ __('Email') }}" />
                                        <x-form.input id="email" class="block w-full mt-1" type="text" name="email"
                                            id="email" placeholder="Email" :value="old('email')" autofocus />
                                        <x-form.error for="email" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="password" value="{{ __('Password') }}" />
                                        <input type="password" class="form-control" id="userpassword"
                                            placeholder="Enter password" name="password" required>
                                        <div class="invalid-feedback">
                                            Please Enter Password
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="password_confirmation"
                                            value="{{ __('confirm password') }}" />
                                        <input type="password" class="form-control" id="password_confirmation"
                                            placeholder="Enter confirmation password" name="password_confirmation"
                                            required>
                                        <div class="invalid-feedback">
                                            Please Confirm Password
                                        </div>
                                    </div>



                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="image" value="{{ __('Image') }}" />
                                        <x-form.input id="image" class="block w-full mt-1" placeholder="image"
                                            type="file" name="image" />
                                        <x-form.error for="image" />
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                User</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>