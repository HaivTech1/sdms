<x-app-layout>
    @section('title', application('name') . ' | Student School Fees')
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Fees</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Assigned Fees</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Term</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($fees as $key => $fee)
                                @php
                                    $verification = \App\Models\Payment::whereTerm_id($fee['term_id'])->orWhere('student_uuid', $user->student->id())->first();
                                    $term = \App\Models\Term::findOrFail($fee['term_id']);
                                @endphp
                                <tr>
                                    <td>{{ $key +1 }}.</td>
                                    <td>
                                        {{ $term->title() }}
                                    </td>
                                    <td> {{ trans('global.naira') }}  {{ number_format($fee['price'], 2) }}</td>
                                    <td>
                                        @if ($verification->amount() == $fee['price'])
                                            <span class="badge badge-soft-success">Paid</span>
                                        @elseif($verification->term_id == $fee['term_id'] && $verification->amount() < $fee['price'])
                                            <span class="badge badge-soft-danger">You have a balance of <b> {{ trans('global.naira') }}{{ $verification->payable() - $verification->amount() }}</b> to pay!</span>
                                            {{-- <form route="{{ route('pay') }}">
                                                @csrf
                                                <input type="hidden" name="metadata" value="{{ json_encode($array = ['invoiceId' => $fee->id]) }}" >
                                                <input type="hidden" name="email" value="{{Auth::user()->email}}">
                                                <input type="hidden" name="orderID" value="345">
                                                <input type="hidden" name="amount" value="{{$fee->total}}">
                                                <input type="hidden" name="currency" value="NGN">
                                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 
                                                <button type="submit" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-credit-card label-icon"></i> Pay</button>
                                            </form> --}}
                                        @else
                                            <form method="POST" route="{{ route('pay') }}">
                                                @csrf
                                                <input type="hidden" name="metadata" value="{{ json_encode($array = ['student_uuid' => $user->student->id(),
                                                                                                                     'term_id' => $fee['term_id'],
                                                                                                                     'author_id' => $user->id(),
                                                                                                                     'payable' => $fee['price'],
                                                                                                                    ]) }}">
                                                <input type="hidden" name="email" value="{{ $user->student->guardian->email()}}">
                                                <input type="hidden" name="amount" value="{{$fee['price']}}">
                                                <input type="hidden" name="currency" value="NGN">
                                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 
                                                <button type="submit" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-credit-card label-icon"></i> Pay Now</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>Total:</td>
                                <td> {{ trans('global.naira') }} {{ number_format($fees->sum('price'), 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-credit-card label-icon"></i> Pay All</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                
            })
        </script>
    @endsection --}}
</x-app-layout>
