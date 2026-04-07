<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard - SoundFlow</title>

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

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-white">

  <!-- Header -->
 <?php $this->view('page_header'); ?>


  <div class="container mx-auto px-6 py-8">

    <!-- Artist Name -->
    <h1 class="text-4xl font-bold text-black mb-8"><?php echo $this->session->userdata('user_name') ?></h1>

    <!-- Stats Grid -->
   <div class="grid md:grid-cols-2 gap-6 mb-8">

  <!-- Total Streams -->
  
  <div
  class="bg-gradient-to-br from-[#1e3a8a] via-[#1e40af] to-[#0f172a]
         rounded-lg border border-[#3b82f6]/30 p-6 text-white shadow-lg">

  <div class="flex items-center justify-between mb-2">
    <h3 class="text-sm text-white">Total Streams</h3>
    <i data-lucide="headphones" class="w-5 h-5 text-primary"></i>
  </div>

  <div class="text-4xl font-bold mb-2">
    <?= number_format($stats->total_streams ?? 0) ?>
  </div>

  <canvas id="streamsMiniChart" height="50"></canvas>
</div>


  <!-- Total Downloads -->
 <!-- <div
    class="bg-gradient-to-br from-[hsl(260,15%,15%)] to-[hsl(260,15%,10%)]
           rounded-lg border border-[hsl(260,15%,25%)] p-6 text-white">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-sm text-white">Total Downloads</h3>
      <i data-lucide="download" class="w-5 h-5 text-primary"></i>
    </div>
    <div class="text-4xl font-bold">
      <?= number_format($stats->total_downloads ?? 0) ?>
    </div>
  </div>
 -->
  <!-- Total Revenue -->
  <div
    class="bg-gradient-to-br from-[#4c1d95] via-[#6d28d9] to-[#312e81]
         rounded-lg border border-[#8b5cf6]/30 p-6 text-white shadow-lg">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-sm text-white">Total Revenue</h3>
      <i data-lucide="dollar" class="w-5 h-5 text-green-400"></i>
    </div>
    <div class="text-4xl font-bold text-green-400">
      <?= number_format($stats->total_revenue ?? 0, 2) ?>
    </div>
  </div>
  
  
  <div
  class="bg-gradient-to-br from-[#064e3b] via-[#047857] to-[#022c22]
         rounded-lg border border-[#22c55e]/30 p-6 text-white shadow-lg">

  <h3 class="text-sm text-white mb-3">Top Performing Track</h3>

  <?php if ($top_track): ?>
    <div class="flex items-center justify-between">
      <div>
        <div class="text-lg font-semibold"><?= $top_track->title ?></div>
        <div class="text-sm text-white"><?= $top_track->primary_artist ?></div>
      </div>
      <div class="text-right">
        <div class="text-xl font-bold"><?= number_format($top_track->streams) ?></div>
        <div class="text-xs text-white">streams</div>
      </div>
    </div>
  <?php else: ?>
    <p class="text-white text-sm">No data yet</p>
  <?php endif; ?>
</div>



<div
  class="bg-gradient-to-br from-[#7c2d12] via-[#9a3412] to-[#431407]
         rounded-lg border border-[#fb923c]/30 p-6 text-white shadow-lg">

  <h3 class="text-sm text-white mb-4">This Month vs Last Month</h3>

  <?php
    $current = $month_compare[0] ?? null;
    $previous = $month_compare[1] ?? null;
  ?>

  <div class="grid grid-cols-2 gap-6">
    <div>
      <div class="text-xs text-white">This Month</div>
      <div class="text-xl font-bold">
        <?= number_format($current->streams ?? 0) ?>
      </div>
      <div class="text-sm text-green-400">
        ₹<?= number_format($current->revenue ?? 0, 2) ?>
      </div>
    </div>

    <div>
      <div class="text-xs text-white">Last Month</div>
      <div class="text-xl font-bold">
        <?= number_format($previous->streams ?? 0) ?>
      </div>
      <div class="text-sm text-white">
        ₹<?= number_format($previous->revenue ?? 0, 2) ?>
      </div>
    </div>
  </div>
</div>


</div>


  

	
    <!-- Artist Accounts 
    <div>
      <h2 class="text-2xl font-bold mb-6 text-white">Your Artist Accounts</h2>

      <div class="rounded-lg bg-card border border-border p-8 text-center text-white">
        <p class="text-white mb-4">No releases yet</p>

        <a href="<?php echo site_url('upload') ?>"
          class="px-6 py-2 rounded-md bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] hover:opacity-90">
          Create Your First Release
        </a>
      </div>
    </div>
	-->

  </div>

  <script>
    lucide.createIcons();
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const trendData = <?= json_encode($trend) ?>;

new Chart(document.getElementById('streamsMiniChart'), {
  type: 'line',
  data: {
    labels: trendData.map(d =>
      new Date(d.month + '-01').toLocaleString('en-IN', { month: 'short' })
    ),
    datasets: [{
      data: trendData.map(d => d.streams),
      borderColor: '#ff531a',
      tension: 0.4,
      fill: false
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: { x: { display: false }, y: { display: false } }
  }
});
</script>


</body>

</html>
