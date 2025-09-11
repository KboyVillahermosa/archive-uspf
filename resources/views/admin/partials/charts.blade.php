<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        {{-- Line Chart Section (Monthly Views) --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">{{ $monthName ?? '' }} Research Views</h2>
                <div class="flex justify-between space-x-4">
                    <a href="{{ route('admin.dashboard', ['offset' => ($offset ?? 0) + 1]) }}" class="bg-gray-100 text-gray-700 p-1 px-4 shadow rounded">
                        <span>&laquo;</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['offset' => max(0, ($offset ?? 0) - 1)]) }}" class="bg-gray-100 text-gray-700 p-1 px-4 shadow rounded">
                        <span>&raquo;</span>
                    </a>
                </div>
            </div>
            <div class="relative min-h-[300px] md:min-h-[400px]">
                <canvas id="monthlyViewsChart" data-chart='@json($chartData ?? [])'></canvas>
            </div>
        </div>

        <h3 class="text-lg font-semibold mb-4 text-gray-800">Analytics</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Research by Department</h4>
                <canvas id="deptChart" height="140"></canvas>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Top Programs (Student)</h4>
                <canvas id="programChart" height="140"></canvas>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Most Viewed</h4>
                <canvas id="topViewedChart" height="140"></canvas>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Most Downloaded</h4>
                <canvas id="topDownloadedChart" height="140"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function(){
        // Line chart setup
        const lineCanvas = document.getElementById('monthlyViewsChart');
        if (lineCanvas) {
            try {
                const chartData = JSON.parse(lineCanvas.dataset.chart || '[]');
                const labels = chartData.map(d => d.day);
                const datasets = [
                    { label: 'Student', data: chartData.map(d => d.student), borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.15)', fill: true, tension: 0, pointRadius: 0 },
                    { label: 'Faculty', data: chartData.map(d => d.faculty), borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,0.15)', fill: true, tension: 0, pointRadius: 0 },
                    { label: 'Thesis', data: chartData.map(d => d.thesis), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.15)', fill: true, tension: 0, pointRadius: 0 },
                    { label: 'Dissertation', data: chartData.map(d => d.dissertation), borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.15)', fill: true, tension: 0, pointRadius: 0 },
                ];
                new Chart(lineCanvas.getContext('2d'), {
                    type: 'line',
                    data: { labels, datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y}` } }
                        },
                        scales: {
                            x: { grid: { display: true, color: 'rgba(0,0,0,0.06)', borderDash: [4,4] }, ticks: { maxTicksLimit: 10 } },
                            y: { beginAtZero: true, grid: { display: true, color: 'rgba(0,0,0,0.06)', borderDash: [4,4] }, ticks: { precision: 0 } }
                        }
                    }
                });
            } catch (e) { /* ignore */ }
        }

        const deptLabels = @json($chartDepartments ?? []);
        const deptCounts = @json($chartDepartmentCounts ?? []);
        const programLabels = @json($chartPrograms ?? []);
        const programCounts = @json($chartProgramCounts ?? []);
        const topViewed = @json($chartTopViewed ?? []);
        const topDownloaded = @json($chartTopDownloaded ?? []);

        const makeBar = (ctx, labels, data, color) => new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Count',
                    data,
                    backgroundColor: color,
                    borderColor: color,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        const makeDualBar = (ctx, labels, views, downloads) => new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    { label: 'Views', data: views, backgroundColor: 'rgba(59,130,246,0.5)' },
                    { label: 'Downloads', data: downloads, backgroundColor: 'rgba(16,185,129,0.5)' }
                ]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        const deptEl = document.getElementById('deptChart');
        if (deptEl && deptLabels.length) makeBar(deptEl, deptLabels, deptCounts, 'rgba(244,63,94,0.5)');

        const programEl = document.getElementById('programChart');
        if (programEl && programLabels.length) makeBar(programEl, programLabels, programCounts, 'rgba(99,102,241,0.5)');

        const viewedEl = document.getElementById('topViewedChart');
        if (viewedEl && topViewed.length) {
            makeDualBar(viewedEl, topViewed.map(i=>i.label), topViewed.map(i=>i.views), topViewed.map(i=>i.downloads));
        }

        const downloadedEl = document.getElementById('topDownloadedChart');
        if (downloadedEl && topDownloaded.length) {
            makeDualBar(downloadedEl, topDownloaded.map(i=>i.label), topDownloaded.map(i=>i.views), topDownloaded.map(i=>i.downloads));
        }
    })();
</script>


