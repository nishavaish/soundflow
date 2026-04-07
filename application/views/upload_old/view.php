<?php
// application/views/upload/view.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>View Release - <?php echo html_escape($release->title) ?></title>

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
            muted: "#9ca3af",
            card: "#111111"
          }
        }
      }
    }
  </script>

  <!-- Lucide -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-background">

  <!-- Header (matching dashboard) -->
  <?php $this->view('page_header'); ?>


  <div class="container mx-auto px-6 py-8">
    <div class="flex items-start gap-8">
      <!-- Cover -->
      <div class="w-56 h-56 bg-gray-900 rounded-lg overflow-hidden border border-border">
        <?php if (!empty($release->file_path)): ?>
          <img src="<?php echo base_url($release->file_path) ?>" alt="cover" class="w-full h-full object-cover" />
        <?php else: ?>
          <div class="w-full h-full flex items-center justify-center text-gray-500">
            <svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4M3 11h18" />
            </svg>
          </div>
        <?php endif; ?>
      </div>

      <div class="flex-1">
        <div class="flex items-start justify-between">
          <div>
            <h1 class="text-4xl font-bold text-white"><?php echo html_escape($release->title) ?></h1>
            <p class="text-muted mt-2"><?php echo html_escape($release->primary_artist) ?> •
              <?php echo html_escape($release->genre ?: '—') ?></p>
            <p class="text-sm muted mt-2">Release date:
              <?php echo ($release->release_date) ? date('d M Y', strtotime($release->release_date)) : '—' ?></p>
          </div>

          <div class="text-right">
            <!-- <a href="<?php //echo site_url('my-releases/edit/step-1/'.$release_id) ?>" class="inline-block px-4 py-2 rounded bg-yellow-500 text-black font-semibold">Edit</a> -->
            <?php if ((int) $release->is_active === 0): ?>
              <!-- Edit Button (Only when NOT approved) -->
              <a href="<?= site_url('my-releases/edit/step-1/' . $release->release_id) ?>"
                class="inline-block px-4 py-2 rounded bg-yellow-500 text-black font-semibold hover:bg-yellow-400">
                Edit
              </a>
            <?php else: ?>
              <!-- Approved Badge -->
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full
                   text-sm font-semibold
                   bg-emerald-100 text-emerald-700
                   dark:bg-emerald-900 dark:text-emerald-300">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Approved
              </span>
            <?php endif; ?>
            <a href="<?php echo site_url('my-releases') ?>"
              class="ml-2 inline-block px-4 py-2 rounded bg-gray-800 text-white">Back</a>
          </div>
        </div>

        <?php if (!empty($release->description)): ?>
          <div class="mt-6 p-4 bg-card rounded border border-border text-white">
            <?php echo nl2br(html_escape($release->description)) ?>
          </div>
        <?php endif; ?>

        <!-- Tracks -->
        <div class="mt-8">
          <h3 class="text-xl font-semibold text-white mb-4">Tracks</h3>

          <?php if (!empty($tracks)): ?>
            <ul class="space-y-3">
              <?php foreach ($tracks as $t): ?>
                <li class="p-3 bg-[hsl(0,0%,8%)] rounded border border-border flex items-center justify-between">
                  <div>
                    <div class="font-medium text-white"><?php echo html_escape($t->title) ?></div>
                    <div class="text-sm muted mt-1">
                      <?php
                      $writers = isset($t->songwriters) ? $t->songwriters : '';
                      if ($writers)
                        echo 'Writers: ' . html_escape($writers);
                      ?>
                    </div>
                  </div>

                  <div class="flex items-center space-x-3">
                    <?php if (!empty($t->audio_file)): ?>
                      <audio controls preload="none" class="h-8">
                        <source src="<?php echo base_url($t->audio_file) ?>" />
                        Your browser does not support audio.
                      </audio>
                      <a class="text-sm muted ml-2" href="<?php echo base_url($t->audio_file) ?>" target="_blank"
                        download>Download</a>
                    <?php else: ?>
                      <span class="text-sm muted">No audio</span>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="text-muted">No tracks found for this release.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>

</html>