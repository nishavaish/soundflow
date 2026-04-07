<?php
$csrf_name = $this->security->get_csrf_token_name();
$csrf_hash = $this->security->get_csrf_hash();

$editMode = isset($editMode) ? $editMode : false;
$num_tracks = $num_tracks ?? 0;
$tracks = $tracks ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $editMode ? "Edit Album – Step 3 (Tracks)" : "Create Album – Step 3 (Tracks)" ?></title>

<!-- Tailwind + Icons -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

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

<!-- CONTENT -->
<div class="container mx-auto px-6 py-12 max-w-4xl">

  <div class="bg-card border-b border-zinc-400/30 rounded-lg p-8">

    <h2 class="text-3xl font-bold mb-2">Track List</h2>
    <p class="text-muted text-sm mb-6">
      Add, reorder, or update your tracks. Audio is required for new tracks.
    </p>

    <!-- Upload errors -->
    <?php if (!empty($upload_error)): ?>
      <div class="text-red-400 text-sm mb-4"><?= $upload_error ?></div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="post"
          action="<?= base_url($editMode ? "UploadAlbum/edit_step3" : "UploadAlbum/step3") ?>"
          enctype="multipart/form-data"
          id="trackForm">

      <!-- CSRF -->
      <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">
      <input type="hidden" id="track_data_json" name="track_data_json">

      <!-- TRACK LIST -->
      <div id="trackList" class="space-y-4">

        <!-- CREATE MODE ROWS -->
		
        <?php if (!$editMode): ?>
          <?php for ($i = 0; $i < $num_tracks; $i++): ?>
            <div class="track-row border border-border rounded-lg p-5" data-index="<?= $i ?>">
              <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                  <i data-lucide="menu" class="drag-handle w-5 h-5 text-muted"></i>
                  <h3 class="text-lg font-semibold">Track <?= $i+1 ?></h3>
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-semibold">Track Title *</label>
                  <input type="text" name="track_title[]" required
                         class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2">
                </div>

                <div>
                  <label class="text-sm font-semibold">Artists</label>
                  <input type="text" name="artists[]"
                         class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2">
                </div>

                <div>
                  <label class="text-sm font-semibold">Songwriters</label>
                  <input type="text" name="songwriters[]"
                         class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2">
                </div>

                <div>
                  <label class="text-sm font-semibold">Producers</label>
                  <input type="text" name="producers[]"
                         class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2">
                </div>

                <div class="md:col-span-2">
                  <label class="text-sm font-semibold">Audio File *</label>
                  <input type="file" name="audio_file[]" required
                         accept=".mp3,.wav,.flac"
                         class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-4 py-2">
                </div>
              </div>

              <div class="mt-4">
                <label class="text-sm font-semibold">Explicit?</label>
                <select name="is_explicit[]" class="w-full border-b border-zinc-400/30 bg-white rounded-lg px-3 py-2">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>

              <input type="hidden" name="existing_audio_file[]" value="">
            </div>
          <?php endfor; ?>
        <?php endif; ?>


        <!-- EDIT MODE ROWS -->
        <?php if ($editMode): ?>
          <?php foreach ($tracks as $i => $t): ?>
            <div class="track-row border border-border rounded-lg p-5" data-track-id="<?= $t->id ?>">

              <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                  <i data-lucide="menu" class="drag-handle w-5 h-5 text-muted"></i>
                  <h3 class="text-lg font-semibold">Track <?= $i+1 ?></h3>
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
                  <input type="text" name="track_title[]" required
                         value="<?= $t->track_title ?>"
                         class="w-full bg-black border border-border rounded p-2">
                </div>

                <div>
                  <label class="text-sm">Artists</label>
                  <input type="text" name="artists[]"
                         value="<?= $t->artists ?>"
                         class="w-full bg-black border border-border rounded p-2">
                </div>

                <div>
                  <label class="text-sm">Songwriters</label>
                  <input type="text" name="songwriters[]"
                         value="<?= $t->songwriters ?>"
                         class="w-full bg-black border border-border rounded p-2">
                </div>

                <div>
                  <label class="text-sm">Producers</label>
                  <input type="text" name="producers[]"
                         value="<?= $t->producers ?>"
                         class="w-full bg-black border border-border rounded p-2">
                </div>

                <div class="md:col-span-2">
                  <label class="text-sm">Current Audio:</label>
                  <div class="text-muted text-xs mb-2"><?= basename($t->audio_file) ?></div>

                  <label class="text-sm">Replace Audio (Optional)</label>
                  <input type="file" name="audio_file[]" accept=".mp3,.wav,.flac"
                         class="w-full bg-black border border-border rounded p-2">
                </div>

              </div>

              <div class="mt-4">
                <label class="text-sm">Explicit?</label>
                <select name="is_explicit[]" class="bg-black border border-border rounded p-2">
                  <option value="0" <?= $t->is_explicit == 0 ? "selected" : "" ?>>No</option>
                  <option value="1" <?= $t->is_explicit == 1 ? "selected" : "" ?>>Yes</option>
                </select>
              </div>

              <input type="hidden" name="existing_audio_file[]" value="<?= $t->audio_file ?>">

            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>

      <?php if ($editMode): ?>
      <button type="button"
              id="addTrackBtn"
              class="mt-6 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">
        + Add New Track
      </button>
      <?php endif; ?>

      <div class="flex justify-between pt-8">
        <a href="<?= base_url('UploadAlbum/step2') ?>"
             class="px-8 py-3 border border-border rounded-lg hover:bg-white/10">
            ← BACK
          </a>
        <button type="submit" onclick="prepareTrackJSON()"
                class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
          CONTINUE →
        </button>
      </div>

    </form>
  </div>
</div>


<!-- DELETE MODAL (Dark Minimal) -->
<div id="deleteModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
  <div class="modal-fade bg-card border border-border rounded-xl p-6 w-full max-w-md opacity-0 scale-95">
    <h2 class="text-xl font-semibold mb-3">Confirm Delete</h2>
    <p class="text-muted mb-6">Are you sure you want to remove this track?</p>

    <div class="flex justify-end gap-3">
      <button id="cancelDeleteBtn" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded">Cancel</button>
      <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded">Delete</button>
    </div>
  </div>
</div>


<script>
lucide.createIcons();

/* =========================
   SORTABLE (drag)
========================= */
new Sortable(document.getElementById("trackList"), {
  animation: 150,
  handle: ".drag-handle"
});


/* =========================
   DELETE TRACK MODAL
========================= */
let deleteTrackID = null;
let deleteBtnRef = null;

document.querySelectorAll(".delete-track-btn").forEach(btn => {
  btn.addEventListener("click", () => {

    deleteTrackID = btn.dataset.trackId;
    deleteBtnRef = btn;

    const modal = document.getElementById("deleteModal");
    const panel = modal.querySelector(".modal-fade");

    modal.classList.remove("hidden");

    setTimeout(() => {
      panel.classList.remove("opacity-0", "scale-95");
      panel.classList.add("opacity-100", "scale-100");
    }, 10);
  });
});

document.getElementById("cancelDeleteBtn").addEventListener("click", closeDeleteModal);

function closeDeleteModal() {
  const modal = document.getElementById("deleteModal");
  const panel = modal.querySelector(".modal-fade");

  panel.classList.add("opacity-0", "scale-95");
  panel.classList.remove("opacity-100", "scale-100");

  setTimeout(() => modal.classList.add("hidden"), 150);
}

document.getElementById("confirmDeleteBtn").addEventListener("click", () => {

  fetch("<?= base_url('UploadAlbum/delete_track/') ?>" + deleteTrackID)
  .then(r => r.json())
  .then(res => {
    if (res.success) {
      deleteBtnRef.closest(".track-row").remove();
    }
    closeDeleteModal();
  });
});


/* =========================
   ADD NEW TRACK
========================= */
let newCounter = <?= $editMode ? count($tracks) : 0 ?>;

document.getElementById("addTrackBtn")?.addEventListener("click", () => {

  newCounter++;

  const row = document.createElement("div");
  row.classList.add("track-row", "border", "border-border", "rounded-lg", "p-5", "mt-4");

  row.innerHTML = `
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <i data-lucide="menu" class="drag-handle w-5 h-5 text-muted"></i>
          <h3 class="text-lg font-semibold">Track ${newCounter}</h3>
        </div>
        <button type="button" class="text-red-400 hover:text-red-300 delete-new-track-btn">
          <i data-lucide="trash-2"></i>
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
          <label class="text-sm">Track Title *</label>
          <input type="text" name="track_title[]" required
                 class="w-full bg-black border border-border rounded p-2">
        </div>

        <div>
          <label class="text-sm">Artists</label>
          <input type="text" name="artists[]"
                 class="w-full bg-black border border-border rounded p-2">
        </div>

        <div>
          <label class="text-sm">Songwriters</label>
          <input type="text" name="songwriters[]"
                 class="w-full bg-black border border-border rounded p-2">
        </div>

        <div>
          <label class="text-sm">Producers</label>
          <input type="text" name="producers[]"
                 class="w-full bg-black border border-border rounded p-2">
        </div>

        <div class="md:col-span-2">
          <label class="text-sm">Audio File *</label>
          <input type="file" name="audio_file[]" required
                 accept=".mp3,.wav,.flac"
                 class="w-full bg-black border border-border rounded p-2">
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

  document.getElementById("trackList").appendChild(row);

  lucide.createIcons();

  row.querySelector(".delete-new-track-btn").addEventListener("click", () => row.remove());
});


/* =========================
   SERIALIZE JSON
========================= */
function prepareTrackJSON() {
  const rows = document.querySelectorAll("#trackList .track-row");
  let output = [];

  rows.forEach(row => {
    output.push({
      track_title: row.querySelector('input[name="track_title[]"]').value,
      artists: row.querySelector('input[name="artists[]"]').value,
      songwriters: row.querySelector('input[name="songwriters[]"]').value,
      producers: row.querySelector('input[name="producers[]"]').value,
      is_explicit: row.querySelector('select[name="is_explicit[]"]').value
    });
  });

  document.getElementById("track_data_json").value = JSON.stringify(output);
}
</script>

</body>
</html>
