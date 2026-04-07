<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SoundFlow – Digital Music Distribution</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Optional: Extend Tailwind Theme Colors -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            accent: "#F472B6",
            background: "#ffffff",
            foreground: "#000000",
            muted: "#6b7280",
            border: "#e5e7eb"
          }
        }
      }
    }
  </script>

</head>
<body class="min-h-screen bg-background text-foreground">

  <!-- Header -->
  <header class="border-b border-border/30 backdrop-blur-sm sticky top-0 z-50 bg-background/95">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="text-3xl text-primary">🎵</span>
        <span class="text-2xl font-bold text-primary">SoundFlow</span>
      </div>

      <nav class="hidden md:flex items-center gap-8 text-sm">
        <a href="#features" class="hover:text-primary transition-colors">WHY SOUNDFLOW</a>
        <a href="#pricing" class="hover:text-primary transition-colors">MUSIC PUBLISHING</a>
        <a href="#services" class="hover:text-primary transition-colors">ARTIST SERVICES</a>
        <a href="#resources" class="hover:text-primary transition-colors">RESOURCES</a>
      </nav>

      <div class="flex items-center gap-3">
        <a href="<?php echo site_url('login'); ?>" class="px-4 py-2 rounded-md hover:text-primary">Login</a>
        <a href="<?php echo site_url('register'); ?>" class="bg-primary text-white hover:bg-primary/90 rounded-full px-6 py-2">
          Get Started
        </a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="container mx-auto px-4 py-20 text-center">
    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
      Digital <span class="text-primary">Music Distribution</span> Services
    </h1>
    <p class="text-lg md:text-xl text-muted-foreground mb-8 max-w-3xl mx-auto">
      Sell your music online & keep 100% of your rights. Distribute your music to over 150+ digital stores including Spotify, Apple Music, TikTok, YouTube and more.
    </p>

    <a href="<?php echo site_url('register') ?>"
       class="bg-primary text-white hover:bg-primary/90 rounded-full text-lg px-10 py-6 inline-block">
      Get Started For Artists
    </a>
  </section>

  <!-- Unlimited Distribution -->
  <section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">
        <span class="text-primary">Unlimited Distribution</span> Starting at $22.99/year
      </h2>
      <p class="text-lg text-muted-foreground mb-8 max-w-3xl mx-auto">
        Get your music on all major streaming platforms worldwide.
      </p>

      <!-- Platform Logos -->
      <div class="flex flex-wrap justify-center items-center gap-8 mb-10 opacity-80">
        <div class="text-2xl font-bold">Spotify</div>
        <div class="text-2xl font-bold">Apple Music</div>
        <div class="text-2xl font-bold">YouTube</div>
        <div class="text-2xl font-bold">Amazon</div>
        <div class="text-2xl font-bold">Tidal</div>
        <div class="text-2xl font-bold">Beatport</div>
      </div>

      <a href="<?php echo site_url('register') ?>"
         class="bg-primary text-white hover:bg-primary/90 rounded-full px-8 py-3 inline-block">
        Start Distribution
      </a>
    </div>
  </section>

  <!-- What is SoundFlow -->
  <section class="container mx-auto px-4 py-20 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">
      What is <span class="text-primary">SoundFlow</span>?
    </h2>
    <p class="text-xl text-primary mb-6">Your Independent Music Distribution Company</p>
    <p class="text-lg text-muted-foreground mb-8 max-w-4xl mx-auto">
      We offer a suite of features to help content creators distribute, monetize and market their work.
    </p>

    <a href="<?php echo site_url('register') ?>"
       class="bg-primary text-white hover:bg-primary/90 rounded-full px-8 py-3 inline-block">
      Get Started For Artists
    </a>
  </section>

  <!-- Why Choose SoundFlow -->
  <section class="bg-gray-50 py-20">
    <div class="container mx-auto px-4 max-w-6xl">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="flex justify-center">
          <div class="bg-gradient-to-br from-primary/20 to-accent/20 p-8 rounded-2xl">
            <div class="bg-white rounded-xl p-6 w-64">
              <div class="aspect-square bg-gradient-to-br from-primary to-accent/60 rounded-lg mb-4 flex items-center justify-center">
                <span class="text-white text-6xl">▶️</span>
              </div>
            </div>
          </div>
        </div>

        <div>
          <h2 class="text-4xl md:text-5xl font-bold mb-4">
            Why <span class="text-primary">Choose SoundFlow</span>
          </h2>
          <p class="text-xl text-primary mb-6">Best Choice for Music Distribution</p>

          <ul class="space-y-3 mb-8 text-muted-foreground">
            <li>✔ No upfront cost – 100% royalties</li>
            <li>✔ Unlimited music distribution</li>
            <li>✔ 150+ global stores</li>
            <li>✔ Keep 100% rights</li>
            <li>✔ YouTube Content ID earnings</li>
            <li>✔ Covers, remixes, samples supported</li>
            <li>✔ Live customer support</li>
          </ul>

          <a href="<?php echo site_url('register') ?>"
             class="bg-primary text-white hover:bg-primary/90 rounded-full px-8 py-3 inline-block">
            Get Started
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Stream & Distribute -->
  <section class="container mx-auto px-4 py-20 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">
      Stream & Distribute <span class="text-primary">Your Music</span> Without a Label
    </h2>
    <p class="text-xl mb-6">Sell Your Music. Online Worldwide.</p>

    <p class="text-lg text-muted-foreground mb-8 max-w-4xl mx-auto">
      We'll get your music heard globally across 150+ platforms.
    </p>

    <a href="<?php echo site_url('pricing') ?>"
       class="bg-primary text-white hover:bg-primary/90 rounded-full px-8 py-3 inline-block">
      View Pricing
    </a>
  </section>

  <!-- Features -->
  <section id="features" class="bg-gray-50 py-20">
    <div class="container mx-auto px-4 max-w-6xl grid md:grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="bg-white border border-border rounded-lg p-6 hover:border-primary/50">
        <h3 class="text-xl font-bold mb-2">🌍 Global Distribution</h3>
        <p class="text-muted-foreground">Reach 150+ streaming platforms worldwide.</p>
      </div>

      <div class="bg-white border border-border rounded-lg p-6 hover:border-primary/50">
        <h3 class="text-xl font-bold mb-2">💰 Keep 100% Earnings</h3>
        <p class="text-muted-foreground">All royalties belong to you.</p>
      </div>

      <div class="bg-white border border-border rounded-lg p-6 hover:border-primary/50">
        <h3 class="text-xl font-bold mb-2">📈 Real-Time Analytics</h3>
        <p class="text-muted-foreground">Track your music performance live.</p>
      </div>

      <div class="bg-white border border-border rounded-lg p-6 hover:border-primary/50">
        <h3 class="text-xl font-bold mb-2">🎵 Unlimited Uploads</h3>
        <p class="text-muted-foreground">Release unlimited songs every year.</p>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="container mx-auto px-4 py-20 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-16">
      What Are <span class="text-primary">Artists</span> Saying?
    </h2>

    <div class="max-w-4xl mx-auto bg-white border border-border rounded-2xl p-8">
      <div class="w-24 h-24 bg-gradient-to-br from-primary to-accent rounded-full mx-auto mb-6"></div>

      <p class="text-lg text-muted-foreground italic mb-4">
        "SoundFlow helped me grow my music career and manage distribution across all platforms."
      </p>

      <p class="font-bold text-xl">Independent Artist</p>
      <p class="text-primary">Verified User</p>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-gradient-to-r from-primary/20 to-accent/20 py-20 text-center">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">
        Ready to <span class="text-primary">Start Your Music Career</span>?
      </h2>
      <p class="text-xl text-muted-foreground mb-8 max-w-2xl mx-auto">
        Join thousands of independent artists worldwide.
      </p>

      <a href="<?php echo site_url('register') ?>"
         class="bg-primary text-white hover:bg-primary/90 rounded-full text-lg px-10 py-6 inline-block">
        Get Started Now
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="border-t border-border/30 py-12 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-4 gap-8 mb-8">

        <div>
          <h3 class="font-bold mb-4">About</h3>
          <ul class="space-y-2 text-muted-foreground text-sm">
            <li><a href="#" class="hover:text-primary">About Us</a></li>
            <li><a href="#" class="hover:text-primary">Careers</a></li>
            <li><a href="#" class="hover:text-primary">Press</a></li>
          </ul>
        </div>

        <div>
          <h3 class="font-bold mb-4">Support</h3>
          <ul class="space-y-2 text-muted-foreground text-sm">
            <li><a href="#" class="hover:text-primary">Help Center</a></li>
            <li><a href="#" class="hover:text-primary">Contact Us</a></li>
            <li><a href="#" class="hover:text-primary">FAQ</a></li>
          </ul>
        </div>

        <div>
          <h3 class="font-bold mb-4">Services</h3>
          <ul class="space-y-2 text-muted-foreground text-sm">
            <li><a href="#" class="hover:text-primary">Music Distribution</a></li>
            <li><a href="#" class="hover:text-primary">Music Publishing</a></li>
            <li><a href="#" class="hover:text-primary">Artist Services</a></li>
          </ul>
        </div>

        <div>
          <h3 class="font-bold mb-4">Legal</h3>
          <ul class="space-y-2 text-muted-foreground text-sm">
            <li><a href="#" class="hover:text-primary">Terms of Service</a></li>
            <li><a href="#" class="hover:text-primary">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-primary">Cookie Policy</a></li>
          </ul>
        </div>

      </div>

      <div class="text-center text-muted-foreground text-sm border-t border-border/30 pt-8">
        © 2025 SoundFlow. All rights reserved.
      </div>
    </div>
  </footer>

</body>
</html>
