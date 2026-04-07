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
            primary: "#6366F1",
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

<body class="min-h-screen bg-background">

  <!-- Header -->
  <header class="border-b border-border bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">

      <!-- Logo -->
      <a href="/" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold text-white">SoundFlow</span>
      </a>

      <!-- Nav -->
      <nav class="hidden md:flex items-center gap-8 text-sm">
        <a href="<?php echo site_url('Dashboard') ?>" class="hover:text-primary transition-colors text-white">RELEASES</a>
        <a href="#" class="hover:text-primary transition-colors text-white">MONEY & ANALYTICS</a>
        <a href="#" class="hover:text-primary transition-colors text-white">ARTIST SERVICES</a>
      </nav>

      <!-- Right Icons -->
      <div class="flex items-center gap-4">

        <a href="<?php echo site_url('upload') ?>"
          class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
          ADD RELEASE
        </a>

        <button class="p-2 rounded-md hover:bg-white/10">
          <i data-lucide="bell" class="w-5 h-5 text-white"></i>
        </button>

        <button class="p-2 rounded-md hover:bg-white/10">
          <i data-lucide="shopping-cart" class="w-5 h-5 text-white"></i>
        </button>

        <button class="p-2 rounded-md hover:bg-white/10">
          <i data-lucide="user" class="w-5 h-5 text-white"></i>
        </button>

      </div>
    </div>
  </header>

  <div class="container mx-auto px-6 py-8">

    <!-- Artist Name -->
    <h1 class="text-4xl font-bold text-white mb-8">dhanpreet</h1>

    <!-- Stats Grid -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">

      <!-- Available Balance Card -->
      <div
        class="bg-gradient-to-br from-[hsl(30,15%,15%)] to-[hsl(20,15%,12%)] rounded-lg border border-[hsl(30,15%,25%)] p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm text-muted">Available Balance</h3>
          <i data-lucide="help-circle" class="w-4 h-4 text-muted"></i>
        </div>
        <div class="flex items-end justify-between">
          <div class="text-4xl font-bold">$0.00</div>
          <button class="px-3 py-1 rounded-md border border-white/20 hover:bg-white/10 text-white">
            WITHDRAW
          </button>
        </div>
      </div>

      <!-- Unlimited Plan Card -->
      <div
        class="bg-gradient-to-br from-[hsl(30,15%,15%)] to-[hsl(20,15%,12%)] rounded-lg border border-[hsl(30,15%,25%)] p-6 text-white">
        <h3 class="text-sm text-muted mb-4">Unlimited Plan</h3>
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-full bg-gradient-to-r from-[hsl(45,100%,50%)] to-[hsl(25,100%,50%)] flex items-center justify-center">
            <i data-lucide="music" class="w-5 h-5 text-black"></i>
          </div>
          <div class="text-2xl font-bold">Professional</div>
        </div>
      </div>

      <!-- Lifetime Streams Card -->
      <div
        class="bg-gradient-to-br from-[hsl(30,15%,15%)] to-[hsl(20,15%,12%)] rounded-lg border border-[hsl(30,15%,25%)] p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm">Lifetime Streams</h3>
          <span class="text-xs bg-green-600 text-white px-2 py-1 rounded">New Feature!</span>
        </div>

        <!-- Chart -->
        <svg width="100%" height="40" viewBox="0 0 100 40">
          <path d="M 0,20 Q 25,10 50,20 T 100,20" stroke="hsl(45,100%,50%)" stroke-width="2" fill="none" />
          <path d="M 0,20 Q 25,25 50,15 T 100,25" stroke="hsl(350,100%,65%)" stroke-width="2" fill="none" />
        </svg>

        <a href="#" class="text-sm text-primary hover:underline block mt-3">
          View Analytics →
        </a>
      </div>

    </div>

    <!-- Payout Banner -->
    <div
      class="rounded-lg bg-gradient-to-r from-[hsl(45,40%,30%)] via-[hsl(25,40%,25%)] to-[hsl(350,35%,30%)] p-6 mb-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-xl font-bold mb-2">Don't Delay Getting Your Earnings</h3>
          <p class="text-sm text-white/80">
            Set up your payout preferences now so you can always get paid on time.
          </p>
        </div>

        <button class="px-4 py-2 rounded-md border border-white/40 hover:bg-white/10 font-semibold">
          SET UP PAYOUT
        </button>
      </div>
    </div>

    <!-- Mastering Banner -->
    <div class="rounded-lg bg-[hsl(0,0%,12%)] border border-[hsl(0,0%,20%)] p-6 mb-8 relative text-white">
      <button class="absolute top-4 right-4 p-2 rounded-md hover:bg-white/10">
        <i data-lucide="x" class="w-4 h-4"></i>
      </button>

      <div class="flex items-center gap-4">
        <div
          class="w-12 h-12 bg-gradient-to-br from-primary to-[hsl(220,70%,60%)] rounded-lg flex items-center justify-center">
          <i data-lucide="trending-up" class="w-6 h-6"></i>
        </div>

        <div>
          <h3 class="text-lg font-bold mb-1">Master your tracks instantly</h3>
          <p class="text-sm text-muted mb-2">
            SoundFlow Mastering offers AI-driven, professional-sounding tracks at just $5 USD per track
          </p>
          <a href="#" class="text-sm text-primary hover:underline">Get Started</a>
        </div>
      </div>
    </div>

    <!-- Artist Accounts -->
    <div>
      <h2 class="text-2xl font-bold mb-6 text-white">Your Artist Accounts</h2>

      <div class="rounded-lg bg-card border border-border p-8 text-center text-white">
        <p class="text-muted mb-4">No releases yet</p>

        <a href="<?php echo site_url('upload') ?>"
          class="px-6 py-2 rounded-md bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] hover:opacity-90">
          Create Your First Release
        </a>
      </div>
    </div>

  </div>

  <script>
    lucide.createIcons();
  </script>

</body>

</html>
