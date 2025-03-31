{{-- resources/views/vendor/pagination/custom-pagination.blade.php --}}
@if ($paginator->hasPages())
    <div class="flex justify-between items-center">
        <!-- Muestra la cantidad de items -->
        <div class="text-gray-700">
            Mostrando {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} de {{ $paginator->total() }}
        </div>
        
        <!-- Paginación -->
        <nav class="inline-flex -space-x-px">
            @if ($paginator->onFirstPage())
                <span class="px-2 py-2 text-gray-500 bg-transparent  border-gray-300 cursor-not-allowed">«</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-2 py-2 text-gray-300 bg-transparent hover:text-[#17bc9a]">«</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-2 text-gray-300 bg-transparent">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 text-[#17bc9a]">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-2 py-2 text-gray-500  hover:text-[#17bc9a]">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-2 text-gray-600 bg-transparent  hover:text-[#17bc9a]">»</a>
            @else
                <span class="px-2 py-2 text-gray-600  cursor-not-allowed">»</span>
            @endif
        </nav>
    </div>
@endif
