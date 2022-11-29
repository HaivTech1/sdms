@component('mail::message')
A new payment has just been made with transaction id =  **{{ $payment->transactionId() }}**

@component('mail::panel')
**Reference Number:** {{ $payment->referenceId() }} <br />
**Amount:** {{ trans('global.naira') }}{{ number_format($payment->amount(), 2) }} <br>
**Balance:** {{ trans('global.naira') }}{{ number_format($payment->balance(), 2) }} <br>
**Paid by:** {{ $payment->paidBy() }} <br>
@php
    $student = \App\Models\Student::findOrFail($payment->student_uuid);
@endphp
**Class:** {{ $student->grade->title() }}
@endcomponent

@component('mail::button', ['url' => route('payment.index')])
View payments
@endcomponent

Thanks,
{{ application('name') }}
@endcomponent
