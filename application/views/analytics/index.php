<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Analytics - SoundFlow</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#ff531a",
                        background: "#000000",
                        border: "#27272a",
                        muted: "#9ca3af",
                        card: "#111111"
                    }
                }
            }
        }
    </script>

    <style>
        #createProjectForm {
            max-height: 0;
            opacity: 0;
        }
    </style>
    <style>
        .tab {
            font-weight: 600;
            color: #9ca3af;
            border-bottom: 2px solid transparent;
        }

        .tab.active {
            color: #ff531a;
            border-bottom-color: #ff531a;
            /* 👈 underline */
        }
    </style>


    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-white min-h-screen text-black">

    <!-- Header -->
    <?php $this->view('page_header'); ?>


    <div class="container mx-auto px-6 py-8">

        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-6">Analytics</h1>
        </div>

        <!-- TOP TABS -->
        <!-- <div class="flex gap-6 mb-6">
            <button class="tab active" data-type="singles">Singles</button>
            <button class="tab" data-type="albums">Albums</button>
        </div> -->
        <!-- TOP TABS -->
        <div class="border-b border-border mb-6">
            <div class="flex gap-8">
                <button class="tab active pb-3" data-type="singles">
                    Singles
                </button>
                <button class="tab pb-3" data-type="albums">
                    Albums
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="bg-gradient-to-br from-[hsl(220,15%,15%)] to-[hsl(220,15%,10%)]
         rounded-lg border border-[hsl(220,15%,25%)] p-6 text-white">
                <p class="text-sm text-muted">Total Streams</p>
                <h2 id="totalStreams" class="text-3xl w-5 h-5 text-primary">0</h2>
            </div>

            <div class="bg-gradient-to-br from-[hsl(30,15%,15%)] to-[hsl(20,15%,12%)]
           rounded-lg border border-[hsl(30,15%,25%)] p-6 text-white">
                <p class="text-sm text-muted">Total Revenue</p>
                <h2 id="totalRevenue" class="text-3xl w-5 h-5 text-green-400">₹0.00</h2>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-6">

            <!-- DATE RANGE LABEL -->
            <div id="dateRangeLabel" class="text-sm text-muted"></div>

            <!-- RANGE FILTER -->
            <select id="rangeType" class="ml-auto bg-white border-b border-zinc-400/30 px-4 py-2 rounded">
                <option value="week">Last 7 Days</option>
                <option value="last30">Last 30 Days</option>
                <option value="custom">Custom</option>
            </select>

            <!-- CUSTOM DATE RANGE -->
            <div id="customRange" class="hidden flex gap-2">
                <input type="date" id="fromDate" class="bg-gray-300 border px-3 py-2">
                <input type="date" id="toDate" class="bg-gray-300 border px-3 py-2">
                <!-- <button id="applyCustom" class="bg-primary px-4 py-2 rounded text-black font-semibold">
                    Apply
                </button> -->
            </div>

            <!-- PLATFORM FILTER -->
            <select id="platformFilter" class="bg-white border-b border-zinc-400/30 px-4 py-2 rounded">
                <option value="all">All Platforms</option>
                <option value="spotify">Spotify</option>
                <option value="apple">Apple Music</option>
                <option value="youtube">YouTube</option>
            </select>

        </div>
        <div class="bg-[#111] p-4 rounded">
            <canvas id="analyticsChart" height="100"></canvas>
        </div>



        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            /* ===============================
               GLOBAL STATE
            ================================ */
            let currentType = 'singles';
            let currentMetric = 'streams';
            let chart;

            /* ===============================
               DOM ELEMENTS
            ================================ */
            const rangeSelect = document.getElementById('rangeType');
            const platformSelect = document.getElementById('platformFilter');
            const customBox = document.getElementById('customRange');
            const fromInput = document.getElementById('fromDate');
            const toInput = document.getElementById('toDate');

            /* ===============================
               DATE HELPERS
            ================================ */
            function formatDate(date) {
                return date.toISOString().slice(0, 10);
            }

            function setDefaultCustomDates() {
                const today = new Date();
                const lastYear = new Date();
                lastYear.setFullYear(today.getFullYear() - 1);

                fromInput.value = formatDate(lastYear);
                toInput.value = formatDate(today);
            }

            /* ===============================
               DATE RANGE BUILDER
               (Last 7 / 30 excludes today)
            ================================ */
            function buildDateRange(range) {
                let start, end;

                // yesterday
                end = new Date();
                end.setDate(end.getDate() - 1);

                if (range === 'week') {
                    start = new Date(end);
                    start.setDate(end.getDate() - 6);
                }
                else if (range === 'last30') {
                    start = new Date(end);
                    start.setDate(end.getDate() - 29);
                }
                else {
                    start = new Date(fromInput.value);
                    end = new Date(toInput.value);
                }

                const dates = [];
                for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                    dates.push(formatDate(new Date(d)));
                }

                return { start, end, dates };
            }

            /* ===============================
               NORMALIZE DATA
            ================================ */
            function normalizeRows(rows, dates) {
                const map = {};
                rows.forEach(r => map[r.report_month] = r);

                return dates.map(date => ({
                    report_month: date,
                    streams: map[date]?.streams ?? 0,
                    revenue: map[date]?.revenue ?? 0
                }));
            }

            /* ===============================
               DATE LABEL
            ================================ */
            function updateDateLabel(range, start, end) {
                const fmt = d =>
                    d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short' });

                let text = '';
                if (range === 'week') {
                    text = `Last 7 Days: ${fmt(start)} – ${fmt(end)}`;
                } else if (range === 'last30') {
                    text = `Last 30 Days: ${fmt(start)} – ${fmt(end)}`;
                } else {
                    text = `Custom: ${fmt(start)} – ${fmt(end)}`;
                }

                document.getElementById('dateRangeLabel').innerText = text;
            }

            /* ===============================
               LOAD DATA
            ================================ */
            function loadChart() {
                const range = rangeSelect.value;
                const platform = platformSelect.value;

                if (range === 'custom' && (!fromInput.value || !toInput.value)) return;

                const params = new URLSearchParams({
                    range,
                    platform
                });

                if (range === 'custom') {
                    params.append('from', fromInput.value);
                    params.append('to', toInput.value);
                }

                fetch(`<?= base_url('analytics/get_data') ?>/${currentType}/${currentMetric}?${params}`)
                    .then(res => res.json())
                    .then(res => {

                        document.getElementById('totalStreams').innerText =
                            Number(res.totals.streams).toLocaleString();

                        document.getElementById('totalRevenue').innerText =
                            '₹' + Number(res.totals.revenue).toFixed(2);

                        const rangeInfo = buildDateRange(range);
                        updateDateLabel(range, rangeInfo.start, rangeInfo.end);

                        const finalRows = normalizeRows(res.rows, rangeInfo.dates);
                        renderChart(finalRows);
                    });
            }

            /* ===============================
               RENDER CHART
            ================================ */
            function renderChart(rows) {
                const labels = rows.map(r =>
                    new Date(r.report_month).toLocaleDateString('en-IN', {
                        day: '2-digit',
                        month: 'short'
                    })
                );

                const data = rows.map(r => r[currentMetric]);

                if (chart) chart.destroy();

                chart = new Chart(document.getElementById('analyticsChart'), {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: currentMetric.toUpperCase(),
                            data,
                            tension: 0.4
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { labels: { color: '#fff' } }
                        },
                        scales: {
                            x: { ticks: { color: '#aaa' } },
                            y: { ticks: { color: '#aaa' } }
                        }
                    }
                });
            }

            /* ===============================
               EVENTS
            ================================ */

            // Tabs
            document.querySelectorAll('.tab').forEach(btn => {
                btn.onclick = () => {
                    document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    currentType = btn.dataset.type;
                    loadChart();
                };
            });

            // Range change
            rangeSelect.onchange = () => {
                if (rangeSelect.value === 'custom') {
                    customBox.classList.remove('hidden');
                    setDefaultCustomDates();
                    loadChart();
                } else {
                    customBox.classList.add('hidden');
                    loadChart();
                }
            };

            // Custom date change → auto refresh
            fromInput.onchange = () => loadChart();
            toInput.onchange = () => loadChart();

            // Platform change
            platformSelect.onchange = loadChart;

            /* ===============================
               INIT
            ================================ */
            loadChart();
        </script>




        <!-- <script>
            let currentType = 'singles';
            let currentMetric = 'streams';
            let chart;

            function updateDateLabel(range, rows) {
                if (!rows.length) {
                    document.getElementById('dateRangeLabel').innerText = '';
                    return;
                }

                const dates = rows.map(r => new Date(r.report_month));
                const start = new Date(Math.min(...dates));
                const end = new Date(Math.max(...dates));

                const format = d => d.toLocaleDateString('en-IN', {
                    day: '2-digit', month: 'short'
                });

                let text = '';
                if (range === 'week') {
                    text = `Last 7 Days: ${format(start)} – ${format(end)}`;
                } else if (range === 'month') {
                    text = start.toLocaleString('en-IN', { month: 'long', year: 'numeric' });
                } else {
                    text = `Custom: ${format(start)} – ${format(end)}`;
                }

                document.getElementById('dateRangeLabel').innerText = text;
            }

            function loadChart() {

                const range = document.getElementById('rangeType').value;
                const platform = document.getElementById('platformFilter').value;

                const params = new URLSearchParams({
                    range: range,
                    platform: platform
                });

                fetch(`<?= base_url('analytics/get_data') ?>/${currentType}/${currentMetric}?${params}`)
                    .then(r => r.json())
                    .then(res => {

                        // Cards
                        document.getElementById('totalStreams').innerText =
                            Number(res.totals.streams).toLocaleString();

                        document.getElementById('totalRevenue').innerText =
                            '₹' + Number(res.totals.revenue).toFixed(2);

                        updateDateLabel(range, res.rows);
                        renderChart(res.rows);
                    });
            }

            function renderChart(rows) {

                const labels = rows.map(r =>
                    new Date(r.report_month).toLocaleDateString('en-IN', {
                        day: '2-digit',
                        month: 'short'
                    })
                );

                const data = rows.map(r => r[currentMetric]);

                if (chart) chart.destroy();

                chart = new Chart(document.getElementById('analyticsChart'), {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: currentMetric.toUpperCase(),
                            data,
                            tension: 0.4
                        }]
                    },
                    options: {
                        plugins: { legend: { labels: { color: '#fff' } } },
                        scales: {
                            x: { ticks: { color: '#aaa' } },
                            y: { ticks: { color: '#aaa' } }
                        }
                    }
                });
            }

            // EVENTS
            document.querySelectorAll('.tab').forEach(btn => {
                btn.onclick = () => {
                    document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    currentType = btn.dataset.type;
                    loadChart();
                };
            });

            ['rangeType', 'platformFilter'].forEach(id =>
                document.getElementById(id).onchange = loadChart
            );

            // INIT
            loadChart();
        </script> -->
<script>lucide.createIcons();</script>

</body>

</html>