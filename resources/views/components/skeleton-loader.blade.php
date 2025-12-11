<!-- Skeleton Loader Component -->
<div class="skeleton-loader">
    <!-- Stats Cards Skeleton -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @for($i = 0; $i < 4; $i++)
        <div class="rounded-2xl shadow-lg bg-white relative overflow-hidden p-5">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="skeleton-line w-20 h-3 mb-2"></div>
                    <div class="skeleton-line w-32 h-4 mb-3"></div>
                    <div class="skeleton-line w-16 h-8"></div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="skeleton-circle w-3 h-3"></div>
                    <div class="skeleton-circle w-3 h-3"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Table Skeleton -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Table Header -->
        <div class="bg-gray-50 px-4 py-3 border-b">
            <div class="grid grid-cols-6 gap-4">
                @for($i = 0; $i < 6; $i++)
                <div class="skeleton-line w-20 h-4"></div>
                @endfor
            </div>
        </div>
        
        <!-- Table Rows -->
        @for($row = 0; $row < 8; $row++)
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="grid grid-cols-6 gap-4 items-center">
                <div class="skeleton-line w-16 h-4"></div>
                <div class="skeleton-line w-48 h-4"></div>
                <div class="skeleton-line w-32 h-4"></div>
                <div class="skeleton-line w-36 h-4"></div>
                <div class="skeleton-line w-24 h-4"></div>
                <div class="skeleton-line w-8 h-4"></div>
            </div>
        </div>
        @endfor
    </div>
</div>

<!-- Quick Actions Skeleton -->
<div class="mt-8">
    <div class="mb-6 pb-4 border-b-2 border-gray-200">
        <div class="skeleton-line w-48 h-8 mb-2"></div>
        <div class="skeleton-line w-64 h-4"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @for($i = 0; $i < 4; $i++)
        <div class="bg-white p-5 rounded-xl border shadow-md">
            <div class="flex items-center">
                <div class="skeleton-circle w-12 h-12 mr-4"></div>
                <div class="flex-1">
                    <div class="skeleton-line w-24 h-4 mb-2"></div>
                    <div class="skeleton-line w-32 h-3"></div>
                </div>
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