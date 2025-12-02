{{-- Line Chart Section (Monthly Views) --}}
<div class="mb-8 -mx-2 sm:-mx-4 lg:-mx-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4 px-2 sm:px-4 lg:px-6">
        <div>
            <h2 class="text-3xl font-bold text-[#26225C] mb-1">{{ $monthName ?? '' }} Research Views</h2>
            <p class="text-sm text-gray-600">Daily research views by type</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard', ['offset' => ($offset ?? 0) + 1]) }}" class="w-10 h-10 bg-gray-100 hover:bg-[#26225C] hover:text-white text-gray-700 rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                <span class="text-lg">&laquo;</span>
            </a>
            <a href="{{ route('admin.dashboard', ['offset' => max(0, ($offset ?? 0) - 1)]) }}" class="w-10 h-10 bg-gray-100 hover:bg-[#26225C] hover:text-white text-gray-700 rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                <span class="text-lg">&raquo;</span>
            </a>
        </div>
    </div>
    <div class="relative min-h-[450px] md:min-h-[550px] lg:min-h-[600px] w-full overflow-hidden bg-gray-50 rounded-xl p-2 md:p-3">
        <canvas id="monthlyViewsChart" data-chart='@json($chartData ?? [])'></canvas>
    </div>
</div>

<div class="mb-6 pb-4 border-b-2 border-[#FFC72C]">
    <h2 class="text-3xl font-bold text-[#26225C] mb-1">Analytics</h2>
    <p class="text-sm text-gray-600">Research insights and statistics</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h4 class="text-base font-semibold text-[#26225C] mb-5">Research by Department</h4>
        <div class="w-full" style="position: relative; height: 320px;">
            <canvas id="deptChart"></canvas>
        </div>
    </div>
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h4 class="text-base font-semibold text-[#26225C] mb-5">Top Programs (Student)</h4>
        <div class="w-full" style="position: relative; height: 320px;">
            <canvas id="programChart"></canvas>
        </div>
    </div>
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h4 class="text-base font-semibold text-[#26225C] mb-5">Most Viewed</h4>
        <div class="w-full" style="position: relative; height: 320px;">
            <canvas id="topViewedChart"></canvas>
        </div>
    </div>
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h4 class="text-base font-semibold text-[#26225C] mb-5">Most Downloaded</h4>
        <div class="w-full" style="position: relative; height: 320px;">
            <canvas id="topDownloadedChart"></canvas>
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
                
                const palette = {
                    student: { border: 'rgba(38, 34, 92, 1)', bg: 'rgba(38, 34, 92, 0.15)' },
                    faculty: { border: 'rgba(139, 92, 246, 1)', bg: 'rgba(139, 92, 246, 0.15)' },
                    thesis: { border: 'rgba(16, 185, 129, 1)', bg: 'rgba(16, 185, 129, 0.15)' },
                    dissertation: { border: 'rgba(239, 68, 68, 1)', bg: 'rgba(239, 68, 68, 0.15)' }
                };
                
                const datasets = [
                    { 
                        label: 'Student', 
                        data: chartData.map(d => d.student), 
                        borderColor: palette.student.border, 
                        backgroundColor: palette.student.bg, 
                        fill: true, 
                        tension: 0, 
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        borderWidth: 2
                    },
                    { 
                        label: 'Faculty', 
                        data: chartData.map(d => d.faculty), 
                        borderColor: palette.faculty.border, 
                        backgroundColor: palette.faculty.bg, 
                        fill: true, 
                        tension: 0, 
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        borderWidth: 2
                    },
                    { 
                        label: 'Thesis', 
                        data: chartData.map(d => d.thesis), 
                        borderColor: palette.thesis.border, 
                        backgroundColor: palette.thesis.bg, 
                        fill: true, 
                        tension: 0, 
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        borderWidth: 2
                    },
                    { 
                        label: 'Dissertation', 
                        data: chartData.map(d => d.dissertation), 
                        borderColor: palette.dissertation.border, 
                        backgroundColor: palette.dissertation.bg, 
                        fill: true, 
                        tension: 0, 
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        borderWidth: 2
                    },
                ];
                
                const chart = new Chart(lineCanvas.getContext('2d'), {
                    type: 'line',
                    data: { labels, datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { 
                                position: 'top',
                                labels: { 
                                    color: '#26225C',
                                    boxWidth: 14, 
                                    padding: 14, 
                                    font: { size: 13, weight: '500' },
                                    usePointStyle: true
                                }
                            },
                            tooltip: { 
                                backgroundColor: '#1f2937',
                                titleColor: '#ffffff',
                                bodyColor: '#E5E7EB',
                                cornerRadius: 8,
                                padding: 12,
                                callbacks: { 
                                    label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y}` 
                                } 
                            }
                        },
                        scales: {
                            x: { 
                                grid: { 
                                    display: true, 
                                    color: 'rgba(38, 34, 92, 0.08)', 
                                    borderDash: [4, 4],
                                    lineWidth: 0.5
                                }, 
                                ticks: { 
                                    color: '#6b7280',
                                    maxTicksLimit: window.innerWidth < 640 ? 5 : window.innerWidth < 1024 ? 8 : 12,
                                    font: { size: 12 }
                                }
                            },
                            y: { 
                                beginAtZero: true, 
                                grid: { 
                                    display: true, 
                                    color: 'rgba(38, 34, 92, 0.08)', 
                                    borderDash: [4, 4],
                                    lineWidth: 0.5
                                }, 
                                ticks: { 
                                    color: '#6b7280',
                                    precision: 0, 
                                    font: { size: 12 },
                                    padding: 10
                                }
                            }
                        },
                        layout: {
                            padding: { left: 0, right: 0, top: 10, bottom: 0 }
                        }
                    }
                });
                
                // Handle window resize
                window.addEventListener('resize', () => {
                    chart.resize();
                });
            } catch (e) { 
                console.error('Chart error:', e);
            }
        }

        const deptLabels = @json($chartDepartments ?? []);
        const deptCounts = @json($chartDepartmentCounts ?? []);
        const programLabels = @json($chartPrograms ?? []);
        const programCounts = @json($chartProgramCounts ?? []);
        const topViewed = @json($chartTopViewed ?? []);
        const topDownloaded = @json($chartTopDownloaded ?? []);

        const makeBar = (ctx, labels, data, color) => {
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Count',
                        data,
                        backgroundColor: color,
                        borderColor: color,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#ffffff',
                            bodyColor: '#E5E7EB',
                            cornerRadius: 6,
                            padding: 10
                        }
                    },
                    scales: { 
                        x: { 
                            grid: { 
                                display: false
                            },
                            ticks: { 
                                color: '#6b7280',
                                font: { size: 11 }, 
                                maxRotation: 45, 
                                minRotation: 0 
                            } 
                        },
                        y: { 
                            beginAtZero: true, 
                            grid: { 
                                display: true,
                                color: 'rgba(38, 34, 92, 0.08)',
                                borderDash: [4, 4],
                                lineWidth: 0.5
                            },
                            ticks: { 
                                color: '#6b7280',
                                precision: 0, 
                                font: { size: 11 },
                                padding: 10
                            } 
                        }
                    },
                    layout: { padding: { left: 0, right: 0, top: 5, bottom: 0 } }
                }
            });
        };

        const makeDualBar = (ctx, labels, views, downloads) => {
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        { 
                            label: 'Views', 
                            data: views, 
                            backgroundColor: 'rgba(38, 34, 92, 0.6)',
                            borderColor: 'rgba(38, 34, 92, 1)',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        { 
                            label: 'Downloads', 
                            data: downloads, 
                            backgroundColor: 'rgba(255, 199, 44, 0.6)',
                            borderColor: 'rgba(255, 199, 44, 1)',
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: { 
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'top',
                            labels: { 
                                color: '#26225C',
                                boxWidth: 14, 
                                padding: 12, 
                                font: { size: 12, weight: '500' },
                                usePointStyle: true
                            } 
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#ffffff',
                            bodyColor: '#E5E7EB',
                            cornerRadius: 6,
                            padding: 10
                        }
                    },
                    scales: { 
                        x: { 
                            grid: { display: false },
                            ticks: { 
                                color: '#6b7280',
                                font: { size: 11 }, 
                                maxRotation: 45, 
                                minRotation: 0 
                            } 
                        },
                        y: { 
                            beginAtZero: true,
                            grid: { 
                                display: true,
                                color: 'rgba(38, 34, 92, 0.08)',
                                borderDash: [4, 4],
                                lineWidth: 0.5
                            },
                            ticks: { 
                                color: '#6b7280',
                                precision: 0, 
                                font: { size: 11 },
                                padding: 10
                            } 
                        }
                    },
                    layout: { padding: { left: 0, right: 0, top: 5, bottom: 0 } }
                }
            });
        };

        const deptEl = document.getElementById('deptChart');
        if (deptEl && deptLabels.length) makeBar(deptEl, deptLabels, deptCounts, 'rgba(38, 34, 92, 0.6)');

        const programEl = document.getElementById('programChart');
        if (programEl && programLabels.length) makeBar(programEl, programLabels, programCounts, 'rgba(255, 199, 44, 0.6)');

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
