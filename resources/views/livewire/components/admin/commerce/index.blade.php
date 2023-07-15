<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-search />
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="category">
                                                <option value=''>Select Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id() }}">{{ $category->title() }}</option>
                                                @endforeach
                                            </select>

                                        </div>


                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="sortBy">
                                                <option value=''>Sort By</option>
                                                <option value="asc">ASC</option>
                                                <option value="desc">DESC</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="orderBy">
                                                <option value=''>Order By</option>
                                                <option value="title">Title</option>
                                                <option value="price">Price</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="status">
                                                <option value=''>Status</option>
                                                <option value="1">Active</option>
                                                <option value="false">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button type="button" id="" class="btn btn-secondary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target=".categoryModal"><i
                                                        class="fa fa-plus"></i> Category</button>
                                                <button data-bs-toggle="modal" data-bs-target=".createProductModal"
                                                    type="button" id="" class="btn btn-primary btn-sm"><i
                                                        class="fa fa-plus"></i> Product</button>
                                            </div>
                                        </div>
                                    </div>
                                </diV>
                            </div>
                            @if ($selectedRows)
                                <div class="row mt-2">
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="activateAll" type="button"
                                                class="btn btn-outline-success w-sm">
                                                <i class="bx bx-check"></i>
                                                Activate All
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="deleteAll" type="button"
                                                class="btn btn-outline-danger w-sm">
                                                <i class="bx bx-trash"></i>
                                                Delete All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Active Products</p>
                                            <h4 class="mb-0">{{ $activeProducts }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">InActive Products</p>
                                            <h4 class="mb-0">{{ $inactiveProducts }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Products</p>
                                            <h4 class="mb-0">{{ count($products) }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-12'>
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
                                            <th class="align-middle"> </th>
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> Price </th>
                                            <th class="align-middle"> Category </th>
                                            <th class="align-middle"> Status </th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $product->id() }}"
                                                        type="checkbox" id="{{ $product->id() }}"
                                                        wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $product->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <img class="rounded-circle avatar-xs uploadImage"
                                                    data-id="{{ $product->id() }}"
                                                    src="{{ $product->image() ? asset('storage/'.$product->image()) : asset('noImage.png') }}"
                                                    alt="{{ $product->title() }}">
                                            </td>
                                            <td>
                                                {{ $product->title() }}
                                            </td>
                                            <td>
                                                {{ trans('global.naira') }}{{ number_format($product->price(), 2) }}
                                            </td>
                                            <td>
                                                {{ $product->category->title() }}
                                            </td>
                                            <td>
                                                @if ($product->status === true)
                                                <span class="badge badge-soft-success">Active</span>
                                                @else
                                                <span class="badge badge-soft-danger">In Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $product->id() }})"><i class="bx bx-trash"></i></button>
                                                    <button class="btn btn-sm btn-secondary editProduct"
                                                        data-id="{{ $product->id() }}"
                                                        data-title="{{ $product->title() }}"
                                                        data-price="{{ $product->price() }}"
                                                        data-quantity="{{ $product->quantity }}"
                                                        data-category="{{ $product->category->id }}"
                                                        data-description="{{ $product->description }}"
                                                        data-image="{{ $product->image }}"
                                                        data-speculations="{{ $product->speculations }}"
                                                    >
                                                        <i class="bx bx-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $products->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade categoryModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:components.admin.commerce.category.index>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade createProductModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="title" value="{{ __('Product Name') }}" />
                                    <x-form.input id="title" class="block w-full mt-1" type="text" name="title"
                                        id="title" placeholder="Product Name" :value="old('title')" autofocus />
                                    <x-form.error for="title" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="price" value="{{ __('Product price') }}" />
                                    <x-form.input class="block w-full mt-1"
                                        placeholder="{{ trans('global.naira') }} 50000" type="number" name="price"
                                        :value="old('price')" autofocus />
                                    <x-form.error for="price" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="quantity" value="{{ __('Product Quantity') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="8" type="number" name="quantity"
                                        :value="old('quantity')" autofocus />
                                    <x-form.error for="quantity" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="speculations" value="{{ __('Speculations') }}" />
                                    <x-form.input class="block w-full mt-1" placeholder="color:black red white, size:big large medium" type="text" name="speculations"
                                        :value="old('speculations')" autofocus />
                                    <x-form.error for="speculations" />
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="Category" value="{{ __('Product Category') }}" />
                                    <select class="form-control" name="category_id">
                                        <option>Select</option>
                                        @foreach ($categories as $id => $category)
                                        <option value="{{ $category->id }}">{{ $category->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="description" value="{{ __('Product Description') }}" />
                                    <textarea class="form-control" id="description" rows="5" name="description"
                                        value="old('description')" placeholder="Product Description"></textarea>
                                </div>

                            </div>

                            <div class="col-sm-6 mb-3" style="display: flex; justify-content: center">
                                <div>
                                    <label for="image" :value="__('Image')" name="image" />
                                    <div style="display: flex; align-items: center">
                                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <img id="image-preview2" src="{{ asset('noImage.png') }}" alt="" width="200"
                                                class="rounded-circle avatar-xl">
                                        </span>
                                        <label for="image2" class="cursor-pointer" style="margin-left: 20px">
                                            <svg style="width: 20px" class="text-gray-400" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            <span class="ml-2 text-sm leading-5 font-medium text-gray-700">Choose a
                                                image</span>
                                            <input id="image2" type="file" class="sr-only" name="image" accept="image/*"
                                                onchange="document.getElementById('image-preview2').src = window.URL.createObjectURL(this.files[0])">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="submitProduct" type="submit"
                                class="btn btn-secondary block waves-effect waves-light pull-right">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade editProductModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="product_title" class="modal-title">Update product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProduct" method="post" enctype="multipart/form-data">
                        @csrf

                        <input id="edit_product_id" name="product_id" type="hidden" />

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="title" value="{{ __('Product Name') }}" />
                                    <x-form.input id="edit_title" class="block w-full mt-1" type="text" name="title" placeholder="Product Name" :value="old('title')" autofocus />
                                    <x-form.error for="title" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="price" value="{{ __('Product price') }}" />
                                    <x-form.input class="block w-full mt-1" id="edit_price" type="number" name="price"
                                        :value="old('price')" autofocus />
                                    <x-form.error for="price" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="quantity" value="{{ __('Product Quantity') }}" />
                                    <x-form.input class="block w-full mt-1" id="edit_quantity" type="number" name="quantity"
                                        :value="old('quantity')" autofocus />
                                    <x-form.error for="quantity" />
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="speculations" value="{{ __('Speculations') }}" />
                                    <x-form.input class="block w-full mt-1" id="edit_speculations" type="text" name="speculations"
                                        :value="old('speculations')" autofocus />
                                    <x-form.error for="speculations" />
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form.label for="Category" value="{{ __('Product Category') }}" />
                                    <select class="form-control" id="edit_category_id" name="category_id">
                                        <option>Select</option>
                                        @foreach ($categories as $id => $category)
                                        <option value="{{ $category->id }}">{{ $category->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <x-form.label for="description" value="{{ __('Product Description') }}" />
                                    <textarea class="form-control" id="edit_description" rows="5" name="description"
                                        value="old('description')"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-3" style="display: flex; justify-content: center">
                                <div>
                                    <x-form.input style="display: none;" id="edit_product_image" class="block w-full mt-1" type="file" name="edit_product_image"/>
                                    <canvas style="border-radius: 5px; margin: 5px; width: 300px; height: 150px; border: 1px solid #000" id="edit_product_img_show" class="img-thumbnail img-response"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button id="updateProductButton" type="submit"
                                class="btn btn-secondary block waves-effect waves-light pull-right">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).on('submit', '#productForm', function (e) {
            e.preventDefault();

            let formData = new FormData($('#productForm')[0]);
            toggleAble('#submitProduct', true, 'Submitting...');
            var url = "{{ route('product.store') }}";

            $.ajax({
                method: "POST",
                url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done((res) => {
                toggleAble('#submitProduct', false);
                toastr.success(res.message, 'Success!');
                $('.createProductModal').modal('toggle');
                resetForm('#createProduct');
                setTimeout(function () {
                    window.location.reload()
                }, 1000);
            }).fail((err) => {
                console.log(err);
                toggleAble('#submitProduct', false);
                toastr.error(err.responseJSON.message, 'Failed!');
                let allErrors = Object.values(err.responseJSON.errors).map(el => (
                    el = `<li>${el}</li>`
                )).reduce((next, prev) => (next = prev + next));

                const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul>${allErrors}</ul>
                                            </div>
                                            `;

                $('.modalErrorr').html(setErrors);
            });
        });

        $('.editProduct').on('click', function(e){
            e.preventDefault();
            var button = $(this);
            toggleAble(button, true);

            var id = $(this).data('id');
            var title = $(this).data('title');
            var price = $(this).data('price');
            var quantity = $(this).data('quantity');
            var category = $(this).data('category');
            var status = $(this).data('status');
            var description = $(this).data('description');
            var image = $(this).data('image');
            var speculations = $(this).data('speculations');

            toggleAble(button, false);

            var speculationsString = Object.keys(speculations).map(key => key + ':' + speculations[key].join(' ')).join(', ');

            document.getElementById("edit_product_id").value = id;
            document.getElementById("edit_title").value = title;
            document.getElementById("edit_price").value = price;
            document.getElementById("edit_quantity").value = quantity;
            document.getElementById("edit_category_id").value = category;
            document.getElementById("edit_description").innerText = description;
            document.getElementById("product_title").innerText = 'Update '+ title + ' details';
            document.getElementById("edit_speculations").value = speculationsString;

            var smallUrl = "{{ asset('storage/') }}" + '/' + image;
            loadImageToCanvas(smallUrl, 'edit_product_img_show');

            $('.editProductModal').modal('toggle');
        });

        $(document).on('submit', '#updateProduct', function(e){
            e.preventDefault();

            let formData = new FormData($('#updateProduct')[0]);
            toggleAble('#updateProductButton', true, 'Submitting...');
            var url = "{{ route('product.update') }}";

            $.ajax({
                method: "POST",
                url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
            }).done((res) => {
                toggleAble('#updateProductButton', false);
                toastr.success(res.message, 'Success!');
                $('.editProductModal').modal('toggle');
                setTimeout(function () {window.location.reload()}, 1000);
            }).fail((err) => {
                console.log(err);
                toggleAble('#updateProductButton', false);
                toastr.error(err.responseJSON.message, 'Failed!');
                let allErrors = Object.values(err.responseJSON.errors).map(el => (
                        el = `<li>${el}</li>`
                    )).reduce((next, prev) => ( next = prev + next ));

                const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>${allErrors}</ul>
                                    </div>
                                    `;

                $('.modalErrorr').html(setErrors);
            });
        });

        $('#edit_product_img_show').click(function() {
            $('#edit_product_image').click();
        });

        var editProductInput = document.querySelector('#edit_product_image');
        editproductInput.onchange = function() {
            var file = editProductInput.files[0];
            drawOnCanvas(file, 'edit_product_img_show');
        };

        function drawOnCanvas(file, canvasId) {
            var reader = new FileReader();
            var canvas = document.querySelector('#' + canvasId);
            var ctx = canvas.getContext('2d');
            var img = new Image();

            reader.onload = function(e) {
                var dataURL = e.target.result;

                $('#img-show-container').show();

                img.onload = function() {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                };

                img.src = dataURL;
            };

            reader.readAsDataURL(file);
        }

        function loadImageToCanvas(imageUrl, canvasId) {
            var canvas = document.querySelector('#' + canvasId);
            var ctx = canvas.getContext('2d');
            var img = new Image();

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
            };

            img.src = imageUrl;
        }
    </script>
@endsection
</div>