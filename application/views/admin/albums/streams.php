<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-white">
                Platform-Wise Streams | ISRC: <?= $single->isrc ?>
            </h2>
            <p class="text-md text-gray-400">
                <?= $single->title ?> By <?= $single->primary_artist ?>

            </p>
        </div>

        <a href="<?= base_url('admin/albums') ?>" class="text-gray-400 hover:text-white text-sm">
            ← Back to Albums
        </a>
    </div>

    <!-- Platform Table -->
    <div class="overflow-hidden rounded-xl border border-gray-800">
        <table class="min-w-full text-sm text-gray-300">
            <thead class="bg-[#0b0b0b] text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Platform</th>
                    <th class="px-4 py-3 text-right">Streams</th>
                    <th class="px-4 py-3 text-right">Downloads</th>
                    <th class="px-4 py-3 text-right">Revenue (₹)</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-800 bg-[#0f0f0f]">
                <?php
                $totalStreams = 0;
                $totalDownloads = 0;
                $totalRevenue = 0;
                foreach ($platforms as $p):
                    $totalStreams += $p->total_streams;
                    $totalDownloads += $p->total_downloads;
                    $totalRevenue += $p->total_revenue;
                    ?>
                    <tr class="hover:bg-[#151515]">
                        <td class="px-4 py-3 font-medium text-white capitalize">
                            <?= $p->platform ?>
                        </td>
                        <td class="px-4 py-3 text-right font-semibold">
                            <?= number_format($p->total_streams) ?>
                        </td>
                        <td class="px-4 py-3 text-right font-semibold">
                            <?= number_format($p->total_downloads) ?>
                        </td>

                        <td class="px-4 py-3 text-right font-semibold text-green-400">
                            ₹<?= number_format($p->total_revenue, 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <!-- Totals -->
            <tfoot class="bg-black border-t border-gray-800">
                <tr>
                    <td class="px-4 py-3 font-semibold text-white">
                        Total
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-white">
                        <?= number_format($totalStreams) ?>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-white">
                        <?= number_format($totalDownloads) ?>
                    </td>

                    <td class="px-4 py-3 text-right font-semibold text-green-500">
                        ₹<?= number_format($totalRevenue, 2) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>


   <!-- Divider -->
    <div class="my-10 border-t border-gray-800"></div>

    <!-- Filters -->
    <div class="flex justify-end mb-6">
        <select id="monthFilter" class="bg-[#0f0f0f] border border-gray-700 text-gray-300 text-sm rounded-md px-3 py-2">

            <option value="">All Months</option>

            <?php foreach ($months as $m): ?>
                <option value="<?= $m->month ?>">
                    <?= date('M Y', strtotime($m->month . '-01')) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-[#0f0f0f] p-4 rounded-xl border border-gray-800">
            <h4 class="text-sm text-gray-400 mb-2">Streams</h4>
            <canvas id="streamsChart" height="160"></canvas>
        </div>

        <div class="bg-[#0f0f0f] p-4 rounded-xl border border-gray-800">
            <h4 class="text-sm text-gray-400 mb-2">Downloads</h4>
            <canvas id="downloadsChart" height="160"></canvas>
        </div>

        <div class="bg-[#0f0f0f] p-4 rounded-xl border border-gray-800">
            <h4 class="text-sm text-gray-400 mb-2">Revenue</h4>
            <canvas id="revenueChart" height="160"></canvas>
        </div>

    </div>

    <!-- Table -->
    <div>
        <h3 class="text-lg font-semibold text-white mb-4">
            Date-wise Streaming Breakdown
        </h3>

        <div class="overflow-hidden rounded-xl border border-gray-800">
            <table class="min-w-full text-sm text-gray-300">
                <thead class="bg-[#0b0b0b] text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Platform</th>
                        <th class="px-4 py-3 text-right">Streams</th>
                        <th class="px-4 py-3 text-right">Downloads</th>
                        <th class="px-4 py-3 text-right">Revenue (₹)</th>
                    </tr>
                </thead>
                <tbody id="datewiseTable" class="divide-y divide-gray-800 bg-[#0f0f0f]">
                </tbody>
            </table>
        </div>
    </div>










</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let streamsChart, downloadsChart, revenueChart;

    const streamsEl = document.getElementById('streamsChart');
    const downloadsEl = document.getElementById('downloadsChart');
    const revenueEl = document.getElementById('revenueChart');

    /* ===============================
       GENERIC PLATFORM LINE CHART
    ================================ */
    function renderPlatformChart(canvas, rows, valueKey) {

        const dates = [...new Set(rows.map(r => r.report_date))].sort();
        const platforms = [...new Set(rows.map(r => r.platform))];

        const datasets = platforms.map(p => ({
            label: p.toUpperCase(),
            data: dates.map(d => {
                const row = rows.find(r => r.platform === p && r.report_date === d);
                return row ? Number(row[valueKey]) : 0;
            }),
            tension: 0.35,
            fill: false
        }));

        return new Chart(canvas, {
            type: 'line',
            data: {
                labels: dates.map(d =>
                    new Date(d).toLocaleDateString('en-IN', {
                        day: '2-digit',
                        month: 'short'
                    })
                ),
                datasets
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: ctx =>
                                `${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString()}`
                        }
                    },
                    legend: {
                        labels: { color: '#d1d5db' }
                    }
                },
                scales: {
                    x: { ticks: { color: '#9ca3af' } },
                    y: { ticks: { color: '#9ca3af' } }
                }
            }
        });
    }

    /* ===============================
       TABLE
    ================================ */
    function renderTable(rows) {

        const tbody = document.getElementById('datewiseTable');
        tbody.innerHTML = '';

        rows.forEach(r => {
            tbody.innerHTML += `
        <tr class="hover:bg-[#151515]">
            <td class="px-4 py-3">
                ${new Date(r.report_date).toLocaleDateString('en-IN')}
            </td>
            <td class="px-4 py-3 capitalize text-white">${r.platform}</td>
            <td class="px-4 py-3 text-right">${Number(r.streams).toLocaleString()}</td>
            <td class="px-4 py-3 text-right">${Number(r.downloads).toLocaleString()}</td>
            <td class="px-4 py-3 text-right text-green-400">
                ₹${Number(r.revenue).toFixed(2)}
            </td>
        </tr>`;
        });
    }

    /* ===============================
       LOAD DATA (MONTH FILTER)
    ================================ */
    function loadMonthData(month = '') {

        let url = '<?= base_url("admin/albums/track/streams_by_month/" . $release_id) ?>';
        if (month) url += '/' + encodeURIComponent(month);

        fetch(url)
            .then(res => res.json())
            .then(res => {

                if (streamsChart) streamsChart.destroy();
                if (downloadsChart) downloadsChart.destroy();
                if (revenueChart) revenueChart.destroy();

                streamsChart = renderPlatformChart(streamsEl, res.datewise, 'streams');
                downloadsChart = renderPlatformChart(downloadsEl, res.datewise, 'downloads');
                revenueChart = renderPlatformChart(revenueEl, res.datewise, 'revenue');

                renderTable(res.datewise);
            });
    }

    /* ===============================
       EVENTS
    ================================ */
    document.getElementById('monthFilter')
        .addEventListener('change', e => loadMonthData(e.target.value));

    // Initial load
    loadMonthData();
</script>



