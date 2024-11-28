@if ($paginator->hasPages())
<nav class="pagination-container">
    <ul class="pagination justify-content-center">
        {{-- Trang đầu --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}">Đầu</a>
        </li>

        {{-- Trang trước --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                <i class="fa fa-chevron-left"></i>
            </a>
        </li>

        {{-- Hiển thị trang đầu tiên --}}
        <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
        </li>

        {{-- Hiển thị "..." nếu cần, và chỉ hiển thị nếu có hơn 2 trang --}}
        @if ($paginator->lastPage() > 2 && $paginator->currentPage() > 3)
        <li class="page-item">
            <span class="page-link">...</span>
        </li>
        @endif

        {{-- Các trang giữa --}}
        @if ($paginator->lastPage() > 2)
        @foreach (range(max(2, $paginator->currentPage() - 1), min($paginator->currentPage() + 1, $paginator->lastPage()
        - 1)) as $page)
        <li class="page-item {{ $paginator->currentPage() == $page ? 'active' : '' }}">
            <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
        </li>
        @endforeach
        @endif

        {{-- Hiển thị "..." nếu cần và chỉ khi có hơn 2 trang --}}
        @if ($paginator->lastPage() > 2 && $paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item">
                <span class="page-link">...</span>
            </li>
            @endif

            {{-- Trang cuối --}}
            <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : '' }}">
                <a class="page-link"
                    href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>

            {{-- Trang tiếp theo --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    <i class="fa fa-chevron-right"></i>
                </a>
            </li>


            {{-- Trang cuối --}}
            <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Cuối</a>
            </li>

    </ul>
</nav>
@endif