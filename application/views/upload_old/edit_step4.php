<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Step 4 – Artwork | SoundFlow</title>

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

  <style>
    .template-selected {
      border-color: #ff531a !important;
      box-shadow: 0 0 18px #ff531a22;
      transform: scale(1.02);
    }
    .artwork-preview {
      max-width: 240px;
      max-height: 240px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid rgba(255,255,255,0.06);
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-black to-[#1b0e26] text-white">

  <!-- HEADER -->
  <header class="border-b border-border bg-black">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">
      <a href="<?= base_url('Dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold">SoundFlow</span>
      </a>
    </div>
  </header>

  <!-- BANNER -->
  <div class="bg-gradient-to-r from-[#3b2e10] to-[#401720] py-6">
    <div class="container mx-auto px-6 flex items-center justify-between">
      <h1 class="text-4xl font-bold">Edit Release — Step 4: Artwork</h1>

      <div class="flex items-center gap-3">
        <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
          <div class="text-center leading-tight">
            <div class="text-2xl font-bold">4</div>
            <div class="text-xs">/ 4</div>
          </div>
        </div>
        <div class="text-sm font-semibold">Final Step</div>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="container mx-auto px-6 py-12 max-w-4xl">

    <div class="bg-card border border-border rounded-lg p-8">

      <h2 class="text-3xl font-bold mb-2">Add Cover Art</h2>
      <p class="text-sm text-muted mb-6">
        Upload your artwork or choose from our ready-to-customize templates.
      </p>

      <?php
        // Determine whether an artwork exists
        $has_artwork = !empty($artwork->file_path);
        // Determine preselected template: prefer POSTed value so it persists on validation fail,
        // otherwise use stored template_id in DB
        $posted_template = $this->input->post('selected_template');
        $selected_template = $posted_template !== null ? $posted_template : ($artwork->template_id ?? '');
        // Build a usable int or empty string
        $selected_template = $selected_template === '' ? '' : (int)$selected_template;
      ?>

      <form method="post" enctype="multipart/form-data" action="<?= base_url('my-releases/edit/step-4/'.$release->id) ?>" class="space-y-10">

        <?php
          // CSRF token
          $csrf_name = $this->security->get_csrf_token_name();
          $csrf_hash = $this->security->get_csrf_hash();
        ?>
        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />

        <!-- GUIDELINES -->
        <div>
          <button type="button" onclick="toggleGuidelines()"
            class="text-primary hover:text-primary/80 font-semibold">
            Show Artwork Guidelines ↕
          </button>

          <ul id="guidelines" class="hidden list-disc list-inside text-sm text-muted mt-3 ml-4 space-y-2">
            <li>JPG, PNG or GIF image under 10MB.</li>
            <li>Must be RGB mode.</li>
            <li>Minimum size: 1600 x 1600 pixels.</li>
            <li>No irrelevant text or logos.</li>
            <li>No blurry or pixelated images.</li>
            <li>No social media handles or pricing info.</li>
          </ul>
        </div>

        <!-- UPLOAD FILE / CURRENT PREVIEW -->
        <div class="space-y-3">
          <h3 class="text-xl font-semibold">Upload Artwork <?= $has_artwork ? '(Optional — existing shown below)' : '*' ?></h3>

          <?php if ($has_artwork): ?>
            <div class="flex gap-6 items-start">
              <div class="flex-shrink-0">
                <img src="<?= base_url($artwork->file_path) ?>" alt="cover" class="artwork-preview" />
              </div>

              <div>
                <div class="text-sm text-muted mb-2">
                  Current artwork file: <strong class="text-white"><?= html_escape(basename($artwork->file_path)) ?></strong>
                </div>

                <div class="flex gap-2">
                  <label for="artwork" class="px-4 py-2 rounded bg-gray-800 border border-border hover:bg-white/5 cursor-pointer text-sm">
                    Replace artwork
                    <input id="artwork" type="file" name="artwork" accept="image/*" class="hidden">
                  </label>

                  <label class="px-4 py-2 rounded bg-gray-800 border border-border cursor-pointer text-sm">
                    <input type="checkbox" name="remove_artwork" value="1" class="mr-2 align-middle">
                    Remove current artwork
                  </label>
                </div>

                <p class="text-sm text-muted mt-3">Uploading a new file will replace the existing artwork.</p>
              </div>
            </div>
          <?php else: ?>
            <div class="border-2 border-dashed border-border rounded-lg p-10 text-center hover:border-primary transition">
              <i data-lucide="image" class="w-12 h-12 text-muted mx-auto mb-3"></i>

              <p class="text-sm text-muted mb-3">Click to upload JPG or PNG (3000x3000 recommended)</p>

              <input type="file" name="artwork" accept="image/*"
                     class="block mx-auto text-sm text-muted" required>
            </div>
          <?php endif; ?>
        </div>

        <!-- TEMPLATES -->
        <div class="space-y-3">
          <h3 class="text-xl font-semibold">Or Choose a Template</h3>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="templateGrid">
            <?php for($i=1; $i<=8; $i++): 
              $is_selected = ($selected_template !== '' && (int)$selected_template === $i);
            ?>
              <div
                data-template="<?= $i ?>"
                onclick="selectTemplate(<?= $i ?>)"
                class="template-box aspect-square rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 cursor-pointer border-2 <?= $is_selected ? 'template-selected' : 'border-transparent' ?> flex items-center justify-center hover:scale-105 transition-all"
              >
                <div class="text-center px-3">
                  <div class="font-bold">ALBUM NAME</div>
                  <div class="text-primary text-sm">ARTIST NAME</div>
                </div>
              </div>
            <?php endfor; ?>
          </div>

          <input type="hidden" name="selected_template" id="selected_template" value="<?= html_escape($selected_template) ?>">
        </div>

        <!-- BUTTONS -->
        <div class="flex justify-between pt-8">
          <a href="<?= base_url('my-releases/edit/step-3/'.$release->id) ?>"
             class="px-8 py-3 border border-border rounded-lg hover:bg-white/10">
            ← BACK
          </a>

          <button type="submit"
            class="bg-gradient-to-r from-primary to-[#4e6bff] hover:opacity-90 px-8 py-3 rounded-lg font-semibold">
            FINISH →
          </button>
        </div>

      </form>

    </div>
  </div>


  <script>
    lucide.createIcons();

    function toggleGuidelines() {
      let box = document.getElementById('guidelines');
      box.classList.toggle('hidden');
    }

    // select template visually and update hidden input
    function selectTemplate(id) {
      document.getElementById('selected_template').value = id;

      document.querySelectorAll('.template-box').forEach(el => {
        el.classList.remove('template-selected');
      });

      const node = document.querySelector('[data-template="' + id + '"]');
      if (node) node.classList.add('template-selected');
    }

    // ensure preselected template is highlighted on load
    document.addEventListener('DOMContentLoaded', function(){
      const selected = document.getElementById('selected_template').value;
      if (selected) {
        const node = document.querySelector('[data-template="' + selected + '"]');
        if (node) node.classList.add('template-selected');
      }
      // wire up replace-artwork label click to file input (for the case we used custom label)
      const replaceLabel = document.querySelector('label[for="artwork"]');
      if (replaceLabel) {
        replaceLabel.addEventListener('click', function(e){
          // clicking label will open native file picker because input has id="artwork"
        });
      }
    });
  </script>

</body>
</html>
