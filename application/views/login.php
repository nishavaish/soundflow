<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - SoundFlow</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom Tailwind Colors -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            background: "#0f0f14",
            foreground: "#ffffff",
            muted: "#9ca3af",
            border: "#27272a",
            card: "#1a1a1f",
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-background to-[hsl(263,40%,15%)] flex items-center justify-center px-4">

  <div class="w-full max-w-md">

    <!-- Logo + Title -->
    <div class="text-center mb-8">
      <a href="/" class="inline-flex items-center gap-2 mb-4">
        <svg id="music-icon" class="w-10 h-10 text-primary" stroke="currentColor" fill="none" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M9 18V5l12-2v13" />
          <circle cx="6" cy="18" r="3" />
          <circle cx="18" cy="16" r="3" />
        </svg>

        <span class="text-3xl font-bold bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] bg-clip-text text-transparent">
          SoundFlow
        </span>
      </a>

      <h1 class="text-3xl font-bold mb-2 text-white">Welcome Back</h1>
      <p class="text-muted">Sign in to your artist account</p>
    </div>

    <!-- Form Card -->
    <div class="bg-card border border-border rounded-lg p-8">

      <form action="<?php echo site_url('dashboard') ?>" method="GET" class="space-y-6">

        <!-- Email -->
        <div class="space-y-2">
          <label for="email" class="text-white">Email</label>
          <input id="email" type="email" placeholder="artist@example.com"
            class="w-full px-4 py-2 rounded-md bg-background border border-border text-white focus:border-primary focus:ring-primary" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
          <label for="password" class="text-white">Password</label>
          <input id="password" type="password"
            class="w-full px-4 py-2 rounded-md bg-background border border-border text-white focus:border-primary focus:ring-primary" />
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full py-2 font-semibold text-white rounded-md bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] hover:opacity-90">
          Sign In
        </button>

      </form>

      <div class="mt-6 text-center text-sm">
        <p class="text-muted">
          Don't have an account?
          <a href="<?php echo site_url('register') ?>" class="text-primary hover:underline">Sign up</a>
        </p>
      </div>

    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>
