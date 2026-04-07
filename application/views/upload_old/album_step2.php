<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Album – Step 2</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            background: "#000000",
            border: "#27272a",
            card: "#0f0f0f",
            muted: "#9ca3af"
          }
        }
      }
    }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-background to-[hsl(263,40%,10%)] text-white">

  <!-- Header -->
  <header class="border-b border-border bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('dashboard'); ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- Progress -->
  <div class="bg-gradient-to-r from-[hsl(45,40%,20%)] to-[hsl(350,40%,20%)] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold">Create Album</h1>
      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold">2</div>
            <div class="text-xs">/ 4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">Step 2 of 4</div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-4xl">
    <div class="bg-card border border-border rounded-lg p-8 space-y-8">
      <div>
        <h2 class="text-2xl font-bold mb-2">Stores &amp; Social Platforms</h2>
        <p class="text-sm text-muted">
          Select where you want to distribute your music.
        </p>
      </div>

      <form method="post" action="<?= base_url('UploadAlbum/step2'); ?>" class="space-y-8">
        <!-- Stores -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Stores</h3>
          <div class="grid md:grid-cols-3 gap-4 text-sm">
            <?php
              $stores = ['spotify','apple-music','amazon','youtube-music','tidal','deezer','boomplay','jiosaavn'];
              $labels = [
                'spotify'      => 'Spotify',
                'apple-music'  => 'Apple Music / iTunes',
                'amazon'       => 'Amazon Music',
                'youtube-music'=> 'YouTube Music',
                'tidal'        => 'Tidal',
                'deezer'       => 'Deezer',
                'boomplay'     => 'Boomplay',
                'jiosaavn'     => 'JioSaavn'
              ];
            ?>
            <?php foreach ($stores as $s): ?>
              <label class="flex items-center gap-2 bg-[#050505] border border-border rounded-lg px-3 py-2 cursor-pointer hover:border-primary">
                <input type="checkbox" name="stores[]" value="<?= $s; ?>" class="accent-primary">
                <span><?= $labels[$s]; ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Social -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Social Platforms</h3>
          <div class="grid md:grid-cols-3 gap-4 text-sm">
            <?php
              $socials = ['youtube','tiktok','instagram','facebook'];
              $socialLabels = [
                'youtube'   => 'YouTube Content ID',
                'tiktok'    => 'TikTok',
                'instagram' => 'Instagram',
                'facebook'  => 'Facebook',
              ];
            ?>
            <?php foreach ($socials as $s): ?>
              <label class="flex items-center gap-2 bg-[#050505] border border-border rounded-lg px-3 py-2 cursor-pointer hover:border-primary">
                <input type="checkbox" name="social[]" value="<?= $s; ?>" class="accent-primary">
                <span><?= $socialLabels[$s]; ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="flex justify-between pt-6">
          <a href="<?= base_url('UploadAlbum/step1'); ?>"
             class="px-6 py-2 rounded-lg border border-border hover:bg-white/10 text-sm">
            ← BACK
          </a>
          <button type="submit"
                  class="bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] hover:opacity-90 px-8 py-3 rounded-lg font-semibold text-sm">
            CONTINUE →
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
