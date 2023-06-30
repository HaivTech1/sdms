<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === application('name'))
<img src="{{ asset('storage/'.application('image')) }}" class="logo" alt="{{ application('name') }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
