<?php
// Detect edit mode
$editMode = isset($album);

// Load session step4 in case user navigated back
$step4 = $this->session->userdata('album_step4') ?? [];

// Prefill helpers
$existing_cover = $editMode ? $album->cover_art : ($step4['cover_art'] ?? "");
$existing_template = $editMode ? $album->template : ($step4['template'] ?? "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $editMode ? "Edit Album – Step 4" : "Create Album – Step 4" ?></title>

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

<body class="min-h-screen bg-white text-black">

<!-- Header -->
<header class="border-b border-zinc-400/30 bg-gray-200/50">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

<!-- Step Progress -->
 <div class="bg-gradient-to-r from-[#b90606] to-[#ff1a1a] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between text-white">
    <h1 class="text-4xl font-bold"><?= $editMode ? "Edit Album" : "Create Album" ?></h1>

    <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold">4 <span class="text-xs">/ 4</span></div>
            
          </div>
        </div>
        <div class="text-sm font-semibold">Final Step</div>
      </div>
    </div>
  </div>

<!-- Content -->
 <div class="container mx-auto px-6 py-12 max-w-4xl">

    <div class="bg-card border-b border-zinc-400/30 rounded-lg p-8">


    <h2 class="text-3xl font-bold mb-2">Upload Artwork</h2>
    <p class="text-muted text-sm mb-6">
      Upload the cover art for your album. Minimum 3000×3000 recommended.
    </p>

    <?php if (!empty($upload_error)): ?>
      <div class="text-red-400 mb-4"><?= $upload_error ?></div>
    <?php endif; ?>

    <form method="post"
          action="<?= base_url($editMode ? 'UploadAlbum/edit_step4' : 'UploadAlbum/step4'); ?>"
          enctype="multipart/form-data"
          class="space-y-6">

      <!-- CSRF -->
      <input type="hidden"
        name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">

      <!-- ARTWORK PREVIEW (Only edit or session saved) -->
      <?php if ($existing_cover): ?>
        <div class="space-y-2">
          <label class="text-sm font-semibold">Current Artwork</label>
          <img src="<?= base_url($existing_cover) ?>"
               class="w-48 h-48 object-cover rounded shadow border border-border">
        </div>

        <!-- Keep old cover -->
        <input type="hidden" name="old_cover_art" value="<?= $existing_cover ?>">
      <?php endif; ?>

      <!-- Upload New Artwork -->
      <div class="space-y-2">
        <label class="text-sm font-semibold">Upload Artwork <?= $editMode ? "(optional)" : "*" ?></label>
        <input type="file"
               name="cover_art"
               accept=".jpg,.jpeg,.png"
               class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2 <?= !$existing_cover ? 'required' : '' ?>">
        <p class="text-xs text-muted">JPG or PNG only. Min 3000×3000 recommended.</p>
      </div>

      <!-- Template Selector -->
      <div class="space-y-2">
        <label class="text-sm font-semibold">Artwork Template (Optional)</label>
        <select name="template"
                class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2">
          <option value="">None</option>
          <option value="clean" <?= $existing_template == "clean" ? "selected" : "" ?>>Clean Minimal</option>
          <option value="retro" <?= $existing_template == "retro" ? "selected" : "" ?>>Retro Style</option>
          <option value="vintage" <?= $existing_template == "vintage" ? "selected" : "" ?>>Vintage Overlay</option>
          <option value="glow" <?= $existing_template == "glow" ? "selected" : "" ?>>Glow Neon</option>
        </select>
      </div>

      <!-- Continue -->
      <div class="flex justify-between pt-6">
        <a href="<?= base_url('UploadAlbum/step3') ?>"
             class="px-8 py-3 border border-border rounded-lg hover:bg-white/10">
            ← BACK
          </a>
        <button type="submit"
                class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
          CONTINUE →
        </button>
      </div>

    </form>

  </div>
</div>

<script>lucide.createIcons();</script>

</body>
</html>
