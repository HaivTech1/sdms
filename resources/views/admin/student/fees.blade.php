<x-app-layout>
    @section('title', application('name') . ' | Student School Fees')
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Fees</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Assigned Fees for {{ period('title') }}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @if(auth()->user()->student->outstanding !== null)
                    <div class="card-header">
                        <div class="">
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Alert!</h4>
                                <p>
                                    We are sorry to inform you that you still have an outstanding of 
                                    {{ trans('global.naira') }} {{ number_format(auth()->user()->student->outstanding['outstanding'], 2) }}. 
                                    Please endeavour to pay your outstanding balance as soon as possible. Thank you!
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-body">
                    @if ($fee)
                        <table class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Term</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $verification = \App\Models\Payment::whereTerm_id($fee['term_id'])->where('student_uuid', $user->student->id())->first();
                                    $term = \App\Models\Term::findOrFail($fee['term_id']);
                                @endphp

                                <tr>
                                    <td>
                                        {{ $term->title() }} Tuition
                                    </td>
                                    <td> 
                                        @php
                                            $newFee = $fee['price'];
                                            $feeOut = auth()->user()->student->outstanding['outstanding'] ?? 0;
                                            $toPay = $newFee + $feeOut;
                                        @endphp
                                        {{ trans('global.naira') }}  
                                        {{ $verification ? $fee['price'] : number_format($toPay, 2) }}
                                    </td>
                                    <td>
                                        @if($verification && $verification->amount() == $verification->payable() && $verification->type === 'full')
                                            <span class="badge badge-soft-success">Paid</span>
                                        @elseif($verification && $verification->term_id == $fee['term_id'] && $verification->type === 'partial')

                                            @php
                                                $leftOver = $verification->payable() - $verification->amount();
                                            @endphp
                                            <span class="badge badge-soft-danger">You have a balance of <b> {{ trans('global.naira') }}{{ $leftOver }}</b> to pay!</span>
                                            <form method="POST" action="{{ route('pay') }}">
                                                @csrf
                                                <input type="hidden" name="metadata" value="{{ json_encode($array = [
                                                                                                                        'student_uuid' => $user->student->id(),
                                                                                                                        'term_id' => $fee['term_id'],
                                                                                                                        'author_id' => $user->id(),
                                                                                                                        'initial' => $newFee,
                                                                                                                        'payable' =>  $verification->payable(),
                                                                                                                        'old_payment' => $verification->amount(),
                                                                                                                        'old_payment_id' => $verification->id()
                                                                                                                    ])
                                                                                            }}">
                                                @if(isset($student->mother))
                                                    <input type="hidden" name="email" value="{{ $user->student->mother->email()}}">
                                                @elseif(isset($user->student->father))
                                                    <input type="hidden" name="email" value="{{ $user->student->father->email()}}">
                                                @else
                                                    <input type="hidden" name="email" value="{{ application('email')}}">
                                                @endif
                                                <input type="hidden" name="amount" value="{{($leftOver) * 100 }}">
                                                <input type="hidden" name="currency" value="NGN">
                                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"/>
                                                <button type="submit" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-credit-card label-icon"></i> Pay Now</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('pay') }}">
                                                @csrf
                                                <input type="hidden" name="metadata" value="{{ json_encode($array = ['student_uuid' => $user->student->id(),
                                                                                                                        'term_id' => $fee['term_id'],
                                                                                                                        'author_id' => $user->id(),
                                                                                                                        'payable' => $toPay,
                                                                                                                        'initial' => $newFee,
                                                                                                                        'old_payment' => false,
                                                                                                                        'old_payment_id' => false
                                                                                                                    ]) }}">
                                                @if(isset($student->mother))
                                                    <input type="hidden" name="email" value="{{ $user->student->mother->email()}}">
                                                @elseif(isset($user->student->father))
                                                    <input type="hidden" name="email" value="{{ $user->student->father->email()}}">
                                                @else
                                                    <input type="hidden" name="email" value="{{ application('email')}}">
                                                @endif
                                                
                                                <input id="amount" type="hidden" name="amount" value="{{ $toPay * 100 }}">
                                                <input type="hidden" name="currency" value="NGN">
                                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"/> 

                                                <div class="btn-group btn-group-example mb-3" role="group">
                                                    <button id="pay" type="submit" class="btn btn-primary w-xs">Pay Full</button>
                                                    <button id="partial" type="button" class="btn btn-danger w-xs">Enter Amount</button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-center text-danger">No fee assigned yet! please check back</p>
                    @endif
                </div>
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
</x-app-layout>
