<div>
    @php
        $user = auth()->user();
    @endphp
     <div class='row'>
        <div class='col-sm-12'>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap table-check">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle"> Location </th>
                            <th class="align-middle"> Price </th>
                            <th class="align-middle"> Partial Payment </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $key => $trip)
                            @php
                                $payments = \App\Models\Payment::wherePayment_category('schoolbus_service')
                                    ->whereStudent_uuid($user->student->id())
                                    ->whereTerm_id(term('id'))
                                    ->wherePeriod_id(period('id'))->first();

                                $verify = calculateTotalAmount($payments);
                                $balance = calculateTripBalance($payments);
                            @endphp
                            <tr>
                                <td>
                                    {{ $trip->address() }}
                                </td>
                                <td>
                                    @if ($user->student->assingedTrip()->where('trip_id', $trip->id)->exists())
                                        @if ($balance)
                                           <span class="text-danger">To balance:</span> {{ trans('global.naira') }} {{ number_format($balance, 2) }}
                                        @else
                                            {{ trans('global.naira') }} {{ number_format($trip->price(), 2) }}
                                        @endif
                                    @else
                                        {{ trans('global.naira') }} {{ number_format($trip->price(), 2) }}
                                    @endif
                                </td>
                                <td>
                                    {{ $trip->split_status }}
                                </td>
                                <td>
                                    @if ($user->student->assingedTrip()->where('trip_id', $trip->id)->exists())
                                        @if ($balance)
                                             <form method="POST" action="{{ route('user.schoolbus.paystack.one-time') }}">
                                                    @csrf

                                                    <input type="hidden" name="metadata" 
                                                        value="{{ json_encode($array = [
                                                            'student_uuid' =>  $user->student->id(),
                                                            'term_id' => term('id'),
                                                            'period_id' => period('id'),
                                                            'author_id' => $user->id(),
                                                            'trip_id' => $trip->id(),
                                                            'type' => 'schoolbus_service',
                                                            'callback' => 'user.schoolbus.paystack.callback',
                                                        ]) }}"
                                                    >
                                                    @if(isset($user->student->mother))
                                                        <input type="hidden" name="email" value="{{ $user->student->mother->email()}}">
                                                    @elseif(isset($user->student->father))
                                                        <input type="hidden" name="email" value="{{ $user->student->father->email()}}">
                                                    @else
                                                        <input type="hidden" name="email" value="{{ application('email')}}">
                                                    @endif

                                                    <input id="amount" type="hidden" name="amount" value="{{ $balance ? ($balance) * 100 :($trip->price()) * 100 }}">
                                                    <input type="hidden" name="currency" value="NGN">

                                                    <button class="btn btn-success btn-sm" id="" type="submit">Pay balance</button>
                                                </form>
                                        @else
                                            <span class="badge badge-soft-success">Paid</span>
                                        @endif
                                    @else 
                                        @if (!$verify)
                                            <div class="d-flex gap-2">
                                                <form method="POST" action="{{ route('payment.paystack.initiate') }}">
                                                    @csrf

                                                    <input type="hidden" name="metadata" 
                                                        value="{{ json_encode($array = [
                                                            'student_uuid' =>  $user->student->id(),
                                                            'term_id' => term('id'),
                                                            'period_id' => period('id'),
                                                            'author_id' => $user->id(),
                                                            'trip_id' => $trip->id(),
                                                            'type' => 'schoolbus_service',
                                                            'callback' => 'payment.paystack.callback',
                                                        ]) }}"
                                                    >
                                                    @if(isset($user->student->mother))
                                                        <input type="hidden" name="email" value="{{ $user->student->mother->email()}}">
                                                    @elseif(isset($user->student->father))
                                                        <input type="hidden" name="email" value="{{ $user->student->father->email()}}">
                                                    @else
                                                        <input type="hidden" name="email" value="{{ application('email')}}">
                                                    @endif

                                                    <input id="amount" type="hidden" name="amount" value="{{ $balance ? ($balance) * 100 :($trip->price()) * 100 }}">
                                                    <input type="hidden" name="currency" value="NGN">

                                                    @if ($trip->split)
                                                        <div class="btn-group btn-group-example mb-3" role="group">
                                                            <button id="pay" type="submit" class="btn btn-success w-xs">Pay</button>
                                                            <button id="partial" type="button" class="btn btn-danger w-xs">Enter Amount</button>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-success btn-sm" id="" type="submit">Pay</button>
                                                    @endif
                                                </form>
                                            </div>
                                        @else
                                            <span class="badge badge-soft-danger">x</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $trips->links('pagination::custom-pagination') }}
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#partial').on('click', function() {
                     Swal.fire({
                        title:"Enter the amount to pay",
                        input:"text",
                        showCancelButton:!0,
                        confirmButtonText:"Submit",
                        showLoaderOnConfirm:!0,
                        confirmButtonColor:"#556ee6",
                        cancelButtonColor:"#f46a6a",
                        preConfirm:function(n){
                            var newAmount = n;
                            var x = document.getElementById("pay");
                                x.innerHTML = 'Pay';
                            var y = document.getElementById("amount");
                                y.value= newAmount * 100;
                        },
                        allowOutsideClick: !1,
                    });
                });
            })
        </script>
    @endsection
</div>
