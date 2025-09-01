@component('mail::message')

<div class="relative w-100 mb4 bg-near-white">
    <div class="mb3 pa4 mid-gray overflow-hidden">
        <div class="f6"> {{date('D, M j, Y \a\t g:ia')}} </div>
        <h1 class="f3 near-black"> {{ucwords($subject)}} </h1>
        {!! $body ?? '' !!}
    </div>
</div>

<br>
Thanks,<br>
{{ application('name') }}
@endcomponent
