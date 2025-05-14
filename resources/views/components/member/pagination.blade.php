@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="btn btn-primary border-white disabled"><span>previous</span></li>
        @else
            <li><a class="btn btn-primary border-white" href="{{ $paginator->previousPageUrl() }}" rel="prev">previous</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a href="javascript:void(0)" class="btn btn-light border-white">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="btn btn-primary border-white">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="btn btn-primary border-white" rel="next">next</a></li>
        @else
            <li class="disabled"><a href="javascript:void(0)" class="btn btn-primary border-white">next</a></li>
        @endif
    </ul>
@endif