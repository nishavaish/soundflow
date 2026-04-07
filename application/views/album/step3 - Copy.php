<?php
// Detect mode
$editMode = isset($tracks);

// Load step1 session (num_tracks for create mode)
$step1 = $this->session->userdata('album_step1');

// For create mode: number of tracks
$create_track_count = $step1['num_tracks'] ?? 0;

// CSRF token
$csrf_name = $this->security->get_csrf_token_name();
$csrf_hash = $this->security->get_csrf_hash();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title><?= $editMode ? "Edit Album – Step 3 (Tracks)" : "Create Album – Step 3 (Tracks)" ?></title>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: "#ff531a",
        border: "#27272a",
        card: "#0f0f0f",
        muted: "#9ca3af"
      }
    }
  }
};
</script>

<!-- SortableJS (drag & drop) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
.track-row {
  transition: all .25s ease;
}
.track-row:hover {
  background: rgba(255,255,255,0.06);
}
.drag-handle { cursor: grab; }
</style>

</head>

<body class="min-h-screen bg-gradient-to-br from-black to-gray-900 text-white">

<!-- Header -->
<header class="border-b border-border bg-black">
  <div class="container mx-auto px-6 h-16 flex items-center justify-between">
    <a href="<?= base_url('dashboard'); ?>" class="flex items-center gap-2">
      <i data-lucide="music" class="w-8 h-8 text-primary"></i>
      <span class="text-2xl font-bold">SoundFlow</span>
    </a>
  </div>
</header>

<!-- Step Header -->
<div class="bg-gradient-to-r from-yellow-700 to-red-700 py-6">
  <div class="container mx-auto px-6 flex items-center justify-between">
    <h1 class="text-4xl font-bold"><?= $editMode ? "Edit Album" : "Create Album" ?></h1>

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
<div class="container mx-auto px-6 py-10 max-w-5xl">

  <div class="bg-card border border-border rounded-lg p-8">

    <h2 class="text-2xl font-bold mb-3">Track List</h2>
    <p class="text-sm text-muted mb-6">
      Add your tracks, reorder them, and upload audio files.
    </p>

    <!-- ERROR -->
    <?php if ($this->session->flashdata('error')): ?>
      <div class="text-red-300 mb-4"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- FORM START -->
    <form method="post" action="<?= base_url($editMode ? 'UploadAlbum/edit_step3' : 'UploadAlbum/step3'); ?>" enctype="multipart/form-data" id="trackForm">

      <!-- CSRF -->
      <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

      <!-- Hidden JSON output (controller expects this) -->
      <input type="hidden" name="track_data_json" id="track_data_json">

      <!-- Track list container -->
      <div id="trackList" class="space-y-4">

        <!-- CREATE MODE -->
        <?php if (!$editMode): ?>
          <?php for ($i = 0; $i < $create_track_count; $i++): ?>
          <div class="track-row border border-border rounded-lg p-4" data-index="<?= $i ?>">

            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-3">
                <i data-lucide="menu" class="drag-handle w-5 h-5 text-muted"></i>
                <h3 class="text-lg font-semibold">Track <?= $i + 1 ?></h3>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

              <div>
                <label class="text-sm">Track Title *</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="track_title[]" placeholder="Track Title" required>
              </div>

              <div>
                <label class="text-sm">Artists</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="artists[]" placeholder="Artists">
              </div>

              <div>
                <label class="text-sm">Songwriters</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="songwriters[]" placeholder="Writers">
              </div>

              <div>
                <label class="text-sm">Producers</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="producers[]" placeholder="Producers">
              </div>

              <div class="md:col-span-2">
                <label class="text-sm">Audio File (MP3, WAV, FLAC) *</label>
                <input type="file" class="w-full bg-black border border-border rounded p-2"
                       name="audio_file[]" accept=".mp3,.wav,.flac" required>
              </div>

            </div>

            <div class="mt-4">
              <label class="text-sm">Explicit?</label>
              <select name="is_explicit[]" class="bg-black border border-border rounded p-2">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>

          </div>
          <?php endfor; ?>
        <?php endif; ?>

        <!-- EDIT MODE -->
        <?php if ($editMode): ?>
          <?php foreach ($tracks as $i => $t): ?>
          <div class="track-row border border-border rounded-lg p-4" data-track-id="<?= $t->id ?>">

            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-3">
                <i data-lucide="menu" class="drag-handle w-5 h-5 text-muted"></i>
                <h3 class="text-lg font-semibold">Track <?= $i + 1 ?></h3>
              </div>

              <button type="button"
                      class="text-red-400 hover:text-red-300 delete-track-btn"
                      data-track-id="<?= $t->id ?>">
                <i data-lucide="trash-2"></i>
              </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

              <div>
                <label class="text-sm">Track Title *</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="track_title[]" value="<?= $t->track_title ?>" required>
              </div>

              <div>
                <label class="text-sm">Artists</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="artists[]" value="<?= $t->artists ?>">
              </div>

              <div>
                <label class="text-sm">Songwriters</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="songwriters[]" value="<?= $t->songwriters ?>">
              </div>

              <div>
                <label class="text-sm">Producers</label>
                <input type="text" class="w-full bg-black border border-border rounded p-2"
                       name="producers[]" value="<?= $t->producers ?>">
              </div>

              <div class="md:col-span-2">
                <label class="text-sm">Current Audio:</label>
                <div class="text-muted text-xs mb-1"><?= basename($t->audio_file) ?></div>

                <label class="text-sm">Replace Audio (optional):</label>
                <input type="file" class="w-full bg-black border border-border rounded p-2"
                       name="audio_file[]" accept=".mp3,.wav,.flac">
              </div>

            </div>

            <div class="mt-4">
              <label class="text-sm">Explicit?</label>
              <select name="is_explicit[]" class="bg-black border border-border rounded p-2">
                <option value="0" <?= $t->is_explicit == 0 ? 'selected' : '' ?>>No</option>
                <option value="1" <?= $t->is_explicit == 1 ? 'selected' : '' ?>>Yes</option>
              </select>
            </div>

          </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>

      <!-- Add New Track Button (Edit Mode Only) -->
      <?php if ($editMode): ?>
      <div class="mt-6">
        <button type="button" id="addTrackBtn"
                class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-sm">
          + Add New Track
        </button>
      </div>
      <?php endif; ?>

      <!-- Continue -->
      <div class="flex justify-end pt-6">
        <button type="submit"  onclick="prepareTrackJSON()"
                class="bg-gradient-to-r from-primary to-blue-500 hover:opacity-90 px-8 py-3 rounded-lg font-semibold text-sm">
          CONTINUE →
        </button>
      </div>

    </form>
  </div>
</div>

<script>
lucide.createIcons();

/* ==========================
   SORTABLE (Drag & Drop)
========================== */
new Sortable(document.getElementById("trackList"), {
  animation: 150,
  handle: ".drag-handle",
});

/* ==========================
   DELETE TRACK (AJAX)
========================== */
let deleteTrackID = null;
let deleteButtonRef = null;

// OPEN MODAL
document.querySelectorAll('.delete-track-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    deleteTrackID = btn.dataset.trackId;
    deleteButtonRef = btn;

    const modal = document.getElementById("deleteModal");
    modal.classList.remove("hidden");

    // fade-in animation
    setTimeout(() => {
      modal.querySelector(".modal-content").classList.remove("opacity-0", "scale-95");
      modal.querySelector(".modal-content").classList.add("opacity-100", "scale-100");
    }, 10);
  });
});

// CLOSE MODAL
document.getElementById("cancelDeleteBtn").addEventListener("click", () => {
  closeDeleteModal();
});

function closeDeleteModal() {
  const modal = document.getElementById("deleteModal");

  modal.querySelector(".modal-content").classList.add("opacity-0", "scale-95");
  modal.querySelector(".modal-content").classList.remove("opacity-100", "scale-100");

  setTimeout(() => modal.classList.add("hidden"), 150);
}

// CONFIRM DELETE
document.getElementById("confirmDeleteBtn").addEventListener('click', () => {
  fetch("<?= base_url('UploadAlbum/delete_track/') ?>" + deleteTrackID, {
      method: "GET",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "<?= $csrf_name ?>": "<?= $csrf_hash ?>"
      },
  })
  .then(r => r.json())
  .then(res => {
    if (res.success) {
      deleteButtonRef.closest(".track-row").remove();
    } else {
      alert("Error deleting track");
    }
    closeDeleteModal();
  });
});


/* ==========================
   FORM SERIALIZATION
========================== */
document.getElementById('trackForm').addEventListener('submit', function (e) {

  const rows = document.querySelectorAll('#trackList .track-row');
  let trackData = [];

  rows.forEach(row => {
    const title = row.querySelector('input[name="track_title[]"]').value;
    const artists = row.querySelector('input[name="artists[]"]').value;
    const writers = row.querySelector('input[name="songwriters[]"]').value;
    const producers = row.querySelector('input[name="producers[]"]').value;
    const explicit = row.querySelector('select[name="is_explicit[]"]').value;

    trackData.push({
      track_title: title,
      artists: artists,
      songwriters: writers,
      producers: producers,
      is_explicit: explicit
    });
  });

  document.getElementById('track_data_json').value = JSON.stringify(trackData);
  console.log("JSON before submit:", document.getElementById('track_data_json').value);

});
</script>

<script>
	// ===============================
// ADD NEW TRACK (EDIT MODE ONLY)
// ===============================

let newTrackCounter = <?= $editMode ? count($tracks) : 0 ?>;

document.getElementById("addTrackBtn")?.addEventListener("click", () => {

  const trackList = document.getElementById("trackList");

  let newRow = document.createElement("div");
  newRow.classList.add("track-row", "border", "border-border", "rounded-lg", "p-4");
  newRow.dataset.index = newTrackCounter;

  newRow.innerHTML = `
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <i data-lucide="menu" class="drag-handle w-5 h-5 text-muted"></i>
        <h3 class="text-lg font-semibold">Track ${newTrackCounter + 1}</h3>
      </div>
      <button type="button" class="text-red-400 hover:text-red-300 delete-track-btn-new">
        <i data-lucide="trash-2"></i>
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="text-sm">Track Title *</label>
        <input type="text" name="track_title[]" class="w-full bg-black border border-border rounded p-2" required>
      </div>

      <div>
        <label class="text-sm">Artists</label>
        <input type="text" name="artists[]" class="w-full bg-black border border-border rounded p-2">
      </div>

      <div>
        <label class="text-sm">Songwriters</label>
        <input type="text" name="songwriters[]" class="w-full bg-black border border-border rounded p-2">
      </div>

      <div>
        <label class="text-sm">Producers</label>
        <input type="text" name="producers[]" class="w-full bg-black border border-border rounded p-2">
      </div>

      <div class="md:col-span-2">
        <label class="text-sm">Audio File *</label>
        <input type="file" name="audio_file[]" class="w-full bg-black border border-border rounded p-2" required>
      </div>
    </div>

    <div class="mt-4">
      <label class="text-sm">Explicit?</label>
      <select name="is_explicit[]" class="bg-black border border-border rounded p-2">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>

    <input type="hidden" name="existing_audio_file[]" value="">
  `;

  trackList.appendChild(newRow);

  // Refresh icons
  lucide.createIcons();

  // Enable delete for newly added track
  newRow.querySelector(".delete-track-btn-new").addEventListener("click", () => {
    newRow.remove();
  });

  newTrackCounter++;
});

</script>


<!-- Delete Track Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">
  <div class="bg-card border border-border rounded-xl p-6 w-full max-w-md shadow-xl scale-95 opacity-0 transition-all modal-content">
    
    <h2 class="text-xl font-semibold mb-3">Confirm Delete</h2>
    <p class="text-muted mb-6">Are you sure you want to remove this track?</p>

    <div class="flex justify-end gap-3">
      <button id="cancelDeleteBtn" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 text-sm">
        Cancel
      </button>

      <button id="confirmDeleteBtn" class="px-4 py-2 rounded bg-red-600 hover:bg-red-500 text-sm">
        Delete
      </button>
    </div>
  </div>
</div>


</body>
</html>
