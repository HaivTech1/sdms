<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Contestant</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">
                    Create
                </li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ route('contestant.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="name" value="{{ __('Name') }}" />
                                        <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                            id="name" :value="old('name')" autofocus />
                                        <x-form.error for="name" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="email" value="{{ __('Email') }}" />
                                        <x-form.input id="email" class="block w-full mt-1" type="email" name="email"
                                            id="email" :value="old('email')" autofocus />
                                        <x-form.error for="email" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="dob" value="{{ __('Date of Birth') }}" />
                                        <x-form.input id="dob" class="block w-full mt-1" type="date" name="dob" id="dob"
                                            :value="old('dob')" autofocus />
                                        <x-form.error for="dob" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="state" value="{{ __('State') }}" />
                                        <x-form.input id="state" class="block w-full mt-1" type="text" name="state"
                                            id="state" :value="old('state')" autofocus />
                                        <x-form.error for="state" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="mobile_no" value="{{ __('Mobile Telephone Number ') }}" />
                                        <x-form.input id="mobile_no" class="block w-full mt-1" type="tel"
                                            name="mobile_no" id="mobile_no" :value="old('mobile_no')" autofocus />
                                        <x-form.error for="mobile_no" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="height" value="{{ __('Height') }}" />
                                        <x-form.input id="height" class="block w-full mt-1" type="text" name="height"
                                            id="height" :value="old('height')" autofocus />
                                        <x-form.error for="height" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="waist" value="{{ __('Waist') }}" />
                                        <x-form.input id="waist" class="block w-full mt-1" type="text" name="waist"
                                            id="waist" :value="old('waist')" autofocus />
                                        <x-form.error for="waist" />
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <x-form.label for="image" value="{{ __('Images') }}" />
                                        <x-form.input id="image" class="block w-full mt-1" type="file" name="image[]"
                                            accept="image/*" multiple />
                                        <x-form.error for="image" />
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <x-form.label for="desc" value="{{ __(' Description') }}" />
                                        <textarea class="form-control" id="desc" rows="5" name="description"
                                            value="old('description')" placeholder=" Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>