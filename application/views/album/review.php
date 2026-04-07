<?php
$step1 = $step1 ?? [];
$step2 = $step2 ?? [];
$step3 = $step3 ?? [];
$step4 = $step4 ?? [];

$editMode = isset($edit_album_id);

// CSRF
$csrf_name = $this->security->get_csrf_token_name();
$csrf_hash = $this->security->get_csrf_hash();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Review Album</title>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: "#ff531a",
        background: "#000",
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

<body class="bg-white min-h-screen text-black">

  <?php $this->view('page_header'); ?>


<!-- Header -->
<header class="border-b border-border bg-black">
  <div class="container mx-auto px-6 h-16 flex items-center justify-between">
    <a href="<?= base_url('dashboard'); ?>" class="flex items-center gap-2">
      <i data-lucide="music" class="w-8 h-8 text-primary"></i>
      <span class="text-2xl font-bold">SoundFlow</span>
    </a>
  </div>
</header>

<!-- Step Header -->
<div class="bg-gradient-to-r from-yellow-700 to-red-700 py-6">
  <div class="container mx-auto px-6 flex items-center justify-between">

    <h1 class="text-4xl font-bold">
      <?= $editMode ? "Edit Album – Review" : "Create Album – Review" ?>
    </h1>

    <div class="flex items-center gap-3">
      <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
        <div class="text-center leading-tight">
          <div class="text-2xl font-bold">Review</div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Content -->
<div class="container mx-auto px-6 py-12 max-w-5xl">

  <div class="bg-card border border-border rounded-lg p-8 space-y-10">

    <!-- ARTWORK + BASIC INFO -->
    <div class="flex flex-col md:flex-row gap-6">

      <!-- Artwork -->
      <img src="<?= base_url($step4['cover_art']) ?>"
           class="w-56 h-56 rounded shadow object-cover border border-border">

      <!-- Info -->
      <div class="flex-1">
        <h2 class="text-3xl font-bold mb-2"><?= $step1['album_title']; ?></h2>
        <p class="text-lg text-muted"><?= $step1['artist']; ?></p>

        <?php if (!empty($step1['featuring'])): ?>
          <p class="text-sm text-muted mt-1">Featuring: <?= $step1['featuring']; ?></p>
        <?php endif; ?>

        <div class="mt-4 text-sm space-y-1">
          <p><b>Genre:</b> <?= ucfirst($step1['genre']); ?></p>
          <p><b>Subgenre:</b> <?= ucfirst($step1['subgenre']); ?></p>
          <p><b>Release Date:</b> <?= $step1['release_date']; ?></p>
          <p><b>Language:</b> <?= ucfirst($step1['language']); ?></p>
          <p><b>Album Type:</b> <?= ucfirst($step1['album_type']); ?></p>

          <?php if (!empty($step1['upc_code'])): ?>
            <p><b>UPC:</b> <?= $step1['upc_code']; ?></p>
          <?php endif; ?>

          <?php if (!empty($step1['label'])): ?>
            <p><b>Label:</b> <?= $step1['label']; ?></p>
          <?php endif; ?>

          <?php if (!empty($step1['description'])): ?>
            <p><b>Description:</b> <?= nl2br($step1['description']); ?></p>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <hr class="border-border">

    <!-- STORES -->
    <div>
      <h3 class="text-xl font-bold mb-3">Digital Stores</h3>

      <?php if (!empty($step2['stores'])): ?>
        <div class="flex flex-wrap gap-3 text-sm">
          <?php foreach ($step2['stores'] as $store): ?>
            <span class="px-3 py-1 bg-[#111] border border-border rounded">
              <?= ucfirst($store); ?>
            </span>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted text-sm">No stores selected.</p>
      <?php endif; ?>
    </div>

    <hr class="border-border">

    <!-- SOCIAL LINKS -->
    <div>
      <h3 class="text-xl font-bold mb-3">Social Platforms</h3>

      <?php if (!empty($step2['social'])): ?>
        <div class="flex flex-wrap gap-3 text-sm">
          <?php foreach ($step2['social'] as $s): ?>
            <span class="px-3 py-1 bg-[#111] border border-border rounded">
              <?= ucfirst($s); ?>
            </span>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted text-sm">No social platforms selected.</p>
      <?php endif; ?>
    </div>

    <hr class="border-border">

    <!-- TRACKLIST -->
    <div>
      <h3 class="text-xl font-bold mb-3">Tracklist</h3>

      <div class="space-y-3">

        <?php foreach ($step3 as $i => $track): ?>
          <div class="p-4 bg-[#111] border border-border rounded flex items-center justify-between">
            <div>
              <div class="font-semibold"><?= ($i + 1) . ". " . $track['track_title'] ?></div>

              <div class="text-sm text-muted">
                <?php if (!empty($track['artists'])): ?>
                  <div>Artists: <?= $track['artists'] ?></div>
                <?php endif; ?>

                <?php if (!empty($track['songwriters'])): ?>
                  <div>Writers: <?= $track['songwriters'] ?></div>
                <?php endif; ?>

                <?php if (!empty($track['producers'])): ?>
                  <div>Producers: <?= $track['producers'] ?></div>
                <?php endif; ?>

                <div>Explicit: <?= $track['is_explicit'] ? "Yes" : "No" ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>

    <hr class="border-border">

    <!-- SUBMIT -->
    <form method="post" action="<?= base_url('UploadAlbum/submit'); ?>" class="flex justify-end">
      <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

      <button
        type="submit"
        class="bg-gradient-to-r from-primary to-blue-500 px-8 py-3 rounded-lg text-sm font-semibold hover:opacity-90"
      >
        <?= $editMode ? "UPDATE ALBUM" : "PUBLISH ALBUM" ?>
      </button>
    </form>

  </div>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>
