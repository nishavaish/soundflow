<?php
// Variables expected from controller (Album_model):
// $album, $tracks, $stores, $social

$csrf_name = $this->security->get_csrf_token_name();
$csrf_hash = $this->security->get_csrf_hash();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?= $album->album_title ?> – Album Details</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            background: "#000",
            border: "#27272a",
            card: "#0f0f0f",
            muted: "#9ca3af"
          }
        }
      }
    }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    .track-row:hover .play-overlay {
      opacity: 1;
      transform: translateY(0);
    }

    .play-overlay {
      opacity: 0;
      transform: translateY(4px);
      transition: all .2s ease;
    }

    #deleteModal {
      transition: all .25s ease;
    }

    #deleteModal.show .modal-content {
      animation: popIn .25s ease;
    }

    @keyframes popIn {
      from {
        transform: scale(.8);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>

</head>

<body class="bg-white min-h-screen text-black">

  <?php $this->view('page_header'); ?>


  <!-- Page Container -->
  <div class="container mx-auto px-6 py-10">

    <div class="flex flex-col md:flex-row gap-10">

      <!-- Artwork -->
      <div>
        <img src="<?= base_url($album->cover_art) ?>"
          class="w-64 h-64 object-cover rounded shadow-lg border border-border">
      </div>

      <!-- Album Details -->
      <div class="flex-1">

        <h1 class="text-4xl font-bold"><?= $album->album_title ?></h1>
        <p class="text-xl text-muted mt-1"><?= $album->artist ?></p>

        <?php if (!empty($album->featuring)): ?>
          <p class="text-sm text-muted">Featuring: <?= $album->featuring ?></p>
        <?php endif; ?>

        <div class="mt-5 space-y-1 text-sm">
          <p><b>Album Type:</b> <?= ucfirst($album->album_type) ?></p>
          <p><b>Genre:</b> <?= ucfirst($album->genre) ?></p>
          <?php if ($album->subgenre): ?>
            <p><b>Subgenre:</b> <?= ucfirst($album->subgenre) ?></p>
          <?php endif; ?>

          <p><b>Release Date:</b> <?= $album->release_date ?></p>
          <?php if ($album->label): ?>
            <p><b>Label:</b> <?= $album->label ?></p>
          <?php endif; ?>

          <?php if ($album->upc_code): ?>
            <p><b>UPC:</b> <?= $album->upc_code ?></p>
          <?php endif; ?>

          <p><b>Language:</b> <?= ucfirst($album->language) ?></p>

          <p><b>Explicit:</b>
            <?= $album->explicit == "yes" ? "Yes" : ($album->explicit == "partial" ? "Partially" : "No") ?>
          </p>

          <?php if ($album->description): ?>
            <p class="pt-2"><b>Description:</b><br><?= nl2br($album->description) ?></p>
          <?php endif; ?>
        </div>

        <!-- Stores -->
        <div class="mt-6">
          <h3 class="font-semibold mb-2">Available on</h3>

          <?php if (!empty($stores)): ?>
            <div class="flex flex-wrap gap-3 text-sm">
              <?php foreach ($stores as $s): ?>
                <span class="px-3 py-1 border border-border rounded">
                  <?= ucfirst($s->store_name) ?>
                </span>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted text-sm">Not distributed to any stores.</p>
          <?php endif; ?>
        </div>

        <!-- Actions -->
        <!-- <div class="mt-8 flex gap-4">
        <a href="<?= site_url('UploadAlbum/edit/1/' . $album->id) ?>"
           class="px-6 py-2 rounded bg-primary hover:bg-orange-600 text-white text-sm font-semibold">Edit Album</a>

        <button id="deleteAlbumBtn"
                class="px-6 py-2 rounded bg-red-700 hover:bg-red-600 text-white text-sm font-semibold">
          Delete Album
        </button>
      </div> -->

        <div class="mt-8 flex items-center gap-4">

          <?php if ((int) $album->is_active === 0): ?>

            <!-- Edit Album -->
            <a href="<?= site_url('UploadAlbum/edit/1/' . $album->id) ?>" class="px-6 py-2 rounded bg-primary hover:bg-orange-600
                  text-white text-sm font-semibold">
              Edit Album
            </a>

            <!-- Delete Album -->
            <button id="deleteAlbumBtn" class="px-6 py-2 rounded bg-red-700 hover:bg-red-600
                       text-white text-sm font-semibold">
              Delete Album
            </button>

          <?php else: ?>

            <!-- Approved Badge -->
            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full
                   text-sm font-semibold whitespace-nowrap
                   bg-emerald-100 text-emerald-700
                   dark:bg-emerald-900 dark:text-emerald-300">
              <i data-lucide="check-circle" class="w-4 h-4"></i>
              Approved
            </span>

          <?php endif; ?>

        </div>

      </div>

    </div>

    <!-- Tracklist -->
    <div class="mt-12">
      <h2 class="text-2xl font-bold mb-4">Tracklist</h2>

      <div class="space-y-3">

        <?php foreach ($tracks as $index => $t): ?>
          <div class="track-row relative p-4  border border-border rounded flex items-center justify-between">

            <!-- Left info -->
            <div class="flex items-center gap-4">

              <div class="text-muted text-lg w-6 text-right"><?= $index + 1 ?></div>

              <div>
                <div class="font-semibold"><?= $t->track_title ?></div>

                <div class="text-xs text-muted">
                  <?php if ($t->artists): ?>Artists: <?= $t->artists ?><br><?php endif; ?>
                  <?php if ($t->songwriters): ?>Writers: <?= $t->songwriters ?><br><?php endif; ?>
                  <?php if ($t->producers): ?>Producers: <?= $t->producers ?><br><?php endif; ?>
                  <?= $t->is_explicit ? '<span class="text-red-400">Explicit</span>' : '' ?>
                </div>
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

            <!-- Play overlay icon -->
            <!-- <div class="absolute right-4 top-1/2 -translate-y-1/2 play-overlay">
              <i data-lucide="play-circle" class="w-8 h-8 text-white opacity-90"></i>
            </div> -->

          </div>
        <?php endforeach; ?>

      </div>

    </div>
  </div>

  <!-- DELETE MODAL -->
  <div id="deleteModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="modal-content bg-card p-6 rounded-lg border border-border w-full max-w-md">
      <h2 class="text-xl font-bold">Confirm Deletion</h2>
      <p class="text-muted mt-2">This action cannot be undone.</p>

      <form id="deleteForm" class="mt-6">

        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
        <input type="hidden" name="album_id" value="<?= $album->id ?>">

        <div class="flex justify-end gap-3 mt-4">
          <button type="button" id="cancelDelete"
            class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 text-white">Cancel</button>

          <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-500 text-white">Delete</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" class="fixed bottom-6 right-6 bg-primary text-white px-4 py-3 rounded shadow-lg hidden">
    Deleted successfully
  </div>

  <script>
    lucide.createIcons();

    // OPEN DELETE MODAL
    document.getElementById('deleteAlbumBtn').onclick = () => {
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteModal').classList.add('flex');
    };

    // CLOSE MODAL
    document.getElementById('cancelDelete').onclick = () => {
      document.getElementById('deleteModal').classList.add('hidden');
    };

    // AJAX DELETE
    document.getElementById('deleteForm').onsubmit = function (e) {
      e.preventDefault();

      fetch("<?= base_url('UploadAlbum/delete/') ?>" + <?= $album->id ?>, {
        method: "POST",
        body: new FormData(this)
      })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            // show toast
            let toast = document.getElementById("toast");
            toast.classList.remove("hidden");
            setTimeout(() => toast.classList.add("hidden"), 2500);

            setTimeout(() => {
              window.location.href = "<?= base_url('my-albums/list') ?>";
            }, 1200);
          }
        });
    };
  </script>

</body>

</html>