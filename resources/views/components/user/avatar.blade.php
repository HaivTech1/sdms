@isset($user)
@php
$classes = 'img-fluid d-block rounded-circle';
@endphp

<a href="#">
    <img {{ $attributes->merge(['class' => $classes]) }} src="{{ asset('storage/'.$user->image()) }}" alt="{{ $user->name() }}">
</a>
@endisset
