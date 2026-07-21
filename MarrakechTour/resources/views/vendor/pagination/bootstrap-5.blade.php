@if ($paginator->hasPages())

<nav class="pagination-container d-flex justify-content-center mt-5">

    <ul class="pagination custom-pagination">

        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                    &lsaquo;
                </a>
            </li>
        @endif

        {{-- Pagination --}}
        @foreach ($elements as $element)

            {{-- "..."" --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif

            {{-- Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>

                    @else

                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>

                    @endif

                @endforeach
            @endif

        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    &rsaquo;
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">&rsaquo;</span>
            </li>
        @endif

    </ul>

</nav>

<style>

.pagination-container{
    margin-top:40px;
}

.custom-pagination{
    gap:8px;
}

.custom-pagination .page-item .page-link{

    border:none;
    border-radius:12px;
    min-width:42px;
    height:42px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#fff;
    color:#8B4513;
    font-weight:600;

    box-shadow:0 4px 10px rgba(0,0,0,.08);

    transition:.25s;

}

.custom-pagination .page-link:hover{

    background:#C96A2B;
    color:#fff;
    transform:translateY(-2px);

}

.custom-pagination .page-item.active .page-link{

    background:#C96A2B;
    color:#fff;

}

.custom-pagination .page-item.disabled .page-link{

    background:#ececec;
    color:#999;

}

@media (max-width:576px){

    .custom-pagination{

        gap:4px;
        flex-wrap:wrap;
        justify-content:center;

    }

    .custom-pagination .page-link{

        min-width:36px;
        height:36px;
        font-size:.9rem;

    }

}

</style>

@endif