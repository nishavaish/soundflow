<?php
// Detect edit mode
$editMode = isset($stores) || isset($social);

$step2 = $this->session->userdata('album_step2') ?? [];

$selectedStores = $editMode ? ($stores ?? []) : ($step2['stores'] ?? []);
$selectedSocial = $editMode ? ($social ?? []) : ($step2['social'] ?? []);

// Helper to check box
function isChecked($value, $array) {
    return in_array($value, (array)$array) ? 'checked' : '';
}

// Store & social options
$storeOptions__old = [
    'spotify' => 'Spotify',
    'apple' => 'Apple Music',
    'youtube' => 'YouTube Music',
    'amazon' => 'Amazon Music',
    'tidal' => 'Tidal',
];

$socialOptions_old = [
    'instagram' => 'Instagram',
    'facebook' => 'Facebook',
    'tiktok' => 'TikTok',
    'youtube' => 'YouTube',
];

?>


 <?php 
	 
	 $storeOptions = array();
	 $socialOptions = array();
	 
	 foreach ($platforms as $key => $p): 
		if($p['type'] == 'streaming')
			$storeOptions[$key] =   $p['label'] ;
		else 
			$socialOptions[$key] =   $p['label'] ;
     endforeach; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= $editMode ? 'Edit Album – Step 2' : 'Create Album – Step 2' ?></title>

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
    };
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-white text-black">

  <!-- Header -->
  <header class="bg-zinc-200/50 border-b border-zinc-400/30 bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- Step Header -->
  <div class="bg-gradient-to-r from-[#b90606] to-[#ff1a1a] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold text-white"><?= $editMode ? 'Edit Album' : 'Create Album' ?></h1>
      <div class="flex items-center gap-3 text-white">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            
            <div class="text-2xl font-bold">2 <span class="text-xs">/ 4</span></div>
          </div>
        </div>
        <div class="text-sm font-semibold">
          Step 2 of 4
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-4xl">
    <div class="bg-card border-b border-zinc-400/30 rounded-lg p-8">
      <h2 class="text-2xl font-bold mb-2">Stores & Social Links</h2>
      <p class="text-sm text-muted mb-6">
        Select where you want your album to be distributed.
      </p>

      <form method="post" action="<?= base_url($editMode ? 'UploadAlbum/edit_step2' : 'UploadAlbum/step2'); ?>" class="space-y-8">

        <!-- CSRF -->
        <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <!-- Stores -->
        <div>
          <h3 class="text-xl font-semibold mb-3">Digital Stores</h3>

          <div class="grid md:grid-cols-2 gap-4">
            <?php foreach ($storeOptions as $key => $label): ?>
            <label class="flex items-center gap-3 p-4 rounded-lg border-b border-zinc-400/30 bg-white hover:border-primary cursor-pointer">
              <input type="checkbox"
                     name="stores[]"
                     value="<?= $key ?>"
                     <?= isChecked($key, $selectedStores) ?>
                     class="w-5 h-5 accent-primary" />
              <span class="text-sm"><?= $label ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Social -->
        <div>
          <h3 class="text-xl font-semibold mb-3">Social Platforms</h3>

          <div class="grid md:grid-cols-2 gap-4">
            <?php foreach ($socialOptions as $key => $label): ?>
            <label class="flex items-center gap-3 p-4 rounded-lg border-b border-zinc-400/30 bg-white hover:border-primary cursor-pointer">
              <input type="checkbox"
                     name="social[]"
                     value="<?= $key ?>"
                     <?= isChecked($key, $selectedSocial) ?>
                     class="w-5 h-5 accent-primary" />
              <span class="text-sm"><?= $label ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="flex justify-between pt-8">
          <a href="<?= base_url('UploadAlbum/step1') ?>"
            class="px-8 py-3 rounded-lg border border-border hover:bg-white/10 transition">
            ← BACK
          </a>
          <button
            type="submit"
            class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white"
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
