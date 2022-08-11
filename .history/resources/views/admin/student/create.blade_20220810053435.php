<x-app-layout>
    @section('title', application('name') . ' | Student Page')
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Student</h4>

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

                    <form action="{{ route('property.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="first_name" value="{{ __('First Name') }}" />
                                    <x-form.input id="first_name" class="block w-full mt-1" type="text" name="first_name"
                                        :value="old('first_name')" id="first_name" placeholder="First Name" autofocus />
                                    <x-form.error for="first_name" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="last_name" value="{{ __('Last Name') }}" />
                                    <x-form.input id="last_name" class="block w-full mt-1" type="text" name="last_name"
                                        :value="old('last_name')" id="last_name" placeholder="First Name" autofocus />
                                    <x-form.error for="last_name" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="other_name" value="{{ __('Other Name') }}" />
                                    <x-form.input id="other_name" class="block w-full mt-1" type="text" name="other_name"
                                        :value="old('other_name')" id="other_name" placeholder="First Name" autofocus />
                                    <x-form.error for="other_name" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="gender" value="{{ __('Gender') }}" />
                                    <select class="form-control select2" name="gender" :value="old('purpose')">
                                        <option>Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="dob" value="{{ __('Date of Birth') }}" />
                                    <x-form.input id="dob" class="block w-full mt-1" type="date" name="dob"
                                        id="dob" autofocus />
                                    <x-form.error for="dob" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="nationality" value="{{ __('Nationality') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="{{ trans('global.naira') }}"
                                        type="text" name="nationality" :value="old('nationality')" autofocus />
                                    <x-form.error for="nationality" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="state_of_origin" value="{{ __('State of Origin') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="{{ trans('global.naira') }}"
                                        type="text" name="state_of_origin" :value="old('state_of_origin')" autofocus />
                                    <x-form.error for="state_of_origin" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="local_government" value="{{ __('Local Government') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="{{ trans('global.naira') }}"
                                        type="text" name="local_government" :value="old('local_government')" autofocus />
                                    <x-form.error for="local_government" />
                                </div>
                                
                            </div>

                            <div class="col-sm-6 mt-3">

                                <div class="mb-3">
                                    <x-form.label for="address" value="{{ __('Residential Address') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="Address"
                                        type="text" name="address" :value="old('address')" autofocus />
                                    <x-form.error for="address" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="prev_school" value="{{ __('Last Attended School') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder=""
                                        type="text" name="prev_school" :value="old('prev_school')" autofocus />
                                    <x-form.error for="prev_school" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="prev_class" value="{{ __('Previous Class') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="Basic 1"
                                        type="text" name="prev_class" :value="old('prev_class')" autofocus />
                                    <x-form.error for="prev_class" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="productdesc" value="{{ __('Property Description') }}" />
                                    <textarea class="form-control" id="productdesc" rows="5" name="description"
                                        value="old('description')" placeholder="Property Description"></textarea>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="productdesc" value="{{ __('Property Description') }}" />
                                    <textarea class="form-control" id="productdesc" rows="5" name="description"
                                        value="old('description')" placeholder="Property Description"></textarea>
                                </div>

                                <h3>Guardian</h3>

                                <div class="mb-3">
                                    <x-form.label for="address" value="{{ __('Property Address') }}" />
                                    <x-form.input id="address" class="block w-full mt-1" placeholder="address"
                                        type="text" name="address" :value="old('address')" autofocus />
                                    <x-form.error for="address" />
                                </div>
                                <div class="mb-3">
                                    <x-form.label for="longitude" value="{{ __('Property Longitude') }}" />
                                    <x-form.input id="longitude" class="block w-full mt-1" placeholder="longitude"
                                        type="text" name="longitude" :value="old('longitude')" autofocus />
                                    <x-form.error for="longitude" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="latitude" value="{{ __('Property Latitude') }}" />
                                    <x-form.input id="latitude" class="block w-full mt-1" placeholder="latitude"
                                        type="text" name="latitude" :value="old('latitude')" autofocus />
                                    <x-form.error for="latitude" />
                                </div>

                            </div>

                            <div class="col-sm-6 mt-3">
                                <h3>Media</h3>

                                <div class="mb-3">
                                    <x-form.label for="video" value="{{ __('Property video') }}" />
                                    <x-form.input id="video" class="block w-full mt-1" placeholder="video" type="file"
                                        name="video" :value="old('video')" autofocus />
                                    <x-form.error for="video" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="image" value="{{ __('Property Images') }}" />
                                    <x-form.input id="image" class="block w-full mt-1" placeholder="image" type="file"
                                        name="image[]" accept="image/*" multiple />
                                    <x-form.error for="image" />
                                </div>

                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Other Features (optional)</label>
                                <div class="o-features">
                                    <ul class="no-ul-list third-row" style="list-style-type: none">
                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="fence" name="fence">
                                                <label class="form-check-label" for="fence">
                                                    Fenced
                                                </label>
                                            </div>

                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="wifi" name="wifi">
                                                <label class="form-check-label" for="wifi">
                                                    Wifi
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="tiles" name="tiles">
                                                <label class="form-check-label" for="tiles">
                                                    Tiles
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="park" name="park">
                                                <label class="form-check-label" for="park">
                                                    Park
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="conditioning"
                                                    name="conditioning">
                                                <label class="form-check-label" for="conditioning">
                                                    Air conditioning
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="pool" name="pool">
                                                <label class="form-check-label" for="pool">
                                                    Swimming pool
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                Property</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    
</x-app-layout>
