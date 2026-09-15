@props([
    'items' => null,
    'perPage' => 9,
    'currentPage' => 1,
    'total' => 0,
    'onPageChange' => null
])

@php
    $totalPages = ceil($total / $perPage);
    $showPages = 5;
    $halfShowPages = floor($showPages / 2);
    $startPage = max(1, $currentPage - $halfShowPages);
    $endPage = min($totalPages, $currentPage + $halfShowPages);
    
    if ($totalPages <= $showPages) {
        $startPage = 1;
        $endPage = $totalPages;
    } elseif ($endPage - $startPage + 1 < $showPages) {
        if ($startPage == 1) {
            $endPage = min($totalPages, $startPage + $showPages - 1);
        } elseif ($endPage == $totalPages) {
            $startPage = max(1, $endPage - $showPages + 1);
        }
    }
@endphp

@if ($totalPages > 1)
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
    <p class="text-xs text-gray-500">
        Menampilkan {{ (($currentPage - 1) * $perPage) + 1 }} - {{ min($currentPage * $perPage, $total) }} dari {{ $total }} data
    </p>
    
    <div class="flex items-center gap-1.5 flex-wrap justify-center">
        <!-- Previous -->
        @if ($currentPage > 1)
        <button type="button" 
                class="page-btn w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-[#006400] transition flex items-center justify-center"
                data-page="{{ $currentPage - 1 }}">
            <i class="fas fa-chevron-left text-xs"></i>
        </button>
        @else
        <button type="button" 
                class="w-9 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-300 cursor-not-allowed flex items-center justify-center" disabled>
            <i class="fas fa-chevron-left text-xs"></i>
        </button>
        @endif
        
        <!-- First Page -->
        @if ($startPage > 1)
        <button type="button" class="page-btn w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-[#006400] transition flex items-center justify-center text-sm font-medium" data-page="1">
            1
        </button>
            @if ($startPage > 2)
            <span class="px-1 text-gray-400">...</span>
            @endif
        @endif
        
        <!-- Pages -->
        @for ($i = $startPage; $i <= $endPage; $i++)
        <button type="button" 
                class="page-btn w-9 h-9 rounded-lg border transition flex items-center justify-center text-sm font-medium
                {{ $i == $currentPage 
                    ? 'bg-[#006400] text-white border-[#006400] shadow-sm' 
                    : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-[#006400]' }}"
                data-page="{{ $i }}">
            {{ $i }}
        </button>
        @endfor
        
        <!-- Last Page -->
        @if ($endPage < $totalPages)
            @if ($endPage < $totalPages - 1)
            <span class="px-1 text-gray-400">...</span>
            @endif
        <button type="button" class="page-btn w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-[#006400] transition flex items-center justify-center text-sm font-medium" data-page="{{ $totalPages }}">
            {{ $totalPages }}
        </button>
        @endif
        
        <!-- Next -->
        @if ($currentPage < $totalPages)
        <button type="button" 
                class="page-btn w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-[#006400] transition flex items-center justify-center"
                data-page="{{ $currentPage + 1 }}">
            <i class="fas fa-chevron-right text-xs"></i>
        </button>
        @else
        <button type="button" 
                class="w-9 h-9 rounded-lg border border-gray-200 bg-gray-50 text-gray-300 cursor-not-allowed flex items-center justify-center" disabled>
            <i class="fas fa-chevron-right text-xs"></i>
        </button>
        @endif
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const page = parseInt(this.dataset.page);
            if (window.paginationCallback && typeof window.paginationCallback === 'function') {
                window.paginationCallback(page);
            }
        });
    });
});
</script>
@endpush