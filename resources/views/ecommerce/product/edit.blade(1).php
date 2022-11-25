<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Products</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $product->title() }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ route('product.update', $product)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="title" value="{{ __('Product Name') }}" />
                                    <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                        id="title" placeholder="Product Name" :value="old('title', $product->title())"
                                        autofocus />
                                    <x-form.error for="title" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="price" value="{{ __('Product price') }}" />
                                    <x-form.input class="block w-full mt-1"
                                        placeholder="{{ trans('global.naira') }} 50000" type="number" name="price"
                                        :value="old('title', $product->price())" autofocus />
                                    <x-form.error for="price" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="discount" value="{{ __('Product Discount') }}" />
                                    <x-form.input class="block w-full mt-1"
                                        placeholder="{{ trans('global.naira') }} 500" type="number" name="discount"
                                        :value="old('title', $product->discount())" autofocus />
                                    <x-form.error for="discount" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="brand" value="{{ __('Product Brand') }}" />
                                    <x-form.input id="brand" class="block w-full mt-1" type="text" name="brand"
                                        :value="old('title', $product->brand())" id="brand" placeholder="Product brand"
                                        autofocus />
                                    <x-form.error for="brand" />
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="qty" value="{{ __('Product Quantity') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="8" type="number" name="qty"
                                        :value="old('title', $product->quantity())" autofocus />
                                    <x-form.error for="qty" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="Category" value="{{ __('Product Category') }}" />
                                    <select class="form-control" name="category">
                                        <option>Select</option>
                                        @foreach ($categories as $id => $category)
                                        <option value="{{ $id }}" @if($product->product_category_id === $id) selected
                                            @endif>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="productdesc" value="{{ __('Product Description') }}" />
                                    <textarea class="form-control" id="productdesc" rows="5" name="description"
                                        placeholder="Product Description">{{ $product->description }}</textarea>
                                </div>

                            </div>

                            <div class="col-sm-6 mt-3">
                                <h3>Media</h3>

                                <div class="mb-3">
                                    <x-form.label for="image" value="{{ __('Product Images') }}" />
                                    <x-form.input id="image" class="block w-full mt-1" placeholder="image" type="file"
                                        name="image[]" accept="image/*" multiple />
                                    <x-form.error for="image" />
                                </div>

                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                Product</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>