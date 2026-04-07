<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Track Details – SoundFlow</title>

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
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-black to-[#1b0e26] text-white">

<header class="border-b border-border bg-black">
  <div class="container mx-auto px-6 h-16 flex items-center justify-between">
    <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
      <i data-lucide="music" class="w-8 h-8 text-primary"></i>
      <span class="text-2xl font-bold">SoundFlow</span>
    </a>
  </div>
</header>

<div class="bg-gradient-to-r from-[#3b2e10] to-[#401720] py-6">
  <div class="container mx-auto px-6 flex items-center justify-between">
    <h1 class="text-4xl font-bold">Create Single</h1>
    <div class="flex items-center gap-3">
      <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
        <div class="text-center">
          <div class="text-2xl font-bold">2</div>
          <div class="text-xs">/</div>
          <div class="text-sm">4</div>
        </div>
      </div>
      <div class="text-sm font-semibold">Steps Completed</div>
    </div>
  </div>
</div>

<div class="container mx-auto px-6 py-12 max-w-4xl">
  <div class="bg-card border border-border rounded-lg p-8">
    <h2 class="text-3xl font-bold mb-6">Track Details</h2>

    <form method="post" action="<?= base_url('UploadSingle/tracks') ?>">

      <!-- Audio Upload -->
      <div class="bg-[#111111] border border-[#2a2a2a] rounded-lg p-8 mb-10">
        <h3 class="text-xl font-semibold mb-4">Upload Audio File</h3>

        <div class="border border-dashed border-border rounded-lg p-8 text-center hover:border-primary transition cursor-pointer"
             onclick="document.getElementById('audio_file').click()">
          <i data-lucide="upload" class="w-12 h-12 mx-auto text-muted mb-4"></i>
          <p class="text-sm mb-2">Click to upload or drag & drop</p>
          <p class="text-xs text-muted">WAV / MP3 recommended</p>
          <input type="file" id="audio_file" name="audio_file" accept="audio/*" hidden>
        </div>
      </div>

      <!-- Song Title -->
      <div class="space-y-2 mb-6">
        <label class="text-sm font-semibold" for="song_title">Song Title *</label>
        <input type="text" id="song_title" name="song_title"
               class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
      </div>

      <!-- Add Version Info -->
      <button type="button" class="text-primary font-semibold text-sm mb-8">
        + Add Version Info
      </button>

      <!-- Songwriters -->
      <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Songwriter *</h3>
        <div id="songwriters"></div>
        <button type="button" onclick="addSongwriter()"
                class="text-primary font-semibold text-sm mt-3">+ Add Songwriter</button>
      </div>

      <!-- Main Artists -->
      <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Main Artists & Creatives (Recommended)</h3>
        <div id="mainArtists"></div>
        <button type="button" onclick="addMainArtist()"
                class="text-primary font-semibold text-sm mt-3">+ Add Artist</button>
      </div>

      <!-- Performing Artists -->
      <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Performing Artists *</h3>
        <div id="performingArtists"></div>
        <button type="button" onclick="addPerformingArtist()"
                class="text-primary font-semibold text-sm mt-3">+ Add Performing Artist</button>
      </div>

      <!-- Producers -->
      <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Producers & Engineers *</h3>
        <div id="producers"></div>
        <button type="button" onclick="addProducer()"
                class="text-primary font-semibold text-sm mt-3">+ Add Producer / Engineer</button>
      </div>

      <!-- Lyrics -->
      <div class="mb-10">
        <label class="text-xl font-semibold mb-2" for="lyrics">Lyrics (Recommended)</label>
        <textarea id="lyrics" name="lyrics" rows="6"
                  class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2"></textarea>
      </div>

      <!-- Language of Lyrical -->
      <div class="mb-10">
        <label class="text-sm font-semibold" for="language_lyrical">Language of Lyrical *</label>
        <input type="text" id="language_lyrical" name="language_lyrical"
               class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" required>
      </div>

      <!-- Explicit Lyrics -->
      <div class="mb-10">
        <label class="text-sm font-semibold">Explicit Lyrics?</label>
        <div class="flex gap-3 mt-2">
          <label class="px-4 py-2 border border-border rounded-lg bg-[#111] cursor-pointer">
            <input type="radio" name="explicit_lyrics" value="yes" class="hidden">
            Yes
          </label>
          <label class="px-4 py-2 border border-border rounded-lg bg-[#111] cursor-pointer">
            <input type="radio" name="explicit_lyrics" value="no" class="hidden">
            No
          </label>
        </div>
      </div>

      <!-- TikTok Clip -->
      <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">TikTok Clip Start Time (Optional)</h3>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="text-sm" for="minutes">Minutes</label>
            <input type="number" id="minutes" name="minutes"
                   class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" min="0">
          </div>
          <div>
            <label class="text-sm" for="seconds">Seconds</label>
            <input type="number" id="seconds" name="seconds"
                   class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2" min="0" max="59">
          </div>
        </div>
      </div>

      <div class="flex justify-between mt-12">
        <a href="<?= base_url('UploadSingle/stores') ?>"
           class="px-8 py-3 border border-white/30 rounded-lg hover:bg-white/10 font-semibold">
          ← BACK
        </a>
        <button type="submit"
                class="px-8 py-3 bg-gradient-to-r from-primary to-[#4e6bff] rounded-lg font-semibold hover:opacity-90">
          NEXT →
        </button>
      </div>

    </form>
  </div>
</div>

<script>
  lucide.createIcons();

  function roleDropdown(name) {
    return `
      <select name="${name}[]" class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2">
        <option value="">Choose Role</option>
        <option value="main-artist">Main Artist</option>
        <option value="featured">Featured</option>
        <option value="producer">Producer</option>
        <option value="composer">Composer</option>
        <option value="lyricist">Lyricist</option>
        <option value="vocalist">Vocalist</option>
        <option value="instrumentalist">Instrumentalist</option>
        <option value="engineer">Engineer</option>
        <option value="mixer">Mixer</option>
        <option value="mastering">Mastering Engineer</option>
      </select>
    `;
  }

  function addField(containerId, baseName, includeRole) {
    const id = Date.now();
    const container = document.getElementById(containerId);
    const wrapperId = `${containerId}-${id}`;

    const roleHtml = includeRole ? `<div class="flex-1">${roleDropdown(baseName + '_roles')}</div>` : '';

    const html = `
      <div class="flex gap-2 mb-3" id="${wrapperId}">
        <input type="text" name="${baseName}[]" placeholder="Name"
               class="flex-1 bg-[#0a0a0a] border border-border rounded-lg px-4 py-2">
        ${roleHtml}
        <button type="button" onclick="removeField('${wrapperId}')"
                class="p-2 bg-[#111] rounded-lg hover:bg-red-600">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    lucide.createIcons();
  }

  function removeField(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
  }

  function addSongwriter()      { addField('songwriters',        'songwriters',        false); }
  function addMainArtist()      { addField('mainArtists',        'main_artists',       true); }
  function addPerformingArtist(){ addField('performingArtists',  'performing_artists', true); }
  function addProducer()        { addField('producers',          'producers',          true); }

  // Initial fields
  addSongwriter();
  addMainArtist();
  addPerformingArtist();
  addProducer();
</script>

</body>
</html>
