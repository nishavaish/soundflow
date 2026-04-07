<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Stores & Social Platforms – SoundFlow</title>

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
          <div class="text-2xl font-bold">1</div>
          <div class="text-xs">/</div>
          <div class="text-sm">4</div>
        </div>
      </div>
      <div class="text-sm font-semibold">Steps Completed</div>
    </div>
  </div>
</div>

<div class="container mx-auto px-6 py-12 max-w-5xl">
  <div class="bg-card border border-border rounded-lg p-8">
    <h2 class="text-3xl font-bold mb-4">Stores & Social Platforms</h2>
    <p class="text-muted mb-8">Select where you want to distribute your music.</p>

    <form method="post" action="<?= base_url('UploadSingle/stores') ?>">

      <!-- Digital Stores -->
      <div class="mb-12">
        <h3 class="text-2xl font-semibold mb-4">Digital Stores</h3>

        <div class="grid md:grid-cols-2 gap-4" id="stores-list"></div>
      </div>

      <!-- Social Platforms -->
      <div class="mb-10">
        <h3 class="text-2xl font-semibold mb-4">Social Platforms</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <label class="flex items-center gap-4 bg-[#121212] p-4 border border-[#1e1e1e] rounded-lg cursor-pointer hover:border-primary transition">
            <div class="w-12 h-12 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold text-sm">YT</div>
            <div class="flex-1"><div class="font-semibold">YouTube Content ID</div></div>
            <input type="checkbox" name="social[]" value="youtube" class="w-5 h-5 accent-primary">
          </label>

          <label class="flex items-center gap-4 bg-[#121212] p-4 border border-[#1e1e1e] rounded-lg cursor-pointer hover:border-primary transition">
            <div class="w-12 h-12 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold text-sm">TT</div>
            <div class="flex-1"><div class="font-semibold">TikTok</div></div>
            <input type="checkbox" name="social[]" value="tiktok" class="w-5 h-5 accent-primary">
          </label>

          <label class="flex items-center gap-4 bg-[#121212] p-4 border border-[#1e1e1e] rounded-lg cursor-pointer hover:border-primary transition">
            <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-sm">FB</div>
            <div class="flex-1"><div class="font-semibold">Facebook</div></div>
            <input type="checkbox" name="social[]" value="facebook" class="w-5 h-5 accent-primary">
          </label>

          <label class="flex items-center gap-4 bg-[#121212] p-4 border border-[#1e1e1e] rounded-lg cursor-pointer hover:border-primary transition">
            <div class="w-12 h-12 rounded-lg bg-pink-600 flex items-center justify-center text-white font-bold text-sm">IG</div>
            <div class="flex-1"><div class="font-semibold">Instagram</div></div>
            <input type="checkbox" name="social[]" value="instagram" class="w-5 h-5 accent-primary">
          </label>

          <label class="flex items-center gap-4 bg-[#121212] p-4 border border-[#1e1e1e] rounded-lg cursor-pointer hover:border-primary transition">
            <div class="w-12 h-12 rounded-lg bg-purple-600 flex items-center justify-center text-white font-bold text-sm">YM</div>
            <div class="flex-1"><div class="font-semibold">YouTube Music</div></div>
            <input type="checkbox" name="social[]" value="youtube-music" class="w-5 h-5 accent-primary">
          </label>
        </div>
      </div>

      <div class="flex items-center justify-between mt-12">
        <a href="<?= base_url('UploadSingle/release_details') ?>"
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

  const stores = [
    "iTunes", "Apple Music", "Spotify", "Amazon Music", "Pandora",
    "Deezer", "Tencent", "Snapchat / 7digital", "Boom", "NetEase",
    "Gaana", "Joox", "Qobuz", "Peloton", "Douyin", "MediaNet",
    "Tidal", "Gracenote", "YouTube Music / Telmore Musik", "KKBox",
    "Music Island", "Anghami", "Yandex", "ClaroMusica", "Zvooq",
    "JioSaavn", "Kuack", "Boomplay"
  ];

  const storesContainer = document.getElementById('stores-list');

  stores.forEach(store => {
    const short = store.substring(0, 2).toUpperCase();
    const safeValue = store.toLowerCase().replace(/[^a-z0-9]+/g, '-');

    storesContainer.innerHTML += `
      <label class="flex items-center gap-4 bg-[#121212] p-4 border border-[#1e1e1e] rounded-lg cursor-pointer hover:border-primary transition">
        <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center text-black font-bold text-sm">${short}</div>
        <div class="flex-1">
          <div class="font-semibold">${store}</div>
        </div>
        <input type="checkbox" name="stores[]" value="${safeValue}" class="w-5 h-5 accent-primary">
      </label>
    `;
  });
</script>

</body>
</html>
