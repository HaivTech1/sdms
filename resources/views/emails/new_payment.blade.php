@component('mail::message')
A new payment has just been made by **{{ $payment->author()->name() }}** with transaction id =  **{{ $payment->trasactionId }}**

@component('mail::panel')
{{ $payment->referenceId() }}
**Amount:** {{ $payment->amount() }} <br>
**Transaction email:** {{ $payment->email() }} <br>
**Status:** 
@if ($payment->status_id == 1) <span class="text-danger">Unconfirmed</span> @else Confirmed @endif 
@endcomponent

@component('mail::button', ['url' => route('payment.index')])
View payments
@endcomponent

Thanks,
{{ application('name') }}
@endcomponent
