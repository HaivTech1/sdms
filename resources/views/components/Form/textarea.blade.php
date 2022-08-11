@php
$classes = 'form-control';
@endphp

<textarea></textarea>
<div class="form-floating mb-3">
    <input type="text"
        {{ $attributes->merge(['class' => $classes, id="floatingnameInput", placeholder="start typing..."]) }}>
    <label for="floatingnameInput">{{ $slot }}</label>
</div>