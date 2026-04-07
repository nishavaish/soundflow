<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Step 3 – Track Details | SoundFlow</title>

  <!-- Tailwind -->
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

<body class="min-h-screen bg-gradient-to-br from-black to-[#1b0e26] text-white">

  <!-- Header -->
  <header class="border-b border-border bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('Dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- Step Banner -->
  <div class="bg-gradient-to-r from-[#3b2e10] to-[#401720] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold">Edit Release — Step 3:  Track Details</h1>

      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold">3</div>
            <div class="text-xs">/ 4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">Step 3 of 4</div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mx-auto px-6 py-12 max-w-4xl">

    <div class="bg-card border border-border rounded-lg p-8">

      <h2 class="text-3xl font-bold mb-2">Song Information</h2>
      <p class="text-sm text-muted mb-8">
        Upload your audio file and complete the details below.
      </p>

      <?php
      // Prepare data arrays (prefer POST values so input persists on validation error)
      // SONGWRITERS
      $posted_sw = $this->input->post('songwriters');
      if (!empty($posted_sw) && is_array($posted_sw)) {
        $songwriters_list = $posted_sw;
      } elseif (!empty($songwriters) && is_array($songwriters)) {
        // $songwriters passed in from controller (array of names)
        $songwriters_list = $songwriters;
      } elseif (!empty($track->songwriters) && is_string($track->songwriters)) {
        $songwriters_list = array_filter(array_map('trim', explode(',', $track->songwriters)));
      } else {
        $songwriters_list = [''];
      }

      // MAIN ARTISTS
      // Expect $artists['main'] as array of ['name'=>'','role'=>'']
      $posted_main_names = $this->input->post('main_artist_name');
      $posted_main_roles = $this->input->post('main_artist_role');
      $main_artists = [];

      if (!empty($posted_main_names) && is_array($posted_main_names)) {
        $names = $posted_main_names;
        $roles = is_array($posted_main_roles) ? $posted_main_roles : [];
        foreach ($names as $i => $n) {
          $n = trim($n);
          if ($n === '') continue;
          $main_artists[] = [
            'name' => $n,
            'role' => isset($roles[$i]) ? $roles[$i] : ''
          ];
        }
      } elseif (!empty($artists['main']) && is_array($artists['main'])) {
        $main_artists = $artists['main'];
      } else {
        // fallback: try track fields if present
        $main_artists = [['name'=>'','role'=>'lead']];
      }

      // PERFORMING ARTISTS
      $posted_perf_names = $this->input->post('performing_artist_name');
      $posted_perf_roles = $this->input->post('performing_artist_role');
      $performing_artists = [];

      if (!empty($posted_perf_names) && is_array($posted_perf_names)) {
        $names = $posted_perf_names;
        $roles = is_array($posted_perf_roles) ? $posted_perf_roles : [];
        foreach ($names as $i => $n) {
          $n = trim($n);
          if ($n === '') continue;
          $performing_artists[] = [
            'name' => $n,
            'role' => isset($roles[$i]) ? $roles[$i] : ''
          ];
        }
      } elseif (!empty($artists['performing']) && is_array($artists['performing'])) {
        $performing_artists = $artists['performing'];
      } else {
        $performing_artists = [['name'=>'','role'=>'performer']];
      }

      // PRODUCERS
      $posted_prod_names = $this->input->post('producer_name') ?: $this->input->post('producers');
      $posted_prod_roles = $this->input->post('producer_role') ?: $this->input->post('producers_role');
      $producers_list = [];

      if (!empty($posted_prod_names) && is_array($posted_prod_names)) {
        $names = $posted_prod_names;
        $roles = is_array($posted_prod_roles) ? $posted_prod_roles : [];
        foreach ($names as $i => $n) {
          $n = trim($n);
          if ($n === '') continue;
          $producers_list[] = ['name'=>$n, 'role'=> (isset($roles[$i]) ? $roles[$i] : '')];
        }
      } elseif (!empty($producers) && is_array($producers)) {
        $producers_list = $producers;
      } else {
        $producers_list = [['name'=>'','role'=>'']];
      }
      ?>

      <form method="post" enctype="multipart/form-data" action="<?= base_url('my-releases/edit/step-3/'.$release->id) ?>" class="space-y-10">

        <?php
        // CSRF token
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();
        ?>
        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />

        <!-- AUDIO UPLOAD -->
               <!-- AUDIO UPLOAD (shows current file if present, optional replace/remove) -->
        <div class="bg-[#0b0b0b] border border-border rounded-lg p-6">
          <h3 class="text-xl font-semibold mb-3">Audio Upload <?= !empty($track->audio_file) ? '(Optional — existing shown below)' : '*' ?></h3>
          <p class="text-sm text-muted mb-4">
            Accepted: 24-bit WAV/AIFF/FLAC or high-quality MP3
          </p>

          <?php $has_audio = !empty($track->audio_file); ?>

          <?php if ($has_audio): ?>
            <div class="flex gap-6 items-start">
              <div class="flex-shrink-0">
                <!-- Simple audio player preview -->
                <audio controls class="w-64">
                  <source src="<?= base_url($track->audio_file) ?>" />
                  Your browser does not support the audio element.
                </audio>
              </div>

              <div class="flex-1">
                <div class="text-sm text-muted mb-2">Current file:
                  <strong class="text-white"><?= html_escape(basename($track->audio_file)) ?></strong>
                </div>

                <div class="flex gap-2 mb-2">
                  <label for="audio_file" class="px-4 py-2 rounded bg-gray-800 border border-border hover:bg-white/5 cursor-pointer text-sm">
                    Replace audio
                    <input id="audio_file" type="file" name="audio_file" accept=".mp3,.wav,.flac,.aiff" class="hidden">
                  </label>

                 
                </div>

                <p class="text-sm text-muted">Uploading a new audio file will replace the existing one.</p>
              </div>
            </div>

          <?php else: ?>
            <div class="border-2 border-dashed border-border rounded-lg p-10 text-center hover:border-primary transition">
              <i data-lucide="upload" class="w-10 h-10 text-muted mx-auto mb-3"></i>
              <input type="file" name="audio_file" required class="block mx-auto text-sm text-muted" accept=".mp3,.wav,.flac,.aiff">
              <p class="text-sm text-muted mt-3">If you already uploaded a file, it will appear here.</p>
            </div>
          <?php endif; ?>
        </div>


<script>
  document.addEventListener('DOMContentLoaded', function(){
    var replaceLabel = document.querySelector('label[for="audio_file"]');
    if (replaceLabel) {
      replaceLabel.addEventListener('click', function(){ /* native behaviour opens picker */ });
    }
  });
</script>


        <!-- SONG TITLE -->
        <div class="space-y-2">
          <label class="text-sm font-semibold">Song Title <?= form_error('song_title') ? '<span class=\"text-red-400\">*</span>' : '<span class=\"text-muted\">*</span>' ?></label>
          <input
            type="text"
            name="song_title"
            class="w-full bg-[#0a0a0a] border border-border rounded-lg px-4 py-2"
            required
           value="<?= set_value('song_title', isset($track->title) ? $track->title : '') ?>">
        </div>

        <!-- SONGWRITERS -->
        <div class="space-y-4">
          <div class="flex items-center gap-2">
            <label class="text-base font-semibold">Songwriters *</label>
            <i data-lucide="info" class="w-4 h-4 text-yellow-500"></i>
          </div>

          <div id="songwriters">
            <?php foreach ($songwriters_list as $sw): ?>
              <div class="flex gap-2 mb-2 songwriter-field">
                <input type="text" name="songwriters[]" placeholder="Songwriter Name"
                       class="flex-1 bg-[#0b0b0b] border border-border rounded-lg px-3 py-2"
                       value="<?= html_escape($sw) ?>">
                <button type="button" onclick="removeField(this)"
                        class="px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300 hover:bg-red-600/40">
                  X
                </button>
              </div>
            <?php endforeach; ?>
          </div>

          <button type="button" onclick="addSongwriter()"
                  class="text-primary text-sm hover:underline font-semibold">
            + Add Songwriter
          </button>
        </div>

        <!-- MAIN ARTISTS -->
        <div class="space-y-4">
          <label class="text-base font-semibold">Main Artists</label>

          <div id="mainArtists">
            <?php foreach ($main_artists as $ma): ?>
              <div class="artist-row mb-4 p-4 rounded-lg bg-[#0b0b0b] border border-border">
                <input type="text" name="main_artist_name[]" placeholder="Artist Name"
                       class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3"
                       value="<?= html_escape($ma['name']) ?>">

                <label class="text-sm">Role</label>
                <select name="main_artist_role[]"
                        class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
                  <option value="lead" <?= ($ma['role']=='lead'?'selected':'') ?>>Main Artist</option>
                  <option value="featured" <?= ($ma['role']=='featured'?'selected':'') ?>>Featured</option>
                  <option value="producer" <?= ($ma['role']=='producer'?'selected':'') ?>>Producer</option>
                  <option value="composer" <?= ($ma['role']=='composer'?'selected':'') ?>>Composer</option>
                  <option value="lyricist" <?= ($ma['role']=='lyricist'?'selected':'') ?>>Lyricist</option>
                </select>

                <button type="button" onclick="removeField(this)"
                        class="mt-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300 hover:bg-red-600/40">
                  Remove
                </button>
              </div>
            <?php endforeach; ?>
          </div>

          <button type="button" onclick="addMainArtist()"
                  class="text-primary text-sm hover:underline font-semibold">
            + Add Main Artist
          </button>
        </div>

        <!-- PERFORMING ARTISTS -->
        <div class="space-y-4">
          <label class="text-base font-semibold">Performing Artists *</label>

          <div id="performingArtists">
            <?php foreach ($performing_artists as $pa): ?>
              <div class="artist-row mb-4 p-4 rounded-lg bg-[#0b0b0b] border border-border">
                <input type="text" name="performing_artist_name[]" placeholder="Artist Name"
                       class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3"
                       value="<?= html_escape($pa['name']) ?>">

                <label class="text-sm">Role</label>
                <select name="performing_artist_role[]"
                        class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
                  <option value="performer" <?= ($pa['role']=='performer'?'selected':'') ?>>Performer</option>
                  <option value="session" <?= ($pa['role']=='session'?'selected':'') ?>>Session</option>
                  <option value="vocalist" <?= ($pa['role']=='vocalist'?'selected':'') ?>>Vocalist</option>
                  <option value="instrumentalist" <?= ($pa['role']=='instrumentalist'?'selected':'') ?>>Instrumentalist</option>
                  <option value="featured" <?= ($pa['role']=='featured'?'selected':'') ?>>Featured</option>
                  <option value="lyricist" <?= ($pa['role']=='lyricist'?'selected':'') ?>>Lyricist</option>
                </select>

                <button type="button" onclick="removeField(this)"
                        class="mt-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300 hover:bg-red-600/40">
                  Remove
                </button>
              </div>
            <?php endforeach; ?>
          </div>

          <button type="button" onclick="addPerformingArtist()"
                  class="text-primary text-sm hover:underline font-semibold">
            + Add Performing Artist
          </button>
        </div>

        <!-- PRODUCERS -->
        <div class="space-y-4">
          <label class="text-base font-semibold">Producers *</label>

          <div id="producers">
            <?php foreach ($producers_list as $p): ?>
              <div class="artist-row mb-4 p-4 rounded-lg bg-[#0b0b0b] border border-border">
                <input type="text" name="producer_name[]" placeholder="Producer Name"
                       class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3"
                       value="<?= html_escape($p['name']) ?>">

                <label class="text-sm">Role</label>
                <select name="producer_role[]"
                        class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
                  <option value="" <?= ($p['role']==''?'selected':'') ?>>Role</option>
                  <option value="producer" <?= ($p['role']=='producer'?'selected':'') ?>>Producer</option>
                  <option value="engineer" <?= ($p['role']=='engineer'?'selected':'') ?>>Engineer</option>
                  <option value="mixer" <?= ($p['role']=='mixer'?'selected':'') ?>>Mixer</option>
                  <option value="mastering" <?= ($p['role']=='mastering'?'selected':'') ?>>Mastering Engineer</option>
                </select>

                <button type="button" onclick="removeField(this)"
                        class="mt-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300 hover:bg-red-600/40">
                  Remove
                </button>
              </div>
            <?php endforeach; ?>
          </div>

          <button type="button" onclick="addProducer()"
                  class="text-primary text-sm hover:underline font-semibold">
            + Add Producer
          </button>
        </div>

        <!-- COPYRIGHT -->
        <div class="space-y-2">
          <label class="text-base font-semibold">Copyright *</label>
          <?php $current_copyright = set_value('copyright', isset($track->copyright) ? $track->copyright : 'yes'); ?>
          <select name="copyright"
                  class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
            <option value="yes" <?= $current_copyright === 'yes' ? 'selected' : '' ?>>Yes — I own copyright</option>
            <option value="no" <?= $current_copyright === 'no' ? 'selected' : '' ?>>No — Someone else owns it</option>
          </select>
        </div>

        <!-- LYRICS -->
        <div class="space-y-2">
          <label class="text-base font-semibold">Lyrics (Optional)</label>
          <textarea name="lyrics" rows="6"
                    class="w-full bg-[#0b0b0b] border border-border rounded-lg px-3 py-2"><?= set_value('lyrics', isset($track->lyrics) ? $track->lyrics : '') ?></textarea>
        </div>

        <!-- TIKTOK CLIP -->
        <div class="space-y-2">
          <label class="text-base font-semibold">TikTok Clip Start Time (Optional)</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-sm">Minutes</label>
              <input type="number" min="0" name="tiktok_min" placeholder="00"
                     class="w-full bg-[#0b0b0b] border border-border rounded-lg px-3 py-2" value="<?= set_value('tiktok_min', isset($track->tiktok_minutes) ? $track->tiktok_minutes : 0) ?>">
            </div>

            <div>
              <label class="text-sm">Seconds</label>
              <input type="number" min="0" max="59" name="tiktok_sec" placeholder="00"
                     class="w-full bg-[#0b0b0b] border border-border rounded-lg px-3 py-2" value="<?= set_value('tiktok_sec', isset($track->tiktok_seconds) ? $track->tiktok_seconds : 0) ?>">
            </div>
          </div>
        </div>

        <!-- BUTTONS -->
        <div class="flex justify-between pt-8">
          <a href="<?= base_url('my-releases/edit/step-2/'.$release->id) ?>"
             class="px-8 py-3 border border-border rounded-lg hover:bg-white/10">
            ← BACK
          </a>

          <button type="submit"
            class="bg-gradient-to-r from-primary to-[#4e6bff] hover:opacity-90 px-8 py-3 rounded-lg font-semibold">
            Continue to Step 4 →
          </button>
        </div>

      </form>

    </div>
  </div>

  <script>
    lucide.createIcons();

    function removeField(btn) {
      var el = btn.closest('.artist-row') || btn.closest('.songwriter-field');
      if (el) el.remove();
    }

    function addSongwriter() {
      let div = document.createElement("div");
      div.className = "flex gap-2 mb-2 songwriter-field";
      div.innerHTML = `
        <input type="text" name="songwriters[]" class="flex-1 bg-[#0b0b0b] border border-border rounded-lg px-3 py-2">
        <button type="button" onclick="removeField(this)"
                class="px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300">X</button>
      `;
      document.getElementById("songwriters").appendChild(div);
    }

    function addMainArtist() {
      let div = document.createElement("div");
      div.className = "artist-row mb-4 p-4 rounded-lg bg-[#0b0b0b] border border-border";
      div.innerHTML = `
        <input type="text" name="main_artist_name[]" placeholder="Artist Name"
               class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3">

        <label class="text-sm">Role</label>
        <select name="main_artist_role[]" class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
          <option value="lead">Main Artist</option>
          <option value="featured">Featured</option>
          <option value="producer">Producer</option>
          <option value="composer">Composer</option>
          <option value="lyricist">Lyricist</option>
        </select>

        <button type="button" onclick="removeField(this)"
                class="mt-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300">Remove</button>
      `;
      document.getElementById("mainArtists").appendChild(div);
    }

    function addPerformingArtist() {
      let div = document.createElement("div");
      div.className = "artist-row mb-4 p-4 rounded-lg bg-[#0b0b0b] border border-border";
      div.innerHTML = `
        <input type="text" name="performing_artist_name[]" placeholder="Artist Name"
               class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3">

        <label class="text-sm">Role</label>
        <select name="performing_artist_role[]" class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
          <option value="performer" >Performer</option>
		  <option value="session">Session</option>
		  <option value="featured">Featured</option>
		  <option value="vocalist">Vocalist</option>
		  <option value="instrumentalist">Instrumentalist</option>
		  <option value="lyricist">Lyricist</option>
				
        </select>

        <button type="button" onclick="removeField(this)"
                class="mt-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300">Remove</button>
      `;
      document.getElementById("performingArtists").appendChild(div);
    }

    function addProducer() {
      let div = document.createElement("div");
      div.className = "artist-row mb-4 p-4 rounded-lg bg-[#0b0b0b] border border-border";
      div.innerHTML = `
        <input type="text" name="producer_name[]" placeholder="Producer Name"
               class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3">

        <label class="text-sm">Role</label>
        <select name="producer_role[]" class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
			<option value="producer">Producer</option>
			<option value="engineer">Engineer</option>
			<option value="mixer">Mixer</option>
			<option value="mastering">Mastering Engineer</option>
        </select>

        <button type="button" onclick="removeField(this)"
                class="mt-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300">Remove</button>
      `;
      document.getElementById("producers").appendChild(div);
    }
  </script>

</body>
</html>
