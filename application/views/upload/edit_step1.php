<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Step 1 – Release Details | SoundFlow</title>

  <!-- Tailwind CSS -->
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
            card: "#0f0f0f"
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
      <h1 class="text-4xl font-bold text-white">Edit Release — Step 1: Release Details</h1>

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

    <div class="bg-card border border-border rounded-lg p-8">
   
      <p class="text-sm text-muted mb-6">
        Let's start by getting some basic information about your release.
      </p>

      <!-- Validation Errors -->
      <?php if (validation_errors()): ?>
        <div class="mb-6 bg-red-950/60 border border-red-600 text-red-100 text-sm rounded-lg p-4">
          <?= validation_errors('<div>• ', '</div>') ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= base_url('my-releases/edit/step-1/'.$release->id) ?>" class="space-y-6">
	  
	  
	<?php //echo "<pre>";  print_r($release);  echo "<pre>"; ?>
	
	
    <?php
    $csrf_name = $this->security->get_csrf_token_name();
    $csrf_hash = $this->security->get_csrf_hash();
    ?>
    <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />

        <!-- Track Title -->
        <div class="space-y-2">
          <label for="title" class="text-sm font-semibold">Track Title *</label>
          <input
            type="text"
            id="title"
            name="title" value="<?= set_value('title', isset($release->title) ? $release->title : '') ?>"
            required
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
          >
        </div>

        <!-- Primary Artist -->
        <div class="space-y-2">
          <label for="primary_artist" class="text-sm font-semibold">Primary Artist *</label>
          <input
            type="text"
            id="primary_artist"
            name="primary_artist" value="<?= set_value('primary_artist', isset($release->primary_artist) ? $release->primary_artist : '') ?>"
            required
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
          >
        </div>

        <!-- Featuring Artists -->
        <div class="space-y-2">
          <label for="featuring" class="text-sm font-semibold">Featuring Artists (Optional)</label>
          <input
            type="text"
            id="featuring"
            name="featuring" value="<?= set_value('featuring', isset($release->featuring) ? $release->featuring : '') ?>"
            placeholder="Comma-separated list (e.g. Artist A, Artist B)"
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary text-sm"
          >
        </div>

        <!-- Genre + Subgenre -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-2">
		  <?php $current_genre = set_value('genre', $release->genre ?? ''); ?>
            <label for="genre" class="text-sm font-semibold">Genre *</label>
            
				<select id="genre" name="genre" required class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
				  <option value="">Select genre</option>
 
					<?php $genres = $this->config->item('music_genres');  ?>

					<?php foreach ($genres as $key => $genre) { ?>			  
						<option value="<?= $key; ?>"   <?= $current_genre === $key ? 'selected' : '' ?> ><?= $genre['label']; ?></option>
					<?php } ?>
 
					<!--
						 <option value="pop"        <?= $current_genre === 'pop' ? 'selected' : '' ?>>Pop</option>
						  <option value="rock"       <?= $current_genre === 'rock' ? 'selected' : '' ?>>Rock</option>
						  <option value="hiphop"     <?= $current_genre === 'hiphop' ? 'selected' : '' ?>>Hip Hop</option>
						  <option value="rnb"        <?= $current_genre === 'rnb' ? 'selected' : '' ?>>R&amp;B</option>
						  <option value="electronic" <?= $current_genre === 'electronic' ? 'selected' : '' ?>>Electronic</option>
					<option value="country"    <?= $current_genre === 'country' ? 'selected' : '' ?>>Country</option>  -->
					</select>

          </div>

          <div class="space-y-2">
            <label for="subgenre" class="text-sm font-semibold">Subgenre (Optional)</label>
            <select
  id="subgenre"
  name="subgenre"
  class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
>
  <option value="">Select subgenre</option>

  <option value="indie"       
    <?= set_select('subgenre', 'indie',       ($release->subgenre ?? '') === 'indie') ?>
  >Indie</option>

  <option value="alternative"
    <?= set_select('subgenre', 'alternative', ($release->subgenre ?? '') === 'alternative') ?>
  >Alternative</option>

  <option value="trap"        
    <?= set_select('subgenre', 'trap',        ($release->subgenre ?? '') === 'trap') ?>
  >Trap</option>

  <option value="house"       
    <?= set_select('subgenre', 'house',       ($release->subgenre ?? '') === 'house') ?>
  >House</option>
</select>

          </div>
        </div>

        <!-- Release Date -->
        <div class="space-y-2">
          <label for="release_date" class="text-sm font-semibold">Release Date *</label>
          <input
            type="date"
            id="release_date"
            name="release_date" value="<?= set_value('release_date', isset($release->release_date) ? $release->release_date : '') ?>"
            required
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
          >
        </div>

        <!-- Language -->
        <div class="space-y-2">
          <label for="language" class="text-sm font-semibold">Language *</label>
          <?php $current_lang = set_value('language', $release->language ?? ''); ?>

		<select   id="language"   name="language"   required
		  class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
		>
		  <option value="">Select language</option>
		  
		  <?php $languages = $this->config->item('music_languages');  ?>
            <option value="">Select language</option>
			<?php foreach ($languages as $Lkey => $language) { ?>			  
				<option value="<?= $Lkey; ?>"  <?= $current_lang === $Lkey ? 'selected' : '' ?>> <?= $language['label']; ?></option>
			<?php } ?>	  
			<!--
		  <option value="english" <?= $current_lang === 'english' ? 'selected' : '' ?>>English</option>
		  <option value="spanish" <?= $current_lang === 'spanish' ? 'selected' : '' ?>>Spanish</option>
		  <option value="french"  <?= $current_lang === 'french'  ? 'selected' : '' ?>>French</option>
		  <option value="german"  <?= $current_lang === 'german'  ? 'selected' : '' ?>>German</option>
		  <option value="hindi"   <?= $current_lang === 'hindi'   ? 'selected' : '' ?>>Hindi</option>
			<option value="other"   <?= $current_lang === 'other'   ? 'selected' : '' ?>>Other</option>   --> 
		</select>

        </div>

        <!-- ISRC -->
        <div class="space-y-2">
          <label for="isrc" class="text-sm font-semibold">ISRC (Optional)</label>
          <input
            type="text"
            id="isrc"
            name="isrc" value="<?= set_value('isrc', isset($release->isrc) ? $release->isrc : '') ?>"
            placeholder="If empty, system can generate one later"
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary text-sm"
          >
        </div>

        <!-- Description -->
        <div class="space-y-2">
          <label for="description" class="text-sm font-semibold">Description (Optional)</label>
          <textarea
            id="description"
            name="description"
            rows="4"
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary text-sm"
          ><?= set_value('description', isset($release->description) ? $release->description : '') ?></textarea>
        </div>

        <!-- Explicit Content -->
        <div class="space-y-2">
          <label for="explicit_content" class="text-sm font-semibold">Explicit Content?</label>
          <select
            id="explicit_content"
            name="explicit_content"
            class="w-full bg-white border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-primary"
          >
            <option value="no"  <?= set_select('explicit_content', 'no', TRUE) ?>>No - Clean</option>
            <option value="yes" <?= set_select('explicit_content', 'yes') ?>>Yes - Explicit</option>
          </select>
        </div>

        <!-- Submit -->
        <div class="pt-6 flex justify-end">
          <button
            type="submit"
            class="bg-gradient-to-r from-primary to-[#4e6bff] hover:opacity-90 px-8 py-3 rounded-lg font-semibold"
          >
            NEXT →
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
