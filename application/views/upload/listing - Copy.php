<?php
// application/views/upload/listing.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Releases - SoundFlow</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom Tailwind Colors (same as dashboard) -->
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

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    /* Additional tweaks to ensure cards and text match dashboard tone */
    body { background: theme('colors.background'); color: #e6e6e6; }
    .card { background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); }
    .muted { color: theme('colors.muted'); }
    .container-max { max-width: 1180px; }
  </style>
</head>

<body class="min-h-screen bg-background">

  <!-- Header (same as dashboard) -->
  <?php $this->view('page_header'); ?>
  
  <!-- Page container -->
  <div class="container container-max mx-auto px-6 py-8">

    <!-- Page header -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-4xl font-bold text-white">Your Releases</h1>
        <p class="text-sm muted mt-1">Manage your releases — view, edit, or remove them.</p>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?php echo site_url('UploadSingle/step1') ?>"
          class="inline-flex items-center bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] text-white px-4 py-2 rounded shadow">
          Create New
        </a>
      </div>
    </div>

    <!-- Filter area -->
    <form method="get" class="mb-6 grid grid-cols-1 sm:grid-cols-4 gap-3">
      <input type="text" name="q" value="<?php echo html_escape(@$filters['q']) ?>"
             placeholder="Search title or artist"
             class="p-2 bg-gray-900 border border-border rounded w-full text-white" />
      <input type="date" name="from" value="<?php echo html_escape(@$filters['from']) ?>"
             class="p-2 bg-gray-900 border border-border rounded w-full text-white" />
      <input type="date" name="to" value="<?php echo html_escape(@$filters['to']) ?>"
             class="p-2 bg-gray-900 border border-border rounded w-full text-white" />
      <div class="flex items-center">
        <button class="w-full bg-primary hover:opacity-95 text-white px-4 py-2 rounded">Filter</button>
      </div>
    </form>

    <!-- Flash -->
    <?php if ($this->session->flashdata('success')): ?>
      <div class="mb-4 p-3 rounded bg-green-800 text-green-100">
        <?php echo $this->session->flashdata('success') ?>
      </div>
    <?php endif; ?>

    <!-- Grid of releases -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php if (!empty($releases)): foreach ($releases as $r): ?>
        <div class="card release-card-<?php echo $r->id ?> rounded-lg overflow-hidden shadow-lg border border-border">
		
          <div class="relative h-48 bg-gray-800">
            <?php
              // show artwork if provided (using file_path from release_artwork or release)
              $artwork_url = (!empty($r->file_path)) ? base_url($r->file_path) : false;
            ?>
            <?php if ($artwork_url): ?>
              <img src="<?php echo $artwork_url ?>" alt="cover" class="w-full h-full object-cover" />
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-gray-500">
                <svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4M3 11h18" />
                </svg>
              </div>
            <?php endif; ?>
          </div>

          <div class="p-4">
            <h3 class="text-lg font-semibold leading-tight text-white"><?php echo html_escape($r->title) ?></h3>
            <p class="text-sm muted mt-1"><?php echo html_escape($r->primary_artist) ?></p>

            <div class="mt-3 flex items-center justify-between text-sm muted">
              <div>
                <span class="inline-block mr-2"><?php echo html_escape($r->genre ?: '—') ?></span>
                <span class="mx-1">•</span>
                <span><?php echo ($r->release_date) ? date('d M Y', strtotime($r->release_date)) : '—' ?></span>
              </div>
            </div>

            <div class="mt-4 flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <a href="<?php echo site_url('my-releases/view/'.$r->id) ?>" class="text-indigo-400 hover:underline">View</a>
                <a href="<?php echo site_url('my-releases/edit/step-1/'.$r->id) ?>" class="text-yellow-400 hover:underline">Edit</a>
              </div>

              <button
                data-id="<?php echo $r->id ?>"
                data-title="<?php echo htmlspecialchars($r->title, ENT_QUOTES) ?>"
                class="delete-btn text-red-400 hover:underline focus:outline-none"
                type="button">
                Delete
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <div class="col-span-full p-6 bg-card rounded text-muted text-center">
          <div class="text-lg font-semibold mb-2">No releases yet</div>
          <div class="mb-4">You haven't uploaded any releases. Click below to create your first release.</div>
          <a href="<?php echo site_url('UploadSingle/step1') ?>"
             class="inline-block px-6 py-2 rounded-md bg-gradient-to-r from-primary to-[hsl(220,70%,60%)] text-white">
            Create Your First Release
          </a>
        </div>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
      <?php echo $pagination ?>
    </div>
  </div>

  <!-- Delete Confirmation Modal (hidden by default) -->
  <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black opacity-60"></div>
    <div class="relative bg-card rounded-lg shadow-xl w-full max-w-md mx-4">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-white">Confirm delete</h2>
        <p class="muted mt-2" id="deleteModalText">Are you sure you want to delete this release?</p>

        <!-- Delete form posts to delete endpoint (POST) -->
        <form id="deleteForm" method="post" class="mt-4">
          <?php
            // CSRF token (works when CI csrf_protection = TRUE)
            $csrf_name = $this->security->get_csrf_token_name();
            $csrf_hash = $this->security->get_csrf_hash();
          ?>
          <input type="hidden" name="<?php echo $csrf_name ?>" value="<?php echo $csrf_hash ?>" />
          <input type="hidden" name="release_id" id="deleteReleaseId" value="" />
          <div class="flex items-center justify-end space-x-3 mt-6">
            <button type="button" id="modalCancel" class="px-4 py-2 rounded bg-gray-800 text-gray-200">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- lucide init -->
  <script>lucide.createIcons();</script>

  <!-- Modal + Delete JS -->
 <script>
(function() {

  const modal = document.getElementById('deleteModal');
  const modalText = document.getElementById('deleteModalText');
  const deleteForm = document.getElementById('deleteForm');
  const deleteIdInput = document.getElementById('deleteReleaseId');
  const cancelBtn = document.getElementById('modalCancel');

  // Show modal for click
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      const id = this.dataset.id;
      const title = this.dataset.title || "this release";

      modalText.textContent = `Are you sure you want to delete "${title}"?`;
      deleteIdInput.value = id;

      // Store card DOM element so we can remove it after success
      deleteForm.dataset.cardSelector = `.release-card-${id}`;

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  });

  cancelBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  });

  // AJAX DELETE handler
  deleteForm.addEventListener('submit', function(e){
    e.preventDefault();

    const id = deleteIdInput.value;
    const ajaxUrl = "<?php echo site_url('UploadSingle/delete') ?>/" + id;

    const formData = new FormData(deleteForm);

    fetch(ajaxUrl, {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {

      if (data.success) {
        // Remove card visually
        const cardSel = deleteForm.dataset.cardSelector;
        const cardEl = document.querySelector(cardSel);
        if (cardEl) cardEl.remove();

        modal.classList.add('hidden');
        modal.classList.remove('flex');
      } else {
        alert("Error: " + data.message);
      }

    })
    .catch(err => {
      alert("Network error");
      console.error(err);
    });

  });

})();
</script>

</body>
</html>
