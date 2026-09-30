@if ($paginator->hasPages())
    <div class="pagination-wrap" role="navigation" aria-label="Navigasi halaman">
        <p class="pagination-info">
            Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }}
            dari {{ $paginator->total() }} data
        </p>

        <ul class="pagination">
            {{-- Tombol sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li><span class="disabled">&laquo; Sebelumnya</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="disabled">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="active">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol berikutnya --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &raquo;</a></li>
            @else
                <li><span class="disabled">Berikutnya &raquo;</span></li>
            @endif
        </ul>
    </div>
@endif
