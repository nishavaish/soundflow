<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Album – Step 4</title>

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

  <style>
    .template-selected {
      border-color: #6366F1 !important;
      box-shadow: 0 0 10px #6366f155;
    }
  </style>
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
            <div class="text-2xl font-bold">4</div>
            <div class="text-xs">/ 4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">Final Step</div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-4xl">
    <div class="bg-card border border-border rounded-lg p-8 space-y-8">
      <div>
        <h2 class="text-2xl font-bold mb-2">Add Cover Art</h2>
        <p class="text-sm text-muted">
          Upload your artwork or choose from our ready-to-customize templates.
        </p>
      </div>

      <form method="post" action="<?= base_url('UploadAlbum/step4'); ?>" enctype="multipart/form-data" class="space-y-8">
<?php if ($this->session->flashdata('upload_error')): ?>
    <div class="bg-red-900/40 border border-red-500 text-red-300 px-4 py-3 rounded mb-4 text-sm">
        <?= $this->session->flashdata('upload_error'); ?>
    </div>
<?php endif; ?>

        <div>
          <button type="button" onclick="toggleGuidelines()"
                  class="text-primary hover:text-primary/80 font-semibold text-sm">
            Show Artwork Guidelines ↕
          </button>
          <ul id="guidelines" class="hidden list-disc list-inside text-xs text-muted mt-3 ml-4 space-y-1">
            <li>JPG or PNG under 10MB.</li>
            <li>Minimum 1600x1600 pixels.</li>
            <li>No social media handles, URLs, or pricing info.</li>
            <li>No blurry or pixelated images.</li>
          </ul>
        </div>

        <!-- Upload -->
        <div class="space-y-3">
          <h3 class="text-xl font-semibold">Upload Artwork *</h3>
          <div class="border-2 border-dashed border-border rounded-lg p-10 text-center hover:border-primary transition">
            <i data-lucide="image" class="w-12 h-12 text-muted mx-auto mb-3"></i>
            <p class="text-sm text-muted mb-3">Click to upload JPG or PNG (3000x3000 recommended)</p>
            <input type="file" name="cover_art" accept="image/*"
                   class="block mx-auto text-sm text-muted" required>
          </div>
        </div>

        <!-- Templates -->
        <div class="space-y-3">
          <h3 class="text-xl font-semibold">Or Choose a Template</h3>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="templateGrid">
            <?php for ($i=1; $i<=8; $i++): ?>
              <div
                data-template="<?= $i; ?>"
                onclick="selectTemplate(<?= $i; ?>)"
                class="template-box aspect-square rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 cursor-pointer border-2 border-transparent flex items-center justify-center hover:scale-105 transition-all">
                <div class="text-center text-xs">
                  <div class="font-bold mb-1">ALBUM NAME</div>
                  <div class="text-primary">ARTIST NAME</div>
                </div>
              </div>
            <?php endfor; ?>
          </div>
          <input type="hidden" name="selected_template" id="selected_template">
        </div>

        <div class="flex justify-between pt-6">
          <a href="<?= base_url('UploadAlbum/step3'); ?>"
             class="px-6 py-2 rounded-lg border border-border hover:bg-white/10 text-sm">
            ← BACK
          </a>
          <button
            type="submit"
            class="bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] hover:opacity-90 px-8 py-3 rounded-lg font-semibold text-sm"
          >
            FINISH →
          </button>
        </div>

      </form>
    </div>
  </div>

  <script>
    lucide.createIcons();
    function toggleGuidelines() {
      document.getElementById('guidelines').classList.toggle('hidden');
    }
    function selectTemplate(id) {
      document.getElementById('selected_template').value = id;
      document.querySelectorAll('.template-box').forEach(el => el.classList.remove('template-selected'));
      document.querySelector('[data-template="'+id+'"]').classList.add('template-selected');
    }
  </script>
</body>
</html>
