<x-app-layout>
    @section('title', $product->title()."")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Market place</h4>

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
                                    <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="product-1" role="tabpanel" aria-labelledby="product-1-tab">
                                                <div>
                                                    <img src="{{ asset('storage/'.$product->image())}}" alt="" class="img-fluid mx-auto d-block">
                                                </div>
                                            </div>
                                        </div>
                                        <livewire:components.student.add-to-cart :product="$product"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mt-4 mt-xl-3">
                                <a href="javascript: void(0);" class="text-primary">{{ $product->category->title() }}</a>
                                <h4 class="mt-1 mb-3">{{ $product->title() }}</h4>

                                <h5 class="mb-4">Price : <b>{{ trans('global.naira') }}{{ number_format($product->price, 2) }}</b></h5>
                                <p class="text-muted mb-4">
                                    {{ $product->description }}
                                </p>
                               
                                @if ($product->speculations)
                                    @php
                                        $specs = json_decode($product->speculations, true);
                                    @endphp

                                    @foreach($specs as $key => $values)
                                        <div class="product-color">
                                            <span class="font-size-15">Available {{ $key }}:</span>
                                            <b>{{ implode(', ', $values) }}</b>
                                        </div>
                                    @endforeach
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>