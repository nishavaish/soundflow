<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Album – Step 3</title>

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
            <div class="text-2xl font-bold">3</div>
            <div class="text-xs">/ 4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">Step 3 of 4</div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-5xl">
    <div class="bg-card border border-border rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-2">Tracks</h2>
      <p class="text-sm text-muted mb-6">
        Upload your audio files and track information.
      </p>

      <form method="post" action="<?= base_url('UploadAlbum/step3'); ?>" enctype="multipart/form-data" class="space-y-8">
 <?php $track_count = $this->session->userdata('album_step1')['num_tracks']; ?>
 
 
 <?php if ($this->session->flashdata('upload_error')): ?>
    <div class="bg-red-900/40 border border-red-500 text-red-300 px-4 py-3 rounded mb-4 text-sm">
        <?= $this->session->flashdata('upload_error'); ?>
    </div>
<?php endif; ?>

 
        <?php for ($i = 0; $i < $track_count; $i++): ?>
          <div class="border border-border rounded-lg p-6 bg-[#050505] space-y-4">
            <div class="flex items-center justify-between mb-2">
              <h3 class="text-lg font-semibold">Track <?= $i + 1; ?></h3>
              <span class="text-xs text-muted">Track <?= $i + 1; ?> of <?= $track_count; ?></span>
            </div>

            <div class="space-y-2">
              <label class="text-sm font-semibold">Track Title *</label>
              <input
                type="text"
                name="track_title[]"
                class="w-full bg-black border border-border rounded-lg px-3 py-2 text-sm"
                placeholder="Track title"
                required
              >
            </div>

            <div class="space-y-2">
              <label class="text-sm font-semibold">Audio File *</label>
              <input
                type="file"
                name="audio_file[]"
                class="w-full text-sm text-muted"
                accept=".mp3,.wav,.flac,.aiff"
                required
              >
              <p class="text-xs text-muted">
                Recommended: 24-bit WAV/AIFF/FLAC or high-quality MP3
              </p>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
              <div class="space-y-2">
                <label class="text-sm font-semibold">ISRC (Optional)</label>
                <input
                  type="text"
                  name="track_isrc[]"
                  class="w-full bg-black border border-border rounded-lg px-3 py-2 text-sm"
                  placeholder="Leave blank to auto-generate"
                >
              </div>

              <div class="space-y-2">
                <label class="text-sm font-semibold">Disc #</label>
                <input
                  type="number"
                  name="disc_number[]"
                  class="w-full bg-black border border-border rounded-lg px-3 py-2 text-sm"
                  placeholder="1"
                >
              </div>

              <div class="space-y-2">
                <label class="text-sm font-semibold">Track #</label>
                <input
                  type="number"
                  name="track_number[]"
                  class="w-full bg-black border border-border rounded-lg px-3 py-2 text-sm"
                  placeholder="<?= $i + 1; ?>"
                >
              </div>
            </div>
          </div>
        <?php endfor; ?>

        <div class="flex justify-between pt-6">
          <a href="<?= base_url('UploadAlbum/step2'); ?>"
             class="px-6 py-2 rounded-lg border border-border hover:bg-white/10 text-sm">
            ← BACK
          </a>
          <button
            type="submit"
            class="bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] hover:opacity-90 px-8 py-3 rounded-lg font-semibold text-sm"
          >
            CONTINUE →
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
