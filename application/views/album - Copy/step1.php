<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Album – Step 1</title>

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

  <!-- Progress Header -->
  <div class="bg-gradient-to-r from-[hsl(45,40%,20%)] to-[hsl(350,40%,20%)] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold">Create Album</h1>
      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold">1</div>
            <div class="text-xs">/ 4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">Step 1 of 4</div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-4xl">
    <div class="bg-card border border-border rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-2">Release Details</h2>
      <p class="text-sm text-muted mb-6">
        Let's start by getting some basic information about your release.
      </p>

      <?= validation_errors('<div class="text-red-400 text-sm mb-4">','</div>'); ?>

      <form method="post" action="<?= base_url('UploadAlbum/step1'); ?>" class="space-y-6">
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="album-title">Album Title *</label>
          <input
            type="text"
            id="album-title"
            name="album_title"
            class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
            placeholder="Enter your album title"
            required
          >
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold" for="artist">Primary Artist *</label>
          <input
            type="text"
            id="artist"
            name="artist"
            class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
            placeholder="Enter artist name"
            required
          >
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold" for="featuring">Featuring Artists (Optional)</label>
          <input
            type="text"
            id="featuring"
            name="featuring"
            class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
            placeholder="Add featuring artists"
          >
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-sm font-semibold">Album Type *</label>
            <select
              name="album_type"
              class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
              required
            >
              <option value="">Select type</option>
              <option value="album">Album</option>
              <option value="ep">EP</option>
              <option value="compilation">Compilation</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold" for="num-tracks">Number of Tracks *</label>
            <input
              type="number"
              id="num-tracks"
              name="num_tracks"
              min="2"
              class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
              placeholder="e.g., 10"
              required
            >
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-sm font-semibold">Genre *</label>
            <select name="genre" class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm" required>
              <option value="">Select genre</option>
              <option value="pop">Pop</option>
              <option value="rock">Rock</option>
              <option value="hiphop">Hip Hop</option>
              <option value="rnb">R&amp;B</option>
              <option value="electronic">Electronic</option>
              <option value="country">Country</option>
              <option value="jazz">Jazz</option>
              <option value="classical">Classical</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold">Subgenre</label>
            <select name="subgenre" class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm">
              <option value="">Select subgenre</option>
              <option value="indie">Indie</option>
              <option value="alternative">Alternative</option>
              <option value="trap">Trap</option>
              <option value="house">House</option>
            </select>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold" for="release-date">Release Date *</label>
          <input
            type="date"
            id="release-date"
            name="release_date"
            class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
            required
          >
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold">Language *</label>
          <select name="language" class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm" required>
            <option value="">Select language</option>
            <option value="english">English</option>
            <option value="spanish">Spanish</option>
            <option value="french">French</option>
            <option value="german">German</option>
            <option value="hindi">Hindi</option>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold" for="upc">UPC Code (Optional)</label>
          <div class="flex gap-2">
            <input
              type="text"
              id="upc"
              name="upc"
              class="flex-1 bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
              placeholder="We'll generate one if blank"
            >
            <button type="button" class="border border-border rounded-lg px-4 text-sm hover:bg-white/5">
              Generate
            </button>
          </div>
          <p class="text-xs text-muted">UPC is a unique code for your album</p>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold" for="label">Record Label (Optional)</label>
          <input
            type="text"
            id="label"
            name="label"
            class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
            placeholder="Enter label name or leave blank"
          >
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold" for="description">Album Description (Optional)</label>
          <textarea
            id="description"
            name="description"
            rows="4"
            class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm"
            placeholder="Tell us about your album..."
          ></textarea>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold">Explicit Content</label>
          <select name="explicit" class="w-full bg-[#050505] border border-border rounded-lg px-3 py-2 text-sm">
            <option value="">Select</option>
            <option value="no">No - Clean</option>
            <option value="yes">Yes - Explicit</option>
            <option value="partial">Partial - Some tracks explicit</option>
          </select>
        </div>

        <div class="flex justify-end pt-6">
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
