<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Product</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $product->title() }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="product-detai-imgs">
                                <div class="row">
                                    <div class="col-md-2 col-sm-3 col-4">
                                        <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            @foreach($product->image() as $image)
                                            <a class="nav-link active" id="product-1-tab" data-bs-toggle="pill"
                                                href="#product-1" role="tab" aria-controls="product-1"
                                                aria-selected="true">
                                                <img src="{{  asset('storage/products/'.$image) }}" alt=""
                                                    class="img-fluid mx-auto d-block rounded">
                                            </a>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="product-1" role="tabpanel"
                                                aria-labelledby="product-1-tab">
                                                <div>
                                                    <img src="{{ asset('storage/products/'. $product->image()[0]) }}"
                                                        alt="hdfdhdfjf" class="img-fluid mx-auto d-block">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mt-4 mt-xl-3">
                                <a href="javascript: void(0);" class="text-primary">{{ $product->category->name() }}</a>
                                <h4 class="mt-1 mb-3">{{ $product->title() }}</h4>

                                <p class="text-muted mb-4">( 0 Customers Review )</p>

                                <h5 class="mb-4">Price :
                                    <b>{{ trans('global.naira')}}
                                        {{ $product->price() }}</b>
                                </h5>
                                <p class="text-muted mb-4">{{ $product->description() }}</p>

                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="mt-5">
                        <h5 class="mb-3">Specifications :</h5>

                        <div class="table-responsive">
                            <table class="table mb-0 table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 400px;">Product Id</th>
                                        <td>{{ $product->id() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 400px;">Product Brand</th>
                                        <td>{{ $product->brand() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 400px;">Product Category</th>
                                        <td>{{ $product->category->name() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 400px;">Product qty</th>
                                        <td>{{ $product->quantity() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 400px;">Product Discount</th>
                                        <td>
                                            @if(!$product->discount() === 'null')
                                            {{ $product->discount() }}
                                            @else
                                            No discount
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end Specifications -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
</x-app-layout>