<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Edit</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $property->title() }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ route('property.update', $property)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="title" value="{{ __('Property Title') }}" />
                                    <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                        id="title" placeholder="Property Name" :value="old('title', $property->title())"
                                        autofocus />
                                    <x-form.error for="title" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="built" value="{{ __('Property built') }}" />
                                    <x-form.input id="built" class="block w-full mt-1" type="date" name="built"
                                        id="built" :value="old('built',$property->built)" autofocus />
                                    <x-form.error for="built" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="price" value="{{ __('Property price') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="{{ trans('global.naira') }}"
                                        type="text" name="price" :value="old('price', $property->price())" autofocus />
                                    <x-form.error for="price" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="purpose" value="{{ __('purpose') }}" />
                                    <select class="form-control select2" name="purpose">
                                        <option>Select</option>
                                        <option value="for-rent" @if($property->purpose() === 'for-rent') selected
                                            @endif>For rent</option>
                                        <option value="for-sale" @if($property->purpose() === 'for-sale') selected
                                            @endif >For Sale</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="frequency" value="{{ __('Rent Frequency') }}" />
                                    <select class="form-control" name="frequency">
                                        <option>Select</option>
                                        <option value="monthly" @if($property->frequency() === 'Monthly') selected
                                            @endif>Monthly</option>
                                        <option value="yearly" @if($property->frequency() === 'Yearly') selected
                                            @endif>Yearly</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="bedroom" value="{{ __('Bedroom') }}" />
                                    <select class="form-control select2" name="bedroom">
                                        <option>Select</option>
                                        <option value="">&nbsp;</option>
                                        <option value="1" @if($property->bedroom === '1') selected @endif>1</option>
                                        <option value="2" @if($property->bedroom === '2') selected @endif>2</option>
                                        <option value="3" @if($property->bedroom === '3') selected @endif>3</option>
                                        <option value="4" @if($property->bedroom === '4') selected @endif>4</option>
                                        <option value="5" @if($property->bedroom === '5') selected @endif>5</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="bathroom" value="{{ __('Bathroom') }}" />
                                    <select class="form-control select2" name="bathroom">
                                        <option>Select</option>
                                        <option value="">&nbsp;</option>
                                        <option value="1" @if($property->bathroom === '1') selected @endif>1</option>
                                        <option value="2" @if($property->bathroom === '2') selected @endif>2</option>
                                        <option value="3" @if($property->bathroom === '3') selected @endif>3</option>
                                        <option value="4" @if($property->bathroom === '4') selected @endif>4</option>
                                        <option value="5" @if($property->bathroom === '5') selected @endif>5</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <x-form.label for="Category" value="{{ __('Property Category') }}" />
                                    <select class="form-control" name="category">
                                        <option>Select</option>
                                        @foreach ($categories as $id => $category)
                                        <option value="{{ $id }}" @if($property->property_category_id === $id) selected
                                            @endif>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="productdesc" value="{{ __('Property Description') }}" />
                                    <textarea class="form-control" id="productdesc" rows="5" name="description"
                                        placeholder="Property Description">{{ $property->description }}</textarea>
                                </div>

                            </div>

                            <div class="col-sm-6 mt-3">
                                <h3>Location</h3>

                                <div class="mb-3">
                                    <x-form.label for="address" value="{{ __('Property Address') }}" />
                                    <x-form.input id="address" class="block w-full mt-1" placeholder="address"
                                        type="text" name="address" :value="old('address', $property->address)"
                                        autofocus />
                                    <x-form.error for="address" />
                                </div>
                                <div class="mb-3">
                                    <x-form.label for="longitude" value="{{ __('Property Longitude') }}" />
                                    <x-form.input id="longitude" class="block w-full mt-1" placeholder="longitude"
                                        type="text" name="longitude" :value="old('longitude', $property->longitude)"
                                        autofocus />
                                    <x-form.error for="longitude" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="latitude" value="{{ __('Property Latitude') }}" />
                                    <x-form.input id="latitude" class="block w-full mt-1" placeholder="latitude"
                                        type="text" name="latitude" :value="old('latitude', $property->latitude)"
                                        autofocus />
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
                                    <ul class="no-ul-list third-row">
                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="fence" name="fence"
                                                    @if($property->fence) checked @endif>
                                                <label class="form-check-label" for="fence">
                                                    Fenced
                                                </label>
                                            </div>

                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="wifi" name="wifi"
                                                    @if($property->wifi) checked @endif>
                                                <label class="form-check-label" for="wifi">
                                                    Wifi
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="tiles" name="tiles"
                                                    @if($property->tiles) checked @endif>
                                                <label class="form-check-label" for="tiles">
                                                    Tiles
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="park" name="park"
                                                    @if($property->park) checked @endif>
                                                <label class="form-check-label" for="park">
                                                    Park
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="conditioning"
                                                    @if($property->conditioning) checked @endif
                                                name="conditioning">
                                                <label class="form-check-label" for="conditioning">
                                                    Air conditioning
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="pool" name="pool"
                                                    @if($property->pool) checked @endif>
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