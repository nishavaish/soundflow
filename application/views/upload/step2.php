<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Step 2 – Stores & Social Platforms | SoundFlow</title>

  <!-- TailwindCSS -->
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

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-white text-black">



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

  <!-- Header -->
  <header class="bg-zinc-200/50 border-b border-zinc-400/30 bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- Step Banner -->
  <div class="bg-gradient-to-r from-[#b90606] to-[#ff1a1a] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold text-white">Stores & Social Platforms</h1>

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
      <h2 class="text-3xl font-bold mb-2">Select Distribution Platforms</h2>
      <p class="text-sm text-muted mb-8">
        Choose the platforms where your release will be delivered.
      </p>

      <form method="post" action="<?= base_url('UploadSingle/step2') ?>" class="space-y-12">
	  
	     <?php
    $csrf_name = $this->security->get_csrf_token_name();
    $csrf_hash = $this->security->get_csrf_hash();
    ?>
    <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />




        <!-- STORES SECTION -->
        <div>
         
			<div class="flex items-center justify-between mb-4">

			  <h3 class="text-2xl font-semibold">Digital Stores</h3>
			  
			  <label class="flex items-center gap-2 cursor-pointer">
				<input
				  type="checkbox"
				  id="select_all_stores"
				  class="w-5 h-5 accent-primary"
				>
				<span class="text-sm font-semibold">Select All</span>
			  </label>

			</div>
					  
		  
		  
          <div class="grid md:grid-cols-2 gap-4">
            <?php
              $stores = [
			  "itunes" => "iTunes",
                "apple-music" => "Apple Music",
                "spotify" => "Spotify",
                "amazon" => "Amazon Music",
                "pandora" => "Pandora",
                "deezer" => "Deezer",
                "tidal" => "Tidal",
                "boomplay" => "Boomplay",
                "youtube-music" => "YouTube Music",
                "tiktok" => "TikTok Music",
                "gaana" => "Gaana",
                "jiosaavn" => "JioSaavn",
                "snapchat" => "Snapchat",
                "netease" => "NetEase",
                "joox" => "Joox",
                "qobuz" => "Qobuz",
                "peloton" => "Peloton",
              ];
            ?>

            <?php foreach ($storeOptions as $id => $label): ?>
              <label class="flex items-center gap-3 p-4 rounded-lg border-b border-zinc-400/30 bg-white hover:border-primary cursor-pointer">
                <input
                  type="checkbox"
                  name="stores[]"
                  value="<?= $id ?>"
                  <?= in_array($id, $selected_stores ?? []) ? 'checked' : '' ?>
                   class="store-checkbox w-5 h-5 accent-primary"
                >
                <span class="text-sm"><?= $label ?></span>
              </label>
            <?php endforeach; ?>

          </div>
        </div>

        <!-- SOCIAL PLATFORMS SECTION -->
        <div>
          <h3 class="text-2xl font-semibold mb-4">Social Media Platforms</h3>
          <div class="grid md:grid-cols-2 gap-4">

            <?php
              $social = [
                "youtube" => "YouTube Content ID",
                "facebook" => "Facebook",
                "instagram" => "Instagram",
                "tiktok" => "TikTok",
                "youtube-music" => "YouTube Music",
              ];
            ?>

            <?php foreach ($socialOptions as $id => $label): ?>
              <label class="flex items-center gap-3 p-4 rounded-lg border-b border-zinc-400/30 bg-white hover:border-primary cursor-pointer">
                <input
                  type="checkbox"
                  name="social[]"
                  value="<?= $id ?>"
                  <?= in_array($id, $selected_social ?? []) ? 'checked' : '' ?>
                  class="w-5 h-5 accent-primary"
                >
                <span class="text-sm"><?= $label ?></span>
              </label>
            <?php endforeach; ?>

          </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between pt-8">
          <a href="<?= base_url('UploadSingle/step1') ?>"
            class="px-8 py-3 rounded-lg border border-border hover:bg-white/10 transition">
            ← BACK
          </a>

          <button
            type="submit"
            class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white"
          >
            NEXT →
          </button>
        </div>

      </form>
    </div>
  </div>

<script>

document.addEventListener("DOMContentLoaded", function () {

  const selectAll = document.getElementById("select_all_stores");
  const stores = document.querySelectorAll(".store-checkbox");

  function updateSelectAllState() {

    const total = stores.length;
    const checked = document.querySelectorAll(".store-checkbox:checked").length;

    if (checked === 0) {
      selectAll.checked = false;
      selectAll.indeterminate = false;
    }
    else if (checked === total) {
      selectAll.checked = true;
      selectAll.indeterminate = false;
    }
    else {
      selectAll.checked = false;
      selectAll.indeterminate = true;
    }

  }

  selectAll.addEventListener("change", function () {
    stores.forEach(cb => {
      cb.checked = selectAll.checked;
    });
    updateSelectAllState();
  });

  stores.forEach(cb => {
    cb.addEventListener("change", updateSelectAllState);
  });

  updateSelectAllState();

});

</script>
  <script>lucide.createIcons();</script>
</body>
</html>
