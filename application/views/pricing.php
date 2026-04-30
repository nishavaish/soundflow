<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SoundFlow - Digital Music Distribution</title>

    <!-- Tailwind via CDN (remove if you're using your own compiled CSS) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Optional: tweak scroll behavior for older browsers */
        html {
            scroll-behavior: smooth;
        }
    </style>
	
	<style>
    
   
    .border-primary-custom { border-color: #ff531a !important; }
</style>

</head>
<body class="min-h-screen bg-white text-black">
    <!-- Header -->
    <header class="border-b border-zinc-400/30 backdrop-blur-sm sticky top-0 z-50 bg-zinc-300/50">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <!-- Music Icon -->
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-custom/20 text-primary-custom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18V5l12-2v13" />
                        <circle cx="6" cy="18" r="3" />
                        <circle cx="18" cy="16" r="3" />
                    </svg>
                </span>
                <span class="text-2xl font-bold">
                    SoundFlow
                </span>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-sm">
                <a 
                    href="#why-soundflow"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    WHY SOUNDFLOW
                </a>
                <a 
                    href="#music-publishing"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    MUSIC PUBLISHING
                </a>
                <a 
                    href="#artist-services"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    ARTIST SERVICES
                </a>
                <a  href="#resources"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    RESOURCES
                </a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="<?php echo site_url('login') ?>">
                    <button class="px-4 py-2 rounded-full text-sm border border-transparent hover:border-zinc-700 text-black hover:text-primary-custom transition-colors">
                        Login
                    </button>
                </a>
                <a href="<?php echo site_url('register') ?>">
                    <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-6 py-2 text-sm font-medium transition-colors">
                        Get Started
                    </button>
                </a>
            </div>
        </div>
    </header>

<!-- Header -->
	
  <div class="container mx-auto px-6 py-8">
<?php
	$colors = [
	  'daily' => 'from-[#1e3a8a] to-[#0f172a]',
	  'monthly' => 'from-[#4c1d95] to-[#312e81]',
	  'yearly' => 'from-[#064e3b] to-[#022c22]'
	];
	?>

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
   
   
   
   
   
   <!-- Footer -->
    <footer class="border-t border-zinc-200/30 py-12 bg-zinc-300/50">
        <div class="container max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold mb-4">About</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Press</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Support</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Services</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Music Distribution</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Music Publishing</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Artist Services</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Legal</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-gray-500 text-sm pt-8 border-t border-zinc-800/30">
                <p>&copy; 2025 SoundFlow. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script (for older browsers that don't support CSS scroll-behavior well) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href').substring(1);
                    const target = document.getElementById(targetId);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
