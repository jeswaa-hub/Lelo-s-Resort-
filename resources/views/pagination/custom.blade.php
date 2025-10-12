@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- First 3 Pages --}}
            @foreach(range(1, min(3, $paginator->lastPage())) as $page)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Ellipsis ... --}}
            @if ($paginator->lastPage() > 4)
                @if ($paginator->currentPage() > 3 && $paginator->currentPage() < $paginator->lastPage())
                     @if ($paginator->currentPage() > 4)
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                     @endif
                    <li class="page-item active"><a class="page-link" href="{{ $paginator->url($paginator->currentPage()) }}">{{ $paginator->currentPage() }}</a></li>
                @endif
                 @if ($paginator->lastPage() - $paginator->currentPage() > 1)
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                 @endif
            @endif

            {{-- Last Page --}}
            @if ($paginator->lastPage() > 3)
                <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif