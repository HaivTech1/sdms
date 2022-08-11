@component('mail::message')
Booking: **{{ $booking->id() }}**, has just been accepted.

@component('mail::panel')
You can proceed to make payment on your dashboard by clicking the pay now button in the **action** dropdown. If you have
any complain about the property please call {{ application('name') }}
customer care line on <a href="tel:+{{ application('line1') }}">{{ application('line1') }}</a> or email us at <a
    href="mailto:{{ application('email') }}">{{ application('email') }}</a>.

Please be informed that your booking: **{{ $booking->id() }}** contains logistics and cleaning services
which {{ application('name') }} offers completely out of the box so as to ease your stress
of moving to a new home; we transport your loads and do a thorough cleaning of the
environment before you move in. Feel free to remove it before making payment if you don't find it necessary.

@endcomponent

Thanks,
Team {{ application('name') }}, {{ date('Y') }}.
@endcomponent