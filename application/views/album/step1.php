<?php
// Detect edit mode
$editMode = isset($album);
$step1 = $this->session->userdata('album_step1') ?? [];

// Utility function to auto-fill fields (edit > session > empty)
function v($key, $album, $step1)
{
  if (!empty($album->$key))
    return $album->$key;
  if (!empty($step1[$key]))
    return $step1[$key];
  return '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= $editMode ? 'Edit Album – Step 1' : 'Create Album – Step 1' ?></title>

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
  <header class="border-b border-border bg-zinc-200/50">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('dashboard'); ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- Progress Header -->
  <div class="bg-gradient-to-r from-[#b90606] to-[#ff1a1a] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold text-white"><?= $editMode ? 'Edit Album' : 'Create Album' ?></h1>
      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold text-white">1 <span class="text-xs">/ 4</span></div>

          </div>
        </div>
        <div class="text-sm font-semibold text-white">
          Step 1 of 4
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-3xl">
    <div class="bg-card border-b border-zinc-400/30 rounded-lg p-8">

      <h2 class="text-3xl font-bold mb-2">Release Details</h2>
      <p class="text-sm text-muted mb-6">
        Let's start by getting some basic information about your release.
      </p>

      <?= validation_errors('<div class="text-red-400 text-sm mb-4">', '</div>'); ?>

      <form method="post"
        action="<?= base_url($editMode ? 'my-albums/edit/step-1/' . $album_id : 'UploadAlbum/step1'); ?>"
        class="space-y-6">

        <!-- CSRF -->
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
          value="<?= $this->security->get_csrf_hash(); ?>">

        <!-- Album Title -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="album-title">Album Title *</label>
          <input type="text" id="album-title" name="album_title"
            value="<?= v('album_title', $album ?? null, $step1); ?>"
            class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
            placeholder="Enter your album title" required>
        </div>

        <!-- Artist -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="artist">Primary Artist *</label>
          <input type="text" id="artist" name="artist" value="<?= v('artist', $album ?? null, $step1); ?>"
            class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
            placeholder="Enter artist name" required>
        </div>

        <!-- Featuring -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="featuring">Featuring Artists (Optional)</label>
          <input type="text" id="featuring" name="featuring" value="<?= v('featuring', $album ?? null, $step1); ?>"
            class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
            placeholder="Add featuring artists">
        </div>

        <!-- Album Type & Number of Tracks -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <div class="space-y-2">
            <label class="text-sm font-semibold">Album Type *</label>
            <select name="album_type" class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
              required>
              <option value="">Select type</option>
              <option value="album" <?= v('album_type', $album ?? null, $step1) == 'album' ? 'selected' : '' ?>>Album
              </option>
              <option value="ep" <?= v('album_type', $album ?? null, $step1) == 'ep' ? 'selected' : '' ?>>EP</option>
              <option value="compilation" <?= v('album_type', $album ?? null, $step1) == 'compilation' ? 'selected' : '' ?>>Compilation</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold" for="num-tracks">Number of Tracks *</label>
            <input type="number" id="num-tracks" name="num_tracks" min="1"
              value="<?= v('num_tracks', $album ?? null, $step1); ?>"
              class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary" placeholder="e.g., 10"
              required>
          </div>
        </div>

        <!-- Genre / Subgenre -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <div class="space-y-2">
            <label class="text-sm font-semibold">Genre *</label>
            <select name="genre" class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary" required>
              <option value="">Select genre</option>
              <?php
              $genres = ['pop', 'rock', 'hiphop', 'rnb', 'electronic', 'country', 'jazz', 'classical'];
              foreach ($genres as $g):
                ?>
                <option value="<?= $g ?>" <?= v('genre', $album ?? null, $step1) == $g ? 'selected' : '' ?>>
                  <?= ucfirst($g) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold">Subgenre</label>
            <select name="subgenre" class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
              <option value="">Select subgenre</option>
              <?php
              $subs = ['indie', 'alternative', 'trap', 'house'];
              foreach ($subs as $s):
                ?>
                <option value="<?= $s ?>" <?= v('subgenre', $album ?? null, $step1) == $s ? 'selected' : '' ?>>
                  <?= ucfirst($s) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Release Date -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="release-date">Release Date *</label>
          <input type="date" id="release-date" name="release_date"
            value="<?= v('release_date', $album ?? null, $step1); ?>"
            class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary" required>
        </div>

        <!-- Language -->
        <div class="space-y-2">
          <label class="text-sm font-semibold">Language *</label>
          <select name="language" class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
            required>
            <option value="">Select language</option>
            <?php
            $langs = ['english', 'spanish', 'french', 'german', 'hindi', 'other'];
            foreach ($langs as $l):
              ?>
              <option value="<?= $l ?>" <?= v('language', $album ?? null, $step1) == $l ? 'selected' : '' ?>>
                <?= ucfirst($l) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- UPC -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="upc">UPC Code (Optional)</label>
          <div class="flex gap-2">
            <input type="text" id="upc" name="upc_code" value="<?= v('upc_code', $album ?? null, $step1); ?>"
              class="flex-1 bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
              placeholder="We'll generate one if blank">
            <button type="button" class="border border-border rounded-lg px-4 text-sm hover:bg-white/5">
              Generate
            </button>
          </div>
          <p class="text-xs text-muted">UPC is a unique code for your album</p>
        </div>

        <!-- Label -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="label">Record Label (Optional)</label>
          <input type="text" id="label" name="label" value="<?= v('label', $album ?? null, $step1); ?>"
            class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
        </div>

        <!-- Description -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="description">Album Description (Optional)</label>
          <textarea id="description" name="description" rows="4"
            class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary"><?= v('description', $album ?? null, $step1); ?></textarea>
        </div>

        <!-- Explicit -->
        <div class="space-y-2">
          <label class="text-sm font-semibold">Explicit Content</label>
          <select name="explicit" class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
            <option value="">Select</option>
            <option value="no" <?= v('explicit', $album ?? null, $step1) == 'no' ? 'selected' : '' ?>>No - Clean</option>
            <option value="yes" <?= v('explicit', $album ?? null, $step1) == 'yes' ? 'selected' : '' ?>>Yes - Explicit
            </option>
            <option value="partial" <?= v('explicit', $album ?? null, $step1) == 'partial' ? 'selected' : '' ?>>Partial
            </option>
          </select>
        </div>

        <!-- Continue -->
        <div class="flex justify-end pt-6">
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