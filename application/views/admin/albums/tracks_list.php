<meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
<meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<style>
    .dataTables_wrapper {
        color: #d1d5db;
        font-size: 0.875rem;
    }

    .dataTables_filter input,
    .dataTables_length select {
        background: #0f0f0f;
        color: #fff;
        border: 1px solid #2a2a2a;
        border-radius: 6px;
        padding: 6px 10px;
    }

    .dataTables_paginate a {
        color: #9ca3af !important;
    }

    .dataTables_paginate .current {
        background: #f97316 !important;
        color: #000 !important;
    }
</style>

<style>
    /* Restore DataTables sorting icons (Tailwind fix) */
    table.dataTable thead th {
        position: relative;
        cursor: pointer;
    }

    table.dataTable thead th.sorting:after,
    table.dataTable thead th.sorting_asc:after,
    table.dataTable thead th.sorting_desc:after {
        position: absolute;
        right: 0.75rem;
        opacity: 0.6;
    }

    table.dataTable thead th.sorting:after {
        content: "⇅";
    }

    table.dataTable thead th.sorting_asc:after {
        content: "↑";
    }

    table.dataTable thead th.sorting_desc:after {
        content: "↓";
    }
</style>


<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <div> &nbsp; </div>

    <a href="<?= base_url('admin/albums') ?>" class="text-gray-400 hover:text-white text-sm">
        ← Back to Albums
    </a>
</div>

<div class="flex justify-between items-center mb-6">
    <!-- Left: Page title -->
    <h2 class="text-xl font-semibold text-white">
        Tracks | <?= $album->album_title ?>
    </h2>


    <!-- Right: Action buttons -->
    <div class="flex gap-3">
        <!-- Upload Button -->
        <button onclick="openUploadModal()"
            class="flex items-center gap-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md shadow">

            <!-- Upload Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v-8m0 0l-4 4m4-4l4 4" />
            </svg>

            <span>Upload Streaming Report</span>
        </button>

        <!-- Download Button -->
        <a href="<?= base_url('admin/albums/download_template') ?>"
            class="flex items-center gap-2 border border-gray-600  text-gray-300 hover:bg-gray-800       px-4 py-2 rounded-md">

            <!-- Download Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0 0l-4-4m4 4l4-4" />
            </svg>

            <span>Download Template</span>
        </a>
    </div>
</div>


<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 z-50 hidden items-center justify-center">

    <!-- Backdrop -->
    <div onclick="closeUploadModal()" class="absolute inset-0 bg-black/70 backdrop-blur-sm">
    </div>

    <!-- Modal Box -->
    <div class="relative bg-[#0f0f0f] w-full max-w-md rounded-xl shadow-xl p-6 z-10">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-white">
                Upload Streaming Report
            </h3>
            <button onclick="closeUploadModal()" class="text-gray-400 hover:text-white text-xl">
                ✕
            </button>
        </div>

        <!-- Form -->
        <form action="<?= base_url('admin/albums/upload_streaming_excel/' . $album->id) ?>" method="post"
            enctype="multipart/form-data" class="space-y-4">

            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">



            <div>
                <label class="block text-sm text-gray-400 mb-1">
                    Select Excel / CSV File
                </label>
                <input type="file" name="excel_file" accept=".xls,.xlsx,.csv" required class="w-full text-sm text-gray-300
                           file:bg-gray-800 file:border-0
                           file:text-white file:px-4 file:py-2
                           file:rounded-md
                           bg-gray-900 border border-gray-700 rounded-md">
            </div>

            <div class="bg-black rounded-md p-3 text-sm text-gray-400">
                <strong class="text-gray-300">Required Columns:</strong><br>
                ISRC | Platform | Streams | Revenue | Downloads
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 text-gray-300 hover:text-white">
                    Cancel
                </button>

                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">
                    Upload
                </button>
            </div>

        </form>
    </div>
</div>



<!-- ISRC MODAL -->
<div id="isrcModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">

    <div class="bg-[#0f0f0f] w-full max-w-md rounded-lg border border-zinc-800 shadow-xl">

        <!-- Header -->
        <div class="flex justify-between items-center px-5 py-4 border-b border-zinc-800">
            <h2 class="text-white text-lg font-semibold">
                Add / Update ISRC
            </h2>
            <button onclick="closeIsrcModal()" class="text-zinc-400 hover:text-white">
                ✕
            </button>
        </div>

        <!-- Body -->
        <form id="isrcForm" class="px-5 py-4 space-y-4">

            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>" id="csrf_token">


            <input type="hidden" name="track_id" id="isrc_track_id">

            <div>
                <label class="text-xs text-zinc-400">Track</label>
                <div id="isrc_track_title" class="text-white text-sm font-medium"></div>
            </div>

            <div>
                <label class="block text-sm text-zinc-300 mb-1">ISRC Code</label>
                <input type="text" name="isrc" id="isrc_input" maxlength="12" placeholder="INABC2500001"
                    class="w-full bg-black border border-zinc-700 rounded px-3 py-2 text-white text-sm focus:outline-none focus:border-indigo-500"
                    required>
                <p class="text-xs text-zinc-500 mt-1">
                    12 characters (Country + Registrant + Year + Code)
                </p>
            </div>

            <div id="isrc_error" class="text-red-500 text-xs hidden"></div>
            <div id="isrc_success" class="text-green-500 text-xs hidden"></div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 pt-4 border-t border-zinc-800">
                <button type="button" onclick="closeIsrcModal()"
                    class="px-4 py-2 text-sm rounded bg-zinc-800 hover:bg-zinc-700 text-white">
                    Cancel
                </button>

                <button type="submit" class="px-4 py-2 text-sm rounded bg-indigo-600 hover:bg-indigo-700 text-white">
                    Save ISRC
                </button>
            </div>

        </form>
    </div>
</div>


<?php if ($this->session->flashdata('error')): ?>
    <div class="mb-6 rounded-lg border border-red-700 bg-red-900/20 p-4 text-red-300">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path
                    d="M12 9v4M12 17h.01M10.29 3.86l-8.6 14.94A1 1 0 0 0 2.5 20h19a1 1 0 0 0 .87-1.5l-8.6-14.94a1 1 0 0 0-1.73 0z" />
            </svg>
            <span class="font-semibold">
                <?= $this->session->flashdata('error') ?>
            </span>
        </div>


        <?php
        $uploadErrors = $this->session->flashdata('upload_errors');
        if (!empty($uploadErrors)):
            ?>
            <div class="max-h-48 overflow-y-auto rounded-md bg-black/40 border border-red-800 p-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($uploadErrors as $err): ?>
                        <li><?= htmlentities($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>


<?php if ($this->session->flashdata('success')): ?>
    <div class="mb-6 rounded-lg border border-green-700 bg-green-900/20 p-4 text-green-300">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-semibold">
                <?= $this->session->flashdata('success') ?>
            </span>
        </div>
    </div>
<?php endif; ?>




<table id="releasesTable" class="min-w-full text-sm text-gray-300">
    <thead class="bg-[#0b0b0b] text-gray-400 uppercase text-xs">
        <tr>
            <th class="px-4 py-3">ISRC</th>
            <th class="px-4 py-3">Title</th>

            <th class="px-4 py-3 text-right">Streams</th>
            <th class="px-4 py-3 text-right">Revenue</th>
            <th class="px-4 py-3 text-right">Downloads</th>

            <th class="px-4 py-3 text-center">Approved?</th>
            <th class="px-4 py-3 text-center"> &nbsp; </th>
            <th class="px-4 py-3 text-center">Metadata</th>
            <th class="px-4 py-3 text-center">Streaming Links</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-800 bg-[#0f0f0f]">
        <?php foreach ($tracks as $t): ?>
            <tr class="hover:bg-[#151515] transition">

                <!-- <td><?= $t->isrc ?: '-' ?></td> -->
                <!-- ISRC -->
                <td class="px-4 py-3 font-medium text-white">


                    <?php if ($t->isrc) { ?>
                        <a href="<?= base_url('admin/albums/track/streams/' . $t->id) ?>">
                            <span class="badge bg-success">
                                <?= $t->isrc ?>
                            </span>
                        </a>
                    <?php } else { ?>
                        <span class="badge bg-warning text-dark">No ISRC</span>
                    <?php } ?>


                </td>

                <td><?= $t->track_title ?></td>

                <!-- Streams -->
                <td class="px-4 py-3 text-right font-semibold" data-order="<?= $t->total_streams ?>">
                    <?= number_format($t->total_streams) ?>
                </td>

                <!-- Revenue -->
                <td class="px-4 py-3 text-right font-semibold text-green-400" data-order="<?= $t->total_revenue ?>">
                    <?= number_format($t->total_revenue, 2) ?>
                </td>



                <!-- downloads -->
                <td class="px-4 py-3 text-right font-semibold" data-order="<?= $t->total_downloads ?>">
                    <?= number_format($t->total_downloads) ?>
                </td>


                <td class="px-4 py-3 text-gray-400">
                    <?= $t->is_active ? 'Yes' : 'No' ?>
                </td>



                <td class="px-4 py-3 text-gray-400">
                    <button onclick="openIsrcModal(
                            '<?= $t->id ?>',
                            '<?= htmlspecialchars($t->track_title, ENT_QUOTES) ?>',
                            '<?= $t->isrc ?>'
                        )" class="px-3 py-1 text-xs rounded bg-indigo-600 hover:bg-indigo-700 text-white">
                        <?= $t->isrc ? 'Edit ISRC' : 'Add ISRC' ?>
                    </button>
                </td>





                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-3">

                        <!-- Metadata CSV -->
                        <a href="<?= base_url('admin/albums/download_metadata/' . $t->id) ?>"
                            class="text-emerald-400 hover:text-emerald-500 text-sm">
                            Metadata
                        </a>

                        <!-- ZIP Export -->
                        <a href="<?= base_url('admin/albums/export_track_zip/' . $t->id) ?>"
                            class="text-orange-400 hover:text-orange-500 text-sm">
                            ZIP
                        </a>

                    </div>
                </td>


                <!-- Actions -->
                <td class="px-4 py-3 text-center">

                    <a href="<?= site_url('admin/streaming-links/album/' . $t->id) ?>" class="text-primary hover:underline">
                        Add Links
                    </a>

                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script>
    function openUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
    }
</script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function () {
        $('#releasesTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc']], // Release Date
            columnDefs: [
                { orderable: false, targets: [6, 7, 8] } //  Actions
            ],
            dom: '<"flex justify-between items-center mb-3"lf>rt<"flex justify-between items-center mt-3"ip>'
        });
    });
</script>

<script>
    function openIsrcModal(trackId, trackTitle, isrc) {
        document.getElementById('isrc_track_id').value = trackId;
        document.getElementById('isrc_track_title').innerText = trackTitle;
        document.getElementById('isrc_input').value = isrc || '';

        document.getElementById('isrc_error').classList.add('hidden');
        document.getElementById('isrc_success').classList.add('hidden');

        document.getElementById('isrcModal').classList.remove('hidden');
    }

    function closeIsrcModal() {
        document.getElementById('isrcModal').classList.add('hidden');
    }
</script>
<script>
    document.getElementById('isrcForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;

        ciFetch("<?= base_url('admin/albums/update_isrc') ?>", {
            body: new FormData(document.getElementById('isrcForm'))
        })
            .then(resp => {

                const successEl = document.getElementById('isrc_success');
                const errorEl = document.getElementById('isrc_error');

                // Reset first (important for resubmits)
                successEl.innerText = '';
                errorEl.innerText = '';
                successEl.classList.add('hidden');
                errorEl.classList.add('hidden');

                if (resp.status === 'success') {
                    showMessage(successEl, resp.message, 2500);

                    setTimeout(() => location.reload(), 800);
                } else {
                    showMessage(errorEl, resp.message, 3000);
                }

            });

    });


    function showMessage(el, message, timeout = 3000) {
        el.innerText = message;
        el.classList.remove('hidden');

        setTimeout(() => {
            el.innerText = '';
            el.classList.add('hidden');
        }, timeout);
    }

</script>


<script>
    /**
     * GLOBAL AJAX (FETCH) WRAPPER WITH CSRF
     * CodeIgniter compatible
     */
    window.ciFetch = function (url, options = {}) {

        const csrfName = document
            .querySelector('meta[name="csrf-name"]')
            .getAttribute('content');

        const csrfHash = document
            .querySelector('meta[name="csrf-hash"]')
            .getAttribute('content');

        // Prepare form data
        let formData = options.body instanceof FormData
            ? options.body
            : new FormData();

        // Inject CSRF token
        formData.append(csrfName, csrfHash);

        return fetch(url, {
            method: options.method || 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
            .then(res => res.json())
            .then(resp => {

                // 🔐 Refresh CSRF globally
                if (resp.csrf && resp.csrf.hash) {
                    document
                        .querySelector('meta[name="csrf-hash"]')
                        .setAttribute('content', resp.csrf.hash);
                }

                return resp;
            });
    };
</script>