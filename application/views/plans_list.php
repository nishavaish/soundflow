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
	<?php
	$colors = [
	  'daily' => 'from-[#1e3a8a] to-[#0f172a]',
	  'monthly' => 'from-[#4c1d95] to-[#312e81]',
	  'yearly' => 'from-[#064e3b] to-[#022c22]'
	];
	?>

  <div class="container mx-auto px-6 py-8">

<div class="mt-12">

  <h2 class="text-2xl font-bold text-black mb-8">Choose Your Plan</h2>

  <div class="grid md:grid-cols-3 gap-8">

    <?php 
    $colors = [
      'yearly' => 'from-yellow-400 via-orange-500 to-pink-500',
      'monthly' => 'from-pink-500 via-red-500 to-purple-500',
      'daily' => 'from-blue-500 via-indigo-500 to-purple-600'
    ];
    ?>

    <?php foreach ($plans as $p): ?>

      <div class="relative p-[3px] rounded-2xl bg-gradient-to-r <?= $colors[$p->duration] ?? 'from-gray-300 to-gray-500' ?> hover:scale-105 transition duration-300">
        
        <!-- Inner Card -->
        <div class="bg-white rounded-xl p-6 h-full flex flex-col justify-between shadow-md">

          <!-- Badge -->
          <?php if($p->price >= 4000): ?>
            <div class="absolute -top-3 left-4 bg-yellow-400 text-black text-xs px-3 py-1 rounded-full font-semibold">
              BEST DEAL
            </div>
          <?php endif; ?>

          <!-- Plan Name -->
          <h3 class="text-lg font-semibold text-gray-800 mb-2 uppercase tracking-wide">
            <?= html_escape($p->name) ?>
          </h3>

          <!-- Price -->
          <div class="mb-4">
            <span class="text-4xl font-bold text-black">
              ₹<?= number_format($p->price) ?>
            </span>
            <span class="text-gray-500 text-sm">
              /<?= $p->duration ?>
            </span>
          </div>

          <!-- Features -->
          <ul class="space-y-2 mb-6">
            <?php if (!empty($p->features)): ?>
              <?php foreach ($p->features as $f): ?>
                <li class="flex items-center text-gray-700 text-sm">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                  <?= html_escape($f->feature_name) ?>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>

          <!-- Button -->
        <?php $isPopular = ($p->price >= 2000); ?>

<button 
  class="w-full py-2.5 rounded-lg font-medium transition
 bg-gradient-to-r from-primary to-orange-500 text-white shadow-md hover:shadow-lg">
  Get Started
</button>



        </div>
      </div>

    <?php endforeach; ?>

  </div>

</div>
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
