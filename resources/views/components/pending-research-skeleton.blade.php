<!-- Pending Research Skeleton Loader -->
<div class="skeleton-loader">
    <!-- Header Skeleton -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="skeleton-line w-64 h-10 mb-2"></div>
            <div class="skeleton-line w-96 h-5"></div>
        </div>
    </div>

    <!-- Stats Cards Skeleton -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @for($i = 0; $i < 4; $i++)
        <div class="rounded-2xl shadow-lg bg-white relative overflow-hidden p-5">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="skeleton-line w-16 h-3 mb-2"></div>
                    <div class="skeleton-line w-24 h-4 mb-3"></div>
                    <div class="skeleton-line w-12 h-8"></div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="skeleton-circle w-3 h-3"></div>
                    <div class="skeleton-circle w-3 h-3"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Research Table Skeleton -->
    <div class="table-container overflow-x-auto bg-white rounded-xl">
        <!-- Table Header -->
        <div class="bg-gray-100 px-4 py-3 border-b">
            <div class="flex justify-between">
                <div class="skeleton-line w-12 h-4"></div>
                <div class="skeleton-line w-32 h-4"></div>
                <div class="skeleton-line w-24 h-4"></div>
                <div class="skeleton-line w-28 h-4"></div>
                <div class="skeleton-line w-20 h-4"></div>
                <div class="skeleton-line w-16 h-4"></div>
            </div>
        </div>
        
        <!-- Table Rows Skeleton -->
        @for($row = 0; $row < 10; $row++)
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div class="skeleton-line w-16 h-4"></div>
                <div class="skeleton-line w-48 h-4"></div>
                <div class="skeleton-line w-32 h-4"></div>
                <div class="skeleton-line w-36 h-4"></div>
                <div>
                    <div class="skeleton-line w-24 h-4 mb-1"></div>
                    <div class="skeleton-line w-20 h-3"></div>
                </div>
                <div class="skeleton-line w-4 h-4"></div>
            </div>
        </div>
        @endfor
    </div>
</div>

<style>
.skeleton-loader {
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
        opacity: .8;
    }
}
</style>