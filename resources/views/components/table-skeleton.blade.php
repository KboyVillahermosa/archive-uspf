<!-- Table Skeleton Loader -->
<div class="table-skeleton-loader">
    <div class="table-container overflow-x-auto bg-white rounded-xl">
        <!-- Table Header Skeleton -->
        <div class="bg-gray-100 px-4 py-3 border-b">
            <div class="grid grid-cols-6 gap-4">
                <div class="skeleton-line w-16 h-4"></div>
                <div class="skeleton-line w-24 h-4"></div>
                <div class="skeleton-line w-20 h-4"></div>
                <div class="skeleton-line w-28 h-4"></div>
                <div class="skeleton-line w-18 h-4"></div>
                <div class="skeleton-line w-16 h-4"></div>
            </div>
        </div>
        
        <!-- Table Rows Skeleton -->
        @for($row = 0; $row < 12; $row++)
        <div class="px-4 py-3 border-b border-gray-100" style="animation-delay: {{ $row * 0.1 }}s">
            <div class="grid grid-cols-6 gap-4 items-center">
                <div class="skeleton-line w-14 h-3"></div>
                <div class="skeleton-line w-44 h-3"></div>
                <div class="skeleton-line w-28 h-3"></div>
                <div class="skeleton-line w-32 h-3"></div>
                <div class="skeleton-line w-20 h-3"></div>
                <div class="skeleton-line w-6 h-3"></div>
            </div>
        </div>
        @endfor
    </div>
</div>

<style>
.table-skeleton-loader {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.skeleton-line, .skeleton-circle {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 0.375rem;
    display: inline-block;
}

.skeleton-circle {
    border-radius: 50%;
}

@keyframes shimmer {
    0% {
        background-position: -200% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .9;
    }
}

/* Staggered animation for table rows */
.table-skeleton-loader > .table-container > div:nth-child(n+2) {
    animation: shimmer 1.5s infinite;
}
</style>