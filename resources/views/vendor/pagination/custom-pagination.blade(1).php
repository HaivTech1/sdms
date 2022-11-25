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
        <ul class="pagination pagination-rounded justify-content-end mb-2">
            @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link">Prev</a></li>
            @else
            <li class="page-item disabled" wire:click="previousPage"><a class="page-link"><i
                        class="mdi mdi-chevron-left"></i></a></li>
            @endif

            @foreach ($elements as $element)
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item" wire:click="gotoPage({{ $page }})"><a class="page-link active">{{ $page }}</a></li>
            @else
            <li wire:click="gotoPage({{ $page }})" class="page-item"><a class="page-link">{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            @if ($paginator->hasMorePages())
            <li wire:click="nextPage" class="page-item"><a class="page-link"> <i class="mdi mdi-chevron-right"></i></a>
            </li>
            @else
            <li><a class="page-link"> <i class="mdi mdi-chevron-right"></i></a></li>
            @endif
        </ul>
    </div>

</div>
@endif