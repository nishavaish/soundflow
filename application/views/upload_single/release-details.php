<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Release Details – SoundFlow</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#6366F1",
            background: "#000000",
            border: "#27272a",
            muted: "#9ca3af",
            card: "#0f0f0f"
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-black to-[#1b0e26] text-white">

  <!-- Header -->
  <header class="border-b border-border bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- Step Header -->
  <div class="bg-gradient-to-r from-[#3b2e10] to-[#401720] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold">Create Single</h1>

      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center">
            <div class="text-2xl font-bold">0</div>
            <div class="text-xs">/</div>
            <div class="text-sm">4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">
          Steps Completed
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-3xl">

    <div class="bg-card border border-border rounded-lg p-8">
      <h2 class="text-3xl font-bold mb-6">Release Details</h2>

      <p class="text-muted mb-6">
        Let's start by getting some basic information about your release.
      </p>

      <form method="post" action="<?= base_url('UploadSingle/release_details') ?>" class="space-y-6">
        <!-- Track Title -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="track_title">Track Title *</label>
          <input type="text" id="track_title" name="track_title"
                 class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
        </div>

        <!-- Primary Artist -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="primary_artist">Primary Artist *</label>
          <input type="text" id="primary_artist" name="primary_artist"
                 class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
        </div>

        <!-- Featuring -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="featuring">Featuring Artists (Optional)</label>
          <input type="text" id="featuring" name="featuring"
                 class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2">
        </div>

        <!-- Genre + Subgenre -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-sm font-semibold" for="genre">Genre *</label>
            <select id="genre" name="genre"
                    class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
              <option value="">Select genre</option>
              <option value="pop">Pop</option>
              <option value="rock">Rock</option>
              <option value="hiphop">Hip Hop</option>
              <option value="rnb">R&B </option>
              <option value="electronic">Electronic</option>
              <option value="country">Country</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold" for="subgenre">Subgenre</label>
            <select id="subgenre" name="subgenre"
                    class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2">
              <option value="">Select subgenre</option>
              <option value="indie">Indie</option>
              <option value="alternative">Alternative</option>
              <option value="trap">Trap</option>
              <option value="house">House</option>
            </select>
          </div>
        </div>

        <!-- Release date -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="release_date">Release Date *</label>
          <input type="date" id="release_date" name="release_date"
                 class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
        </div>

        <!-- Language -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="language">Language *</label>
          <select id="language" name="language"
                  class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
            <option value="">Select language</option>
            <option value="english">English</option>
            <option value="spanish">Spanish</option>
            <option value="french">French</option>
            <option value="hindi">Hindi</option>
            <option value="other">Other</option>
          </select>
        </div>

        <!-- ISRC -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="isrc">ISRC (Optional)</label>
          <input type="text" id="isrc" name="isrc"
                 class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2">
        </div>

        <!-- Description -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="description">Description (Optional)</label>
          <textarea id="description" name="description" rows="4"
                    class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2"></textarea>
        </div>

        <!-- Explicit -->
        <div class="space-y-2">
          <label class="text-sm font-semibold" for="explicit_content">Explicit Content?</label>
          <select id="explicit_content" name="explicit_content"
                  class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2">
            <option value="no">No - Clean</option>
            <option value="yes">Yes - Explicit</option>
          </select>
        </div>

        <!-- Next Button -->
        <div class="pt-6 flex justify-end">
          <button type="submit"
                  class="bg-gradient-to-r from-primary to-[#4e6bff] hover:opacity-90 px-8 py-3 rounded-lg font-semibold">
            NEXT →
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
