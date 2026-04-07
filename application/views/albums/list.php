<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Your Albums - SoundFlow</title>

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

<script src="https://unpkg.com/lucide@latest"></script>

<style>
body { background: #000; color: #e6e6e6; }

/* ======================
   GRID CARD (Spotify)
====================== */
.card-hover {
    transition: all .35s ease;
}
.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(255,255,255,0.08);
}

.play-overlay {
    position:absolute;
    inset:0;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    opacity:0;
    display:flex;
    align-items:center;
    justify-content:center;
    transition: opacity .25s ease;
}
.card:hover .play-overlay {
    opacity:1;
}

/* ======================
   LIST VIEW STYLING
====================== */
.list-row {
    display: grid;
    grid-template-columns: 56px 1fr 1fr 160px 120px;
    gap: 16px;
    align-items: center;
    padding: 14px 16px;
    border-radius: 8px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    transition: all .25s ease;
}
.list-row:hover {
    background: rgba(255,255,255,0.10);
    border-color: rgba(255,255,255,0.18);
    transform: translateY(-2px);
}

/* ========== SELECTED (Spotify green bar) ========== */
.list-row.selected {
    position: relative;
    background: rgba(30,215,96,0.15) !important;
    border-color: rgba(30,215,96,0.35) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(30,215,96,0.25);
}
.list-row.selected::before {
    content: "";
    position: absolute;
    left: 0;
    top: 6px;
    bottom: 6px;
    width: 4px;
    border-radius: 4px;
    background: #1DB954;
}

/* ========== DELETE ANIMATION ========== */
.delete-anim { transition: all .35s ease; }
.delete-anim.hide {
    opacity:0;
    transform:scale(.85);
    height:0;
    margin:0 !important;
    padding:0 !important;
}

/* ========== TOASTS ========== */
#toastContainer { z-index: 99999; }
.toast {
    min-width: 240px;
    padding: 14px 18px;
    border-radius: 10px;
    color: #fff;
    font-size: 14px;
    opacity: 0;
    transform: translateX(40px);
    transition: all 0.4s ease;
}
.toast.show {
    opacity: 1;
    transform: translateX(0);
}
.toast-success { background: rgba(30,215,96,0.9); }
.toast-error { background: rgba(255,50,50,0.9); }

/* ========== SHAKE ========== */
@keyframes shake {
    0% { transform: translateX(0); }
    20% { transform: translateX(-8px); }
    40% { transform: translateX(8px); }
    60% { transform: translateX(-6px); }
    80% { transform: translateX(6px); }
    100% { transform: translateX(0); }
}
.modal-shake { animation: shake .4s ease; }
</style>
</head>

<body>

<?php $this->view('page_header'); ?>

<div class="max-w-6xl mx-auto px-6 py-8">

    <!-- Page header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold">Your Albums</h1>
            <p class="text-sm muted mt-1">Manage your uploaded albums.</p>
        </div>

        <div class="flex items-center gap-3">

            <!-- GRID / LIST TOGGLE -->
            <div class="flex bg-card border border-border rounded-lg overflow-hidden">
                <button id="gridBtn" class="px-3 py-2 flex items-center gap-1 hover:bg-gray-800">
                    <i data-lucide="grid"></i> <span class="hidden sm:inline">Grid</span>
                </button>
                <button id="listBtn" class="px-3 py-2 flex items-center gap-1 hover:bg-gray-800">
                    <i data-lucide="list"></i> <span class="hidden sm:inline">List</span>
                </button>
            </div>

            <a href="<?= site_url('UploadAlbum/step1') ?>"
               class="px-4 py-2 rounded bg-primary text-white">
               Create Album
            </a>
        </div>
    </div>

    <!-- GRID WRAPPER -->
    <div id="gridWrapper" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
<?php foreach ($albums as $album): ?>
<?php
    $cover = $album->cover_art ? base_url($album->cover_art) : null;
    $album_id = $album->id;
?>

<div class="card delete-anim release-card-<?= $album_id ?> rounded-lg overflow-hidden border border-border card-hover relative">

    <!-- Cover -->
    <div class="relative h-48 bg-gray-800">
        <?php if ($cover): ?>
            <img src="<?= $cover ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-gray-600">
                <i data-lucide="image" class="w-10 h-10"></i>
            </div>
        <?php endif; ?>

        <!-- Play overlay -->
        <div class="play-overlay">
            <div class="p-3 bg-primary text-black rounded-full shadow-lg">
                <i data-lucide="play" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Album info -->
    <div class="p-4">
        <h3 class="text-lg font-semibold"><?= $album->album_title ?></h3>
        <p class="text-sm muted"><?= $album->artist ?></p>

        <p class="text-xs muted mt-1">
            <?= $album->genre ?> • <?= date('d M Y', strtotime($album->release_date)) ?>
        </p>

        <!-- Action icons -->
        <div class="mt-4 flex items-center justify-end gap-4">
            <a href="<?= site_url('my-albums/view/'.$album_id) ?>" title="View">
                <i data-lucide="eye" class="w-5 h-5 text-indigo-400 hover:text-indigo-300"></i>
            </a>
            <a href="<?= site_url('my-albums/edit/step-1/'.$album_id) ?>" title="Edit">
                <i data-lucide="pencil" class="w-5 h-5 text-yellow-400 hover:text-yellow-300"></i>
            </a>
            <button class="delete-btn" data-id="<?= $album_id ?>" data-title="<?= htmlspecialchars($album->album_title) ?>" title="Delete">
                <i data-lucide="trash-2" class="w-5 h-5 text-red-400 hover:text-red-300"></i>
            </button>
        </div>
    </div>
</div>

<?php endforeach; ?>
</div> <!-- END GRID WRAPPER -->

<!-- LIST WRAPPER -->
<div id="listWrapper" class="hidden flex flex-col gap-2 mt-6">

<?php foreach ($albums as $album): ?>
<?php
    $cover = $album->cover_art ? base_url($album->cover_art) : null;
    $album_id = $album->id;
?>

<div class="list-row delete-anim release-card-<?= $album_id ?>" data-id="<?= $album_id ?>">

    <!-- Thumbnail -->
    <?php if ($cover): ?>
        <img src="<?= $cover ?>" class="w-12 h-12 rounded object-cover">
    <?php else: ?>
        <div class="w-12 h-12 rounded bg-gray-800 flex items-center justify-center">
            <i data-lucide="image" class="w-5 h-5 text-gray-500"></i>
        </div>
    <?php endif; ?>

    <!-- Title / Artist -->
    <div>
        <div class="font-semibold"><?= $album->album_title ?></div>
        <div class="text-sm muted"><?= $album->artist ?></div>
    </div>

    <!-- Genre -->
    <div class="text-sm muted"><?= $album->genre ?></div>

    <!-- Date & Type -->
    <div class="text-sm muted">
        <?= date('d M Y', strtotime($album->release_date)) ?>
        <span class="ml-2 text-xs bg-gray-700 px-2 py-1 rounded"><?= $album->album_type ?></span>
    </div>

    <!-- Action Icons -->
    <div class="flex items-center gap-4 justify-end">
        <a href="<?= site_url('my-albums/view/'.$album_id) ?>" title="View">
            <i data-lucide="eye" class="w-5 h-5 text-indigo-400 hover:text-indigo-300"></i>
        </a>
        <a href="<?= site_url('my-albums/edit/step-1/'.$album_id) ?>" title="Edit">
            <i data-lucide="pencil" class="w-5 h-5 text-yellow-400 hover:text-yellow-300"></i>
        </a>
        <button class="delete-btn" data-id="<?= $album_id ?>" data-title="<?= htmlspecialchars($album->album_title) ?>" title="Delete">
            <i data-lucide="trash-2" class="w-5 h-5 text-red-400 hover:text-red-300"></i>
        </button>
    </div>

</div>
<?php endforeach; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?= $pagination ?>
</div>

</div> <!-- END PAGE WRAPPER -->

<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/70"></div>

    <div class="modal-box relative bg-card p-6 rounded-lg w-full max-w-md border border-border">
        <h2 class="text-xl font-semibold">Confirm Delete</h2>
        <p class="muted mt-2" id="deleteModalText"></p>

        <form id="deleteForm" method="post" class="mt-4">
            <input type="hidden"
                   name="<?= $this->security->get_csrf_token_name() ?>"
                   value="<?= $this->security->get_csrf_hash() ?>">

            <input type="hidden" id="deleteAlbumId" name="album_id">

            <div class="flex justify-end mt-6 gap-3">
                <button type="button" id="modalCancel" class="px-4 py-2 bg-gray-700 rounded">Cancel</button>
                <button class="px-4 py-2 bg-red-600 rounded text-white">Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed top-5 right-5 space-y-3"></div>

<script>
lucide.createIcons();

/* =======================
   GRID / LIST TOGGLE
======================= */
const gridWrapper = document.getElementById("gridWrapper");
const listWrapper = document.getElementById("listWrapper");
document.getElementById("gridBtn").onclick = () => {
    gridWrapper.classList.remove("hidden");
    listWrapper.classList.add("hidden");
};
document.getElementById("listBtn").onclick = () => {
    listWrapper.classList.remove("hidden");
    gridWrapper.classList.add("hidden");
};

/* =======================
   SPOTIFY SELECTION
======================= */
document.querySelectorAll(".list-row").forEach(row => {
    row.addEventListener("click", () => {
        document.querySelectorAll(".list-row").forEach(r => r.classList.remove("selected"));
        row.classList.add("selected");
    });

    /* DOUBLE CLICK → VIEW */
    row.addEventListener("dblclick", () => {
        const id = row.dataset.id;
        window.location.href = "<?= site_url('my-albums/view/') ?>" + id;
    });
});

/* =======================
   DELETE MODAL
======================= */
const modal = document.getElementById("deleteModal");
const deleteText = document.getElementById("deleteModalText");
const deleteIdField = document.getElementById("deleteAlbumId");

document.querySelectorAll(".delete-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        deleteText.textContent = `Delete "${btn.dataset.title}"?`;
        deleteIdField.value = btn.dataset.id;

        modal.classList.remove("hidden");
        modal.classList.add("flex");
    });
});
document.getElementById("modalCancel").onclick = () => modal.classList.add("hidden");

/* =======================
   TOASTS + SHAKE
======================= */
function showToast(message, type="success") {
    const c = document.getElementById("toastContainer");
    const t = document.createElement("div");
    t.className = `toast toast-${type}`;
    t.textContent = message;
    c.appendChild(t);
    setTimeout(() => t.classList.add("show"), 20);
    setTimeout(() => {
        t.classList.remove("show");
        setTimeout(() => t.remove(), 400);
    }, 3000);
}

function shakeModal() {
    const box = document.querySelector(".modal-box");
    box.classList.add("modal-shake");
    setTimeout(() => box.classList.remove("modal-shake"), 500);
}

/* =======================
   DELETE AJAX
======================= */
document.getElementById("deleteForm").onsubmit = function(e){
    e.preventDefault();

    const id = deleteIdField.value;
    const url = "<?= site_url('UploadAlbum/delete') ?>/" + id;
    
    fetch(url, {
        method: "POST",
        body: new FormData(this)
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {

            // remove card/list row
            let card = document.querySelector(".release-card-" + id);
            card.classList.add("hide");
            setTimeout(() => card.remove(), 350);

            modal.classList.add("hidden");
            showToast("Album deleted successfully!", "success");

        } else {
            showToast("Error: " + d.message, "error");
            shakeModal();
        }
    })
    .catch(() => {
        showToast("Network error", "error");
        shakeModal();
    });
};
</script>

</body>
</html>
