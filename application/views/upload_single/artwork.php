<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Artwork – SoundFlow</title>

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
          <div class="text-2xl font-bold">3</div>
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
    <h2 class="text-3xl font-bold mb-4">Artwork</h2>
    <p class="text-muted mb-6">
      Upload your cover art or choose from pre-built templates.
    </p>

    <form method="post" action="<?= base_url('UploadSingle/artwork') ?>" enctype="multipart/form-data">

      <!-- Intro -->
      <div class="mb-8">
        <h3 class="text-xl font-semibold mb-2">Add Cover Art</h3>
        <p class="text-sm text-muted">
          Make sure your artwork meets our guidelines to avoid delays during distribution.
        </p>
      </div>

      <!-- Guidelines -->
      <div class="mb-8">
        <button type="button" id="toggleGuidelines"
                class="text-primary font-semibold text-sm flex items-center gap-2">
          <span>Show Artwork Guidelines</span>
          <i data-lucide="chevron-down" class="w-4 h-4"></i>
        </button>

        <div id="guidelinesBox" class="mt-4 hidden">
          <ul class="list-disc list-inside space-y-2 text-sm text-muted ml-2">
            <li>JPG, PNG or GIF image file smaller than 10MB.</li>
            <li>File must be in RGB mode.</li>
            <li>At least 1600 x 1600 pixels in size (3000x3000 recommended).</li>
            <li>No social media links, URLs, contact info or pricing info.</li>
            <li>No “New”, “Exclusive”, or promotional stickers.</li>
            <li>No store logos or streaming platform logos.</li>
          </ul>
        </div>
      </div>

      <!-- Upload -->
      <div class="mb-10">
        <h3 class="text-lg font-semibold mb-3">Upload Artwork</h3>

        <div class="flex flex-wrap gap-4 items-center">
          <button type="button" id="uploadArtworkBtn"
                  class="px-6 py-3 border border-white/30 rounded-lg hover:bg-white/10 font-semibold flex items-center gap-2">
            <i data-lucide="upload" class="w-4 h-4"></i>
            <span>Upload Artwork File</span>
          </button>

          <button type="button"
                  class="px-6 py-3 border border-white/30 rounded-lg hover:bg-white/10 font-semibold flex items-center gap-2">
            <i data-lucide="image" class="w-4 h-4"></i>
            <span>Cover Art Creator</span>
          </button>
        </div>

        <input type="file" id="artworkInput" name="artwork_file" accept="image/*" hidden>
        <p id="artworkFileName" class="text-xs text-muted mt-2"></p>
      </div>

      <!-- Templates -->
      <div class="mb-10">
        <h3 class="text-lg font-semibold mb-4">Or choose one of our cover art templates:</h3>
        <input type="hidden" name="selected_template" id="selected_template">

        <div id="templatesGrid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <!-- JS injects templates -->
        </div>
      </div>

      <!-- Navigation -->
      <div class="flex justify-between mt-12">
        <a href="<?= base_url('UploadSingle/tracks') ?>"
           class="px-8 py-3 border border-white/30 rounded-lg hover:bg-white/10 font-semibold">
          ← BACK
        </a>
        <button type="submit"
                class="px-8 py-3 bg-gradient-to-r from-primary to-[#4e6bff] rounded-lg font-semibold hover:opacity-90">
          FINISH
        </button>
      </div>

    </form>
  </div>
</div>

<script>
  lucide.createIcons();

  const toggleBtn       = document.getElementById('toggleGuidelines');
  const guidelinesBox   = document.getElementById('guidelinesBox');
  let guidelinesVisible = false;

  toggleBtn.addEventListener('click', () => {
    guidelinesVisible = !guidelinesVisible;
    guidelinesBox.classList.toggle('hidden', !guidelinesVisible);
    toggleBtn.querySelector('span').textContent =
      guidelinesVisible ? 'Hide Artwork Guidelines' : 'Show Artwork Guidelines';
  });

  const uploadBtn       = document.getElementById('uploadArtworkBtn');
  const artworkInput    = document.getElementById('artworkInput');
  const artworkFileName = document.getElementById('artworkFileName');

  uploadBtn.addEventListener('click', () => artworkInput.click());
  artworkInput.addEventListener('change', e => {
    const file = e.target.files[0];
    artworkFileName.textContent = file ? `Selected: ${file.name}` : '';
  });

  const templatesGrid     = document.getElementById('templatesGrid');
  const selectedTemplateEl= document.getElementById('selected_template');
  let selectedTemplate    = null;

  for (let i = 1; i <= 8; i++) {
    const div = document.createElement('div');
    div.className = `
      template-card
      aspect-square rounded-lg
      bg-gradient-to-br from-[#222] to-[#111]
      cursor-pointer transition-all
      hover:scale-105 border-2 border-transparent
      flex items-center justify-center
    `;
    div.dataset.id = i;
    div.innerHTML = `
      <div class="text-center p-4">
        <div class="text-lg font-bold mb-2">ALBUM NAME</div>
        <div class="text-sm text-primary">ARTIST NAME</div>
      </div>
    `;
    div.addEventListener('click', () => {
      document.querySelectorAll('.template-card').forEach(card => {
        card.classList.remove('border-primary');
        card.classList.add('border-transparent');
      });
      div.classList.remove('border-transparent');
      div.classList.add('border-primary');
      selectedTemplate = i;
      selectedTemplateEl.value = i;
    });
    templatesGrid.appendChild(div);
  }
</script>

</body>
</html>
