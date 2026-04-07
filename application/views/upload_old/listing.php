<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Releases - SoundFlow</title>

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
        body {
            background: #000;
            color: #e6e6e6;
        }

        /* ====== GRID CARD ANIMATIONS ====== */
        .card-hover {
            transition: all .35s ease;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.08);
        }

        /* ----- Play Overlay Like Spotify ----- */
        .play-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity .25s ease;
        }

        .card:hover .play-overlay {
            opacity: 1;
        }

        /* ====== LIST VIEW ROW ====== */
        /* ====== LIST VIEW ROW (Improved Visibility) ====== */
        .list-row {
            display: grid;
            grid-template-columns: 48px 1fr 1fr 140px 120px;

            gap: 12px;
            align-items: center;
            padding: 12px 16px;
            border-radius: 10px;

            /* NEW — Light tinted background so rows stand out */
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);

            transition: background .25s ease, transform .25s ease, border-color .25s ease;
        }

        /* ====== HOVER STATE (Stronger & Spotify-like) ====== */
        .list-row:hover {
            background: rgba(255, 255, 255, 0.10);
            border-color: rgba(255, 255, 255, 0.18);
            transform: translateY(-2px);
        }


        .list-row:not(:last-child) {
            margin-bottom: 4px;
        }


        /* ====== SELECTED STATE — Spotify Style ====== */
        .list-row.selected {
            position: relative;
            background: rgba(30, 215, 96, 0.15) !important;
            /* Spotify green tint */
            border-color: rgba(30, 215, 96, 0.35) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(30, 215, 96, 0.25);
        }

        /* Spotify green bar */
        .list-row.selected::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 4px;
            border-radius: 4px;
            background: #1DB954;
            /* Spotify Green */
        }

        /* ====== MODAL BACKDROP (More Visible) ====== */
        #deleteModal .modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            /* More opaque */
            backdrop-filter: blur(4px);
            /* Smooth blur effect */
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        #deleteModal.flex .modal-backdrop {
            opacity: 1;
        }

        /* ====== MODAL BOX - Better Highlight & Elevation ====== */
        #deleteModal .modal-box {
            background: #111;
            /* Spotify-dark */
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 24px;

            /* Glow */
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.65),
                0 0 0 2px rgba(255, 255, 255, 0.08);

            opacity: 0;
            transform: translateY(20px) scale(0.97);
            transition: all 0.25s ease;
        }

        #deleteModal.flex .modal-box {
            opacity: 1;
            transform: translateY(0px) scale(1);
        }


        /* DELETE ANIMATION */
        .delete-anim {
            transition: all .35s ease;
        }

        .delete-anim.hide {
            opacity: 0;
            transform: scale(.85);
            height: 0;
            margin: 0 !important;
            padding: 0 !important;
        }


        /* ====== TOAST NOTIFICATION ====== */
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

        .toast-success {
            background: rgba(30, 215, 96, 0.9);
            /* Spotify green */
        }

        .toast-error {
            background: rgba(255, 50, 50, 0.9);
        }

        /* ====== SHAKE ANIMATION FOR MODAL ====== */
        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-8px);
            }

            40% {
                transform: translateX(8px);
            }

            60% {
                transform: translateX(-6px);
            }

            80% {
                transform: translateX(6px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .modal-shake {
            animation: shake 0.4s ease;
        }
    </style>
</head>

<body class="min-h-screen">

    <?php $this->view('page_header'); ?>

    <div class="max-w-6xl mx-auto px-6 py-8">

        <!-- PAGE HEADER -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold">Your Releases</h1>
                <p class="text-sm muted mt-1">Manage, edit, and publish your releases.</p>
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

                <a href="<?= site_url('UploadSingle/step1') ?>" class="px-4 py-2 rounded bg-primary text-white">Create
                    New</a>
            </div>
        </div>

        <!-- FILTERS -->
        <form method="get" class="mb-6 grid grid-cols-1 sm:grid-cols-4 gap-4">
            <input type="text" name="q" value="<?= @$filters['q'] ?>" placeholder="Search title or artist"
                class="p-2 bg-gray-900 border border-border rounded text-white" />
            <input type="date" name="from" value="<?= @$filters['from'] ?>"
                class="p-2 bg-gray-900 border border-border rounded text-white" />
            <input type="date" name="to" value="<?= @$filters['to'] ?>"
                class="p-2 bg-gray-900 border border-border rounded text-white" />
            <button class="bg-primary text-white rounded px-4 py-2">Filter</button>
        </form>

        <!-- GRID VIEW CONTAINER -->
        <div id="gridWrapper" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php foreach ($releases as $r): ?>
                <?php $art = $r->file_path ? base_url($r->file_path) : null; ?>

                <div
                    class="card delete-anim release-card-<?= $r->id ?> rounded-lg overflow-hidden border border-border card-hover relative">

                    <!-- COVER -->
                    <div class="relative h-48 w-full bg-gray-800">
                        <?php if ($art): ?>
                            <img src="<?= $art ?>" class="w-full h-full object-cover" />
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-600">
                                <i data-lucide="image" class="w-10 h-10"></i>
                            </div>
                        <?php endif; ?>

                        <!-- PLAY OVERLAY -->
                        <div class="play-overlay">
                            <div class="p-3 bg-primary text-black rounded-full shadow-lg">
                                <i data-lucide="play" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    <!-- INFO -->
                    <div class="p-4">
                        <h3 class="font-semibold text-lg"><?= $r->title ?></h3>
                        <p class="muted text-sm"><?= $r->primary_artist ?></p>

                        <p class="text-xs muted mt-1">
                            <?= $r->genre ?> • <?= date('d M Y', strtotime($r->release_date)) ?>
                        </p>

                        <div class="mt-3 flex items-center justify-between">
                            <!-- ACTION ICONS FOR GRID VIEW -->
                            <div class="mt-4 flex items-center justify-end gap-4">

                                <a href="<?= site_url('my-releases/view/' . $r->id) ?>" title="View">
                                    <i data-lucide="eye" class="w-5 h-5 text-indigo-400 hover:text-indigo-300"></i>
                                </a>

                                <?php if ((int) $r->is_active === 0): ?>
                                    <!-- ACTION ICONS (Only when NOT approved) -->
                                    <div class="flex items-center justify-end gap-4">


                                        <a href="<?= site_url('my-releases/edit/step-1/' . $r->id) ?>" title="Edit">
                                            <i data-lucide="pencil" class="w-5 h-5 text-yellow-400 hover:text-yellow-300"></i>
                                        </a>

                                        <button class="delete-btn" data-id="<?= $r->id ?>"
                                            data-title="<?= htmlspecialchars($r->title, ENT_QUOTES, 'UTF-8') ?>" title="Delete">
                                            <i data-lucide="trash-2" class="w-5 h-5 text-red-400 hover:text-red-300"></i>
                                        </button>

                                    </div>

                                <?php else: ?>
                                    <!-- APPROVED BADGE -->
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full
                   text-sm font-semibold
                   bg-emerald-100 text-emerald-700
                   dark:bg-emerald-900 dark:text-emerald-300">

                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        Approved
                                    </span>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <!-- LIST VIEW -->
        <div id="listWrapper" class="hidden flex flex-col gap-2 mt-4">

            <?php foreach ($releases as $r): ?>
                <?php $art = $r->file_path ? base_url($r->file_path) : null; ?>

                <div class="list-row delete-anim release-card-<?= $r->id ?>" data-id="<?= $r->id ?>">

                    <!-- ART -->
                    <?php if ($art): ?>
                        <img src="<?= $art ?>" class="w-12 h-12 rounded object-cover">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded bg-gray-800 flex items-center justify-center">
                            <i data-lucide="image" class="w-5 h-5 text-gray-500"></i>
                        </div>
                    <?php endif; ?>

                    <!-- TITLE -->
                    <div>
                        <div class="font-semibold"><?= $r->title ?></div>
                        <div class="text-sm muted"><?= $r->primary_artist ?></div>
                    </div>

                    <!-- GENRE -->
                    <div class="text-sm muted">Genre: <?= ucfirst($r->genre) ?></div>

                    <!-- DATE + TYPE -->
                    <div class="text-sm muted">
                        <?= date('d M Y', strtotime($r->release_date)) ?>

                    </div>

                    <!-- MORE MENU -->
                    <!-- ACTION ICONS INSIDE ROW (REPLACE OLD MENU) -->
                    <div class="flex items-center gap-4 justify-end pr-2">

                        <a href="<?= site_url('my-releases/view/' . $r->id) ?>" title="View">
                            <i data-lucide="eye" class="w-5 h-5 text-indigo-400 hover:text-indigo-300"></i>
                        </a>

                        <?php if ((int) $r->is_active === 0): ?>
                            <!-- ACTION ICONS (Only when NOT approved) -->
                            <div class=" flex items-center justify-end gap-4">


                                <a href="<?= site_url('my-releases/edit/step-1/' . $r->id) ?>" title="Edit">
                                    <i data-lucide="pencil" class="w-5 h-5 text-yellow-400 hover:text-yellow-300"></i>
                                </a>

                                <button class="delete-btn" data-id="<?= $r->id ?>"
                                    data-title="<?= htmlspecialchars($r->title, ENT_QUOTES, 'UTF-8') ?>" title="Delete">
                                    <i data-lucide="trash-2" class="w-5 h-5 text-red-400 hover:text-red-300"></i>
                                </button>

                            </div>

                        <?php else: ?>
                            <!-- APPROVED BADGE -->
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full
                   text-sm font-semibold
                   bg-emerald-100 text-emerald-700
                   dark:bg-emerald-900 dark:text-emerald-300">

                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Approved
                            </span>
                        <?php endif; ?>

                    </div>


                </div>
            <?php endforeach; ?>

        </div>


        <div class="mt-8"><?= $pagination ?></div>

    </div>

    <!-- DELETE MODAL -->


    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">

        <!-- BACKDROP -->
        <div class="modal-backdrop"></div>

        <!-- MODAL BOX -->
        <div class="modal-box relative w-full max-w-md">

            <h2 class="text-xl font-semibold text-white">Confirm Delete</h2>
            <p class="muted mt-2" id="deleteModalText"></p>

            <form id="deleteForm" method="post" class="mt-4">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" id="deleteReleaseId" name="release_id">

                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" id="modalCancel" class="px-4 py-2 rounded bg-gray-700 text-gray-200">
                        Cancel
                    </button>

                    <button class="px-4 py-2 rounded bg-red-600 text-white">
                        Delete
                    </button>
                </div>
            </form>

        </div>
    </div>


    <script>
        lucide.createIcons();

        /* GRID / LIST TOGGLE */
        document.getElementById("gridBtn").onclick = () => {
            gridWrapper.classList.remove("hidden");
            listWrapper.classList.add("hidden");
        };

        document.getElementById("listBtn").onclick = () => {
            listWrapper.classList.remove("hidden");
            gridWrapper.classList.add("hidden");
        };

        /* DELETE MODAL */
        const modal = document.getElementById("deleteModal");
        const text = document.getElementById("deleteModalText");
        const deleteInput = document.getElementById("deleteReleaseId");

        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.onclick = () => {
                text.textContent = `Delete "${btn.dataset.title}"?`;
                deleteInput.value = btn.dataset.id;
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            };
        });
        document.getElementById("modalCancel").onclick = () => modal.classList.add("hidden");

        /* AJAX DELETE */
        /* AJAX DELETE */
        document.getElementById("deleteForm").onsubmit = function (e) {
            e.preventDefault();

            const id = deleteReleaseId.value;
            const url = "<?= site_url('UploadSingle/delete') ?>/" + id;

            fetch(url, {
                method: "POST",
                body: new FormData(this)
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {

                        // delete animation
                        const card = document.querySelector(".release-card-" + id);
                        card.classList.add("hide");
                        setTimeout(() => card.remove(), 350);

                        // close modal
                        deleteModal.classList.add("hidden");

                        // SUCCESS TOAST
                        showToast("Release deleted successfully!", "success");

                    } else {
                        // ERROR TOAST
                        showToast("Error: " + d.message, "error");

                        // SHAKE ANIMATION
                        shakeModal();
                    }
                })
                .catch(() => {
                    showToast("Network error!", "error");
                    shakeModal();
                });
        };




        /* ====== LIST ROW CLICK SELECTION ====== */
        document.querySelectorAll(".list-row").forEach(row => {
            row.addEventListener("click", () => {
                // remove previous selection
                document.querySelectorAll(".list-row").forEach(r => r.classList.remove("selected"));
                // select clicked row
                row.classList.add("selected");
            });
        });


        /* DOUBLE CLICK TO OPEN (Spotify-like behavior) */
        document.querySelectorAll(".list-row").forEach(row => {
            row.addEventListener("dblclick", () => {
                const id = row.dataset.id;
                window.location.href = "<?= site_url('my-releases/view/') ?>" + id;
            });
        });

    </script>



    <script>
        /* ===========================
       TOAST NOTIFICATIONS
    =========================== */
        function showToast(message, type = "success") {
            const container = document.getElementById("toastContainer");

            const toast = document.createElement("div");
            toast.className = `toast toast-${type}`;
            toast.textContent = message;

            container.appendChild(toast);

            // show animation
            setTimeout(() => toast.classList.add("show"), 50);

            // auto hide
            setTimeout(() => {
                toast.classList.remove("show");
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }

        /* ===========================
           SHAKE ANIMATION ON ERROR
        =========================== */
        function shakeModal() {
            const box = document.querySelector("#deleteModal .modal-box");
            box.classList.add("modal-shake");

            setTimeout(() => {
                box.classList.remove("modal-shake");
            }, 500);
        }

    </script>
    <!-- TOAST CONTAINER -->
    <div id="toastContainer" class="fixed top-5 right-5 z-[9999] space-y-3"></div>


</body>

</html>