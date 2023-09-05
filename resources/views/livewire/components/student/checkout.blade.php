<div>
    @php
        $flutterData = \App\Models\Setting::where(['key' => 'flutterwave'])->first();
        $paystackData = \App\Models\Setting::where(['key' => 'paystack'])->first();
        $paystack = json_decode($paystackData['value'], true);
    @endphp
    <div class="checkout-tabs">
            <div class="row">
                <div class="col-xl-2 col-sm-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" id="v-pills-confir-tab" data-bs-toggle="pill" href="#v-pills-confir" role="tab" aria-controls="v-pills-confir" aria-selected="false">
                            <i class= "bx bx-badge-check d-block check-nav-icon mt-4 mb-2"></i>
                            <p class="fw-bold mb-4">Confirmation</p>
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-confir" role="tabpanel" aria-labelledby="v-pills-confir-tab">
                                    <div class="card shadow-none border mb-0">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Order Summary</h4>

                                            <div class="table-responsive">
                                                <table class="table align-middle mb-0 table-nowrap">
                                                    <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Product Desc</th>
                                                        <th scope="col">Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cartItems as $item)
                                                        <tr>
                                                            <th scope="row"><img src="{{ asset('storage/'.$item->product->image())}}" alt="{{ $item->product->title() }}" title="product-img" class="avatar-md"></th>
                                                            <td>
                                                                <h5 class="font-size-14 text-truncate"><a href="{{ route('user.product.show', $item->product->slug)}}" class="text-dark">{{ $item->product->title() }}</a></h5>
                                                                <p class="text-muted mb-0">{{ trans('global.naira')}} {{ number_format($item->product->price(), 2)}} x {{ $item->quantity}}</p>
                                                            </td>
                                                            <td>{{ trans('global.naira')}} {{ number_format($item->product->price() * $item->quantity, 2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2">
                                                            <h6 class="m-0 text-end">Total:</h6>
                                                        </td>
                                                        <td>
                                                            {{ trans('global.naira')}} {{ number_format($total, 2)}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <a href="{{ route('user.product.cart') }}" class="btn text-muted d-none d-sm-inline-block btn-link">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to Shopping Cart </a>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-end">
                                @if ($paystack['status'] == 1)
                                    <form action="{{ route('payment.order.pay') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="amount" value="{{($total) * 100 }}">
                                        <input type="hidden" name="currency" value="NGN">
                                        <input type="hidden" name="email" value="{{ auth()->user()->email()}}">
                                        <input type="hidden" name="metadata" value="{{ json_encode($array = [
                                                    'price' => $total,
                                                    'user_id' => auth()->id(),
                                                    'cartItems' => $items,
                                                ]) }}"
                                        >
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-credit-card me-1"></i> Make Payment
                                        </button> 
                                    </form>
                                @endif
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
    </div>
</div>
