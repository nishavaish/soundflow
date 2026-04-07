<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
            muted: "#9ca3af",
            card: "#111111"
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-white text-black">
	
	 <header class="border-b border-border bg-zinc-200/50">
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
      <h1 class="text-4xl font-bold text-white"> Edit Release — Step 2: Stores & Social </h1>

      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold text-white">2 <span class="text-xs">/ 4</span></div>
            
          </div>
        </div>
        <div class="text-sm font-semibold text-white">
          Step 2 of 4
        </div>
      </div>
    </div>
  </div>
  
  
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
 
  <div class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto bg-card border border-border rounded p-6">

      
      <?php if ($this->session->flashdata('error')): ?>
        <div class="mb-4 p-3 rounded bg-red-800 text-red-100"><?php echo $this->session->flashdata('error') ?></div>
      <?php endif; ?>

      <?php
        // $release is provided by controller
        // Controller passes selected stores/social as $stores and $social (existing selections).
        // To avoid name collision, treat them as $selected_stores and $selected_social here.

        $selected_stores = [];
        if (!empty($stores)) {
            foreach ($stores as $s) {
                if (is_object($s)) {
                    // release_stores table may have store_key or store_name
                    if (isset($s->store_key) && $s->store_key) $selected_stores[] = $s->store_key;
                    elseif (isset($s->store_name) && $s->store_name) $selected_stores[] = $s->store_name;
                } elseif (is_array($s)) {
                    if (!empty($s['store_key'])) $selected_stores[] = $s['store_key'];
                    elseif (!empty($s['store_name'])) $selected_stores[] = $s['store_name'];
                } else {
                    $selected_stores[] = (string)$s;
                }
            }
        }

        $selected_social = [];
        if (!empty($social)) {
            foreach ($social as $s) {
                if (is_object($s)) {
                    if (isset($s->platform_key) && $s->platform_key) $selected_social[] = $s->platform_key;
                    elseif (isset($s->platform) && $s->platform) $selected_social[] = $s->platform;
                } elseif (is_array($s)) {
                    if (!empty($s['platform_key'])) $selected_social[] = $s['platform_key'];
                    elseif (!empty($s['platform'])) $selected_social[] = $s['platform'];
                } else {
                    $selected_social[] = (string)$s;
                }
            }
        }

        // Define the full list of available stores and social platforms (replace with DB-driven lists if needed)
        /* $all_stores = [
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
          "peloton" => "Peloton"
        ];

        $all_social = [
          "youtube" => "YouTube Content ID",
          "facebook" => "Facebook",
          "instagram" => "Instagram",
          "tiktok" => "TikTok",
          "twitter" => "Twitter",
          "snapchat" => "Snapchat"
        ]; */
		
		 $all_stores = array();
		 $all_social = array();
		 
		 foreach ($platforms as $key => $p): 
			if($p['type'] == 'streaming')
				$all_stores[$key] =   $p['label'] ;
			else 
				$all_social[$key] =   $p['label'] ;
		 endforeach; 
		
		
      ?>

      <?php echo form_open('my-releases/edit/step-2/'.$release->id, ['class' => 'space-y-6']); ?>

        <!-- DIGITAL STORES SECTION -->
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
            <?php foreach ($all_stores as $id => $label): ?>
              <label class="flex items-center gap-3 p-4 rounded-lg border border-border bg-white hover:border-primary cursor-pointer">
                <input
                  type="checkbox"
                  name="stores[]"
                  value="<?php echo html_escape($id) ?>"
                  class="store-checkbox w-5 h-5 accent-primary"
                  <?php echo in_array($id, $selected_stores) ? 'checked' : '' ?>
                >
                <span class="text-sm ml-2"><?php echo html_escape($label) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- SOCIAL PLATFORMS SECTION -->
        <div>
          <h3 class="text-2xl font-semibold mb-4">Social Media Platforms</h3>
          <div class="grid md:grid-cols-2 gap-4">
            <?php foreach ($all_social as $id => $label): ?>
              <label class="flex items-center gap-3 p-4 rounded-lg border border-border bg-white hover:border-primary cursor-pointer">
                <input
                  type="checkbox"
                  name="social[]"
                  value="<?php echo html_escape($id) ?>"
                  class="w-5 h-5 accent-primary"
                  <?php echo in_array($id, $selected_social) ? 'checked' : '' ?>
                >
                <span class="text-sm ml-2"><?php echo html_escape($label) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

     
		
		
		  <div class="flex justify-between pt-8">
          <a href="<?= base_url('my-releases/edit/step-1/'.$release->id) ?>"
             class="px-8 py-3 border border-border rounded-lg hover:bg-white/10">
            ← BACK
          </a>

          <button type="submit"
            class="bg-gradient-to-r from-primary to-[#4e6bff] hover:opacity-90 px-8 py-3 rounded-lg font-semibold">
            Continue to Step 3 →
          </button>
        </div>

      <?php echo form_close(); ?>
    </div>
  </div>

  <script>lucide.createIcons();</script>
  
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

</body>
</html>
