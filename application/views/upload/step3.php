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

  <!-- Step Banner -->
  <div class="bg-gradient-to-r from-[#b90606] to-[#ff1a1a] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between text-white">
      <h1 class="text-4xl font-bold">Track Details</h1>

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

    <div class="bg-card border-b border-zinc-400/30 rounded-lg p-8">

      <h2 class="text-3xl font-bold mb-2">Song Information</h2>
      <p class="text-sm text-muted mb-8">
        Upload your audio file and complete the details below.
      </p>

      <form method="post" enctype="multipart/form-data" action="<?= base_url('UploadSingle/step3') ?>" class="space-y-10">
		  
		     <?php
    $csrf_name = $this->security->get_csrf_token_name();
    $csrf_hash = $this->security->get_csrf_hash();
    ?>
    <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />

        <!-- AUDIO UPLOAD -->
        <div class="bg-white border-b border-zinc-400/30 rounded-lg p-6">
          <h3 class="text-xl font-semibold mb-3">Audio Upload *</h3>
          <p class="text-sm text-muted mb-4">
            Accepted: 24-bit WAV/AIFF/FLAC or high-quality MP3
          </p>

          <div class="border-2 border-dashed border-border rounded-lg p-10 text-center">
            <i data-lucide="upload" class="w-10 h-10 text-muted mx-auto mb-3"></i>
            <input type="file" name="audio_file" required class="block mx-auto text-sm text-muted">
          </div>
        </div>

        <!-- SONG TITLE -->
        <div class="space-y-2">
          <label class="text-sm font-semibold">Song Title *</label>
          <input
            type="text"
            name="song_title"
            class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2"
            required
          >
        </div>

        <!-- SONGWRITERS -->
        <div class="space-y-4">
          <div class="flex items-center gap-2">
            <label class="text-base font-semibold">Songwriters *</label>
            <i data-lucide="info" class="w-4 h-4 text-yellow-500"></i>
          </div>

          <div id="songwriters">
            <div class="flex gap-2 mb-2 songwriter-field">
              <input type="text" name="songwriters[]" placeholder="Songwriter Name"
                     class="flex-1 bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2">
              <button type="button" onclick="removeField(this)"
                      class="px-3 bg-red-600/30 border border-red-600 rounded-lg text-black hover:bg-red-600/40">
                X
              </button>
            </div>
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
            <div class="artist-row mb-4 rounded-lg border-b border-zinc-400/30">
              <input type="text" name="main_artist_name[]" placeholder="Artist Name"
                     class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2 mb-3">

              <label class="text-sm">Role</label>
              <select name="main_artist_role[]" class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2">
					<option value="lead" >Main Artist</option>
                  <option value="featured">Featured</option>
                  <option value="producer">Producer</option>
                  <option value="composer">Composer</option>
                  <option value="lyricist">Lyricist</option>
              </select>

              <button type="button" onclick="removeField(this)"
                      class="my-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-black hover:bg-red-600/40">
                Remove
              </button>
            </div>
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
            <div class="artist-row mb-4 rounded-lg border-b border-zinc-400/30">
              <input type="text" name="performing_artist_name[]" placeholder="Artist Name"
                     class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2 mb-3">

              <label class="text-sm">Role</label>
              <select name="performing_artist_role[]"  class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2">
               
				<option value="performer" >Performer</option>
                  <option value="session">Session</option>
                  <option value="featured">Featured</option>
                  <option value="vocalist">Vocalist</option>
                  <option value="instrumentalist">Instrumentalist</option>
                  <option value="lyricist">Lyricist</option>
				
              </select>

              <button type="button" onclick="removeField(this)"
                      class="my-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-black hover:bg-red-600/40">
                Remove
              </button>
            </div>
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
            <div class="artist-row mb-4 rounded-lg border-b border-zinc-400/30">
              <input type="text" name="producer_name[]" placeholder="Producer Name"
                     class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2 mb-3">

              <label class="text-sm">Role</label>
              <select name="producer_role[]"  class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2">
                <option value="producer">Producer</option>
                <option value="engineer">Engineer</option>
                <option value="mixer">Mixer</option>
                <option value="mastering">Mastering Engineer</option>
              </select>

              <button type="button" onclick="removeField(this)"
                      class="my-3 px-3 bg-red-600/30 border border-red-600 rounded-lg text-black hover:bg-red-600/40">
                Remove
              </button>
            </div>
          </div>

          <button type="button" onclick="addProducer()"
                  class="text-primary text-sm hover:underline font-semibold">
            + Add Producer
          </button>
        </div>

        <!-- COPYRIGHT -->
        <div class="space-y-2">
          <label class="text-base font-semibold">Copyright *</label>
          <select name="copyright"
                  class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2">
            <option value="yes">Yes — I own copyright</option>
            <option value="no">No — Someone else owns it</option>
          </select>
        </div>

        <!-- LYRICS -->
        <div class="space-y-2">
          <label class="text-base font-semibold">Lyrics (Optional)</label>
          <textarea name="lyrics" rows="6"
                    class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2"></textarea>
        </div>

        <!-- TIKTOK CLIP -->
        <div class="space-y-2">
          <label class="text-base font-semibold">TikTok Clip Start Time (Optional)</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-sm">Minutes</label>
              <input type="number" min="0" name="tiktok_min" placeholder="00"
                     class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2">
            </div>

            <div>
              <label class="text-sm">Seconds</label>
              <input type="number" min="0" max="59" name="tiktok_sec" placeholder="00"
                     class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2">
            </div>
          </div>
        </div>
		
		
		  <!-- CRBT CLIP -->
        <div class="space-y-2">
          <label class="text-base font-semibold">CRBT Clip Start Time (Optional)</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-sm">Minutes</label>
              <input type="number" min="0" name="crbt_clip_min" placeholder="00"
                     class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2">
            </div>

            <div>
              <label class="text-sm">Seconds</label>
              <input type="number" min="0" max="59" name="crbt_clip_sec" placeholder="00"
                     class="w-full bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2">
            </div>
          </div>
        </div>
		
		
		

        <!-- BUTTONS -->
        <div class="flex justify-between pt-8">
          <a href="<?= base_url('UploadSingle/step2') ?>"
             class="px-8 py-3 border border-border rounded-lg hover:bg-white/10">
            ← BACK
          </a>

          <button type="submit"
            class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
            NEXT →
          </button>
        </div>

      </form>

    </div>
  </div>

  <script>
    lucide.createIcons();

    function removeField(btn) {
      btn.parentElement.remove();
    }

    function addSongwriter() {
      let div = document.createElement("div");
      div.className = "flex gap-2 mb-2 songwriter-field";
      div.innerHTML = `
        <input type="text" name="songwriters[]" class="flex-1 bg-white border-b border-zinc-400/30 rounded-lg px-3 py-2">
        <button type="button" onclick="removeField(this)"
                class="px-3 bg-red-600/30 border border-red-600 rounded-lg text-red-300">X</button>
      `;
      document.getElementById("songwriters").appendChild(div);
    }

    function addMainArtist() {
      let div = document.createElement("div");
      div.className = "artist-row mb-4 p-4 rounded-lg bg-white border-b border-zinc-400/30";
      div.innerHTML = `
        <input type="text" name="main_artist_name[]" placeholder="Artist Name"
               class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2 mb-3">

        <label class="text-sm">Role</label>
        <select name="main_artist_role[]" class="w-full bg-[#080808] border border-border rounded-lg px-3 py-2">
         
		  	<option value="lead" >Main Artist</option>
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
      div.className = "artist-row mb-4 p-4 rounded-lg bg-white border-b border-zinc-400/30";
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
      div.className = "artist-row mb-4 p-4 rounded-lg bg-white border-b border-zinc-400/30";
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
