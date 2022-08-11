@if ($paginator->hasPages())
<div class="shorting_pagination">

    <div class="shorting_pagination_laft">
        <h5 class="">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            {!! __('- to -') !!}
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
            {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </h5>
    </div>

    <div class="shorting_pagination_right">
        <ul>
            @if ($paginator->onFirstPage())
            <li><a>Prev</a></li>
            @else
            <li wire:click="previousPage"><a class="cursor-pointer">Prev</a></li>
            @endif

            @foreach ($elements as $element)
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li wire:click="gotoPage({{ $page }})" class="cursor-pointer"><a class="active">{{ $page }}</a></li>
            @else
            <li wire:click="gotoPage({{ $page }})" class="cursor-pointer"><a>{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            @if ($paginator->hasMorePages())
            <li wire:click="nextPage" class="cursor-pointer"><a>Next</a></li>
            @else
            <li><a>Next</a></li>
            @endif
        </ul>
    </div>

</div>
@endif