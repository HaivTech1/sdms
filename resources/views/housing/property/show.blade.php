<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Property</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">{{ $property->title() }}</li>
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
                                            @foreach(json_decode($property->image, true) as $image)
                                            <a class="nav-link active" id="product-1-tab" data-bs-toggle="pill"
                                                href="#product-1" role="tab" aria-controls="product-1"
                                                aria-selected="true">
                                                <img src="{{  asset('storage/properties/'.$image) }}" alt=""
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
                                                    <img src="{{ asset('storage/properties/'. json_decode($property->image, true)[0]) }}"
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
                                <a href="javascript: void(0);" class="text-primary">{{ $property->category->name }}</a>
                                <h4 class="mt-1 mb-3">{{ $property->title() }}</h4>

                                <p class="text-muted mb-4">( {{ $property->reviewCount() }} Customers Review )</p>

                                <h5 class="mb-4">Price :
                                    <b>{{ trans('global.naira')}}
                                        {{ $property->price() }}</b>
                                </h5>
                                <p class="text-muted mb-4">{{ $property->description() }}</p>

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
                                        <th scope="row" style="width: 400px;">Property Id</th>
                                        <td>{{ $property->id() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Purpose</th>
                                        <td>{{ $property->purpose() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Frequency</th>
                                        <td>{{ $property->frequency() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 400px;">Category</th>
                                        <td>{{ $property->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Uploaded by</th>
                                        <td>{{ $property->author()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Built</th>
                                        <td>{{ $property->built() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address</th>
                                        <td>{{ $property->address() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Coordinated</th>
                                        <td>
                                            @if($property->longitude() && $property->latitude())
                                            {{ $property->longitude() }} (lng) / {{ $property->latitude() }} (lat)
                                            @else
                                            ---
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Bedroom</th>
                                        <td>{{ $property->bedroom() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Bathroom</th>
                                        <td>{{ $property->bathroom() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Furnished</th>
                                        <td>
                                            @if ($property->furnish == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Swimming Pool</th>
                                        <td>
                                            @if ($property->pool == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Wifi</th>
                                        <td>@if ($property->wifi == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Car park</th>
                                        <td>
                                            @if ($property->park == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tiles</th>
                                        <td>
                                            @if ($property->tiles == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Air Conditioning</th>
                                        <td>
                                            @if ($property->conditioning == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fence</th>
                                        <td>
                                            @if ($property->fence == true)
                                            <i class="bx bx-check-circle"></i>
                                            @else
                                            <i class="dripicons-cross"></i>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end Specifications -->

                    <div class="mt-5">
                        <h5>Reviews :</h5>

                        <div class="row">
                            @foreach($property->reviews as $review)

                            <div class="col-md-12">
                                <div class="d-flex py-3 border-bottom">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ asset('storage'. $review->author()->profile_photo_url) }}"
                                            class="avatar-xs rounded-circle" alt="img" />
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 font-size-15">{{ $review->author()->name() }}</h5>
                                        <p class=" text-muted">{{ $review->message }}</p>
                                        <ul class="list-inline float-sm-end mb-sm-0">
                                            <li class="list-inline-item">
                                                <a href="javascript: void(0);"><i class="far fa-thumbs-up me-1"></i>
                                                    Publish</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript: void(0);"><i class="fa fa-trash"></i>
                                                    Delete</a>
                                            </li>
                                        </ul>
                                        <div class="text-muted font-size-12"><i
                                                class="far fa-calendar-alt text-primary me-1"></i>
                                            {{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
</x-app-layout>