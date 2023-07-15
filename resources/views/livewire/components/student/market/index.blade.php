<div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4">Filter</h4>
                        @if ($category)
                            <span wire:click="clearCategoryFilter" class="text-danger text-lg cursor-pointer btn"><i class="bx bx-x"></i></span>
                        @endif
                    </div>

                    <div>
                        <h5 class="font-size-14 mb-3">Categories</h5>
                        <ul class="list-unstyled product-list">
                            @foreach ($categories as $category)
                                <li><a href="javascript: void(0);" wire:click='setCategory({{ $category->id() }})'><i class="mdi mdi-chevron-right me-1"></i>{{ $category->title() }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-lg-9">
                
            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6">
                    <div class="mt-2 d-flex align-items-center">
                        <h5>Products</h5> 
                        @if ($search)
                            <span wire:click="clearSearchFilter" class="text-danger text-lg cursor-pointer btn"><i class="bx bx-x"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                    <div class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                        <div class="search-box me-2">
                            <div class="position-relative">
                                <input type="text" class="form-control border-0" placeholder="Search..." wire:model.debounce.200ms="search">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-xl-4 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-img position-relative">
                                    <div class="avatar-sm product-ribbon">
                                        <span class="avatar-title rounded-circle  bg-primary">
                                            {{ $product->category->title()}}
                                        </span>
                                    </div>
                                    <a href="{{ route('user.product.show', $product->slug) }}"z>
                                        <img src="{{ asset('storage/'.$product->image()) }}" alt="" class="img-fluid mx-auto d-block">
                                    </a>
                                </div>
                                <div class="mt-4 text-center">
                                    <h5 class="mb-2 text-truncate"><a href="{{ route('user.product.show', $product->slug) }}" class="text-dark">{{ $product->title() }}</a></h5>
                                    <h5 class="my-0"><b>{{ trans('global.naira') }}{{ number_format($product->price, 2) }}</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    {{ $products->links('pagination::custom-pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
