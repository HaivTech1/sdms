@component('mail::message')
**{{ $booking->author()->name() }}** has just booked your property **{{ $booking->property->id() }}**
Login into your dashboard to verify booking.

@component('mail::panel')
order_id = {{ $booking->id() }}
@endcomponent

@component('mail::button', ['url' => route('booking.index')])
Bookings
@endcomponent

Thanks, <br />
Team {{ application('name') }}, {{ date('Y') }}.
@endcomponent