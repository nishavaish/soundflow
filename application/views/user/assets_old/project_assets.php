<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project Assets</title>

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
            card: "#111111",
            muted: "#9ca3af"
          }
        }
      }
    }
  </script>

<script>
window.CSRF_TOKEN_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
window.CSRF_TOKEN = '<?= $this->security->get_csrf_hash(); ?>';
</script>

  <!-- Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    #uploadAssetForm {
      max-height: 0;
      opacity: 0;
    }
  </style>
</head>

<body class="bg-background text-white">
	
	  <!-- Header -->
 <?php $this->view('page_header'); ?>

<div class="container mx-auto px-6 py-8">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-bold"><?= $project->name ?></h1>
      <p class="text-muted text-sm">Project assets</p>
    </div>

    <button onclick="openUploadForm()"
            class="px-4 py-2 bg-primary text-black font-semibold rounded">
      + Upload Asset
    </button>
  </div>

  <!-- ================= Upload Form (Hidden) ================= -->
  <div id="uploadAssetForm"
       class="bg-card border border-border rounded-lg p-6 mb-8 hidden overflow-hidden transition-all duration-300">

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-lg font-semibold">
        Upload Assets to "<span class="text-primary"><?= $project->name ?></span>"
      </h2>

      <button onclick="closeUploadForm()" class="text-muted hover:text-white">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <form id="assetUploadForm" enctype="multipart/form-data">
	
	<input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">


      <input type="hidden" name="project_id" value="<?= $project->id ?>">

      <div class="grid md:grid-cols-2 gap-6 mb-4">
        <div>
          <label class="text-sm">Asset Name (optional)</label>
          <input name="asset_name"
                 class="w-full mt-1 bg-black border border-border rounded px-3 py-2">
        </div>

        <div>
          <label class="text-sm">Asset Type</label>
          <select name="asset_type"
                  class="w-full mt-1 bg-black border border-border rounded px-3 py-2">
            <option>Master Track</option>
            <option>Instrumental</option>
            <option>Stem</option>
            <option>Artwork</option>
            <option>Document</option>
          </select>
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-6 mb-4">
        <div>
          <label class="text-sm">Version</label>
          <input name="version"
                 placeholder="v1, final"
                 class="w-full mt-1 bg-black border border-border rounded px-3 py-2">
        </div>

        <div>
          <label class="text-sm">Tags</label>
          <input name="tags"
                 placeholder="lead vocal, chorus"
                 class="w-full mt-1 bg-black border border-border rounded px-3 py-2">
        </div>
      </div>

      <div class="mb-4">
        <label class="text-sm">Credits</label>
        <input name="credits"
               class="w-full mt-1 bg-black border border-border rounded px-3 py-2">
      </div>

      <div class="mb-4">
        <label class="text-sm">Notes</label>
        <textarea name="notes"
                  class="w-full mt-1 bg-black border border-border rounded px-3 py-2"></textarea>
      </div>

      <div class="mb-4">
        <label class="text-sm">Select File</label>
        <input type="file" name="file" required
               class="w-full mt-1 bg-black border border-border rounded px-3 py-2">
      </div>

      <!-- Progress -->
      <div id="progressWrap" class="hidden mb-4">
        <div class="flex justify-between text-xs mb-1">
          <span class="text-muted">Uploading...</span>
          <span id="progressPercent">0%</span>
        </div>
        <div class="w-full bg-border h-2 rounded">
          <div id="progressBar" class="bg-primary h-2 rounded w-0"></div>
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="px-5 py-2 bg-primary text-black font-semibold rounded">
          Upload Files
        </button>
      </div>

    </form>
  </div>
  
  
  
<?php if ($this->session->flashdata('flash_success')): ?>
  <div id="flashMessage"
       class="mb-6 bg-green-500/15 border border-green-500 text-green-400 px-4 py-3 rounded">
    <?= $this->session->flashdata('flash_success') ?>
  </div>
<?php endif; ?>

<?php if ($this->session->flashdata('flash_error')): ?>
  <div id="flashMessage"
       class="mb-6 bg-red-500/15 border border-red-500 text-red-400 px-4 py-3 rounded">
    <?= $this->session->flashdata('flash_error') ?>
  </div>
<?php endif; ?>


  <!-- ================= Assets Table ================= -->
  <div class="bg-card border border-border rounded-lg overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-black text-muted">
        <tr>
          <th class="p-4 text-left">Asset</th>
          <th class="p-4">Type</th>
          <th class="p-4">Version</th>
          <th class="p-4">Size</th>
          <th class="p-4">Uploaded</th>
          <th class="p-4">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($assets): foreach ($assets as $a): ?>
          <tr class="border-t border-border">
            <td class="p-4"><?= $a->asset_name ?></td>
            <td class="p-4 text-center"><?= $a->asset_type ?></td>
            <td class="p-4 text-center"><?= $a->version ?></td>
            <td class="p-4 text-center"><?= round($a->file_size / 1024 / 1024, 2) ?> MB</td>
            <td class="p-4 text-center"><?= date('d M Y', strtotime($a->created_at)) ?></td>
			
			<td class="p-4 text-right">
			  <button
				onclick='openEditAssetModal(<?= json_encode($a) ?>)'
				class="text-primary text-xs mr-3 hover:underline">
				Edit
			  </button>

			 <button
  onclick="openDeleteModal(<?= $a->id ?>)"
  class="text-red-400 text-xs hover:underline">
  Delete
</button>

			</td>

          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="5" class="p-6 text-center text-muted">
              No assets uploaded yet
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>



<div id="editAssetModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

  <div class="bg-card border border-border rounded-lg w-full max-w-lg p-6">

    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold">Edit Asset</h2>
      <button onclick="closeEditAssetModal()" class="text-muted">✕</button>
    </div>

    <form id="editAssetForm">
	
	<input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">


      <input type="hidden" name="id">

      <div class="space-y-4">

        <input name="asset_name"
               placeholder="Asset Name"
               class="w-full bg-black border border-border rounded px-3 py-2">

        <select name="asset_type"
                class="w-full bg-black border border-border rounded px-3 py-2">
          <option>Master Track</option>
          <option>Instrumental</option>
          <option>Stem</option>
          <option>Artwork</option>
          <option>Document</option>
        </select>

        <input name="version"
               placeholder="Version"
               class="w-full bg-black border border-border rounded px-3 py-2">

        <input name="tags"
               placeholder="Tags"
               class="w-full bg-black border border-border rounded px-3 py-2">

        <input name="credits"
               placeholder="Credits"
               class="w-full bg-black border border-border rounded px-3 py-2">

        <textarea name="notes"
                  placeholder="Notes"
                  class="w-full bg-black border border-border rounded px-3 py-2"></textarea>

      </div>

      <div class="flex justify-end mt-6">
        <button type="submit"
                class="px-5 py-2 bg-primary text-black rounded">
          Save Changes
        </button>
      </div>

    </form>
  </div>
</div>


<!-- Delete Asset Modal -->
<div id="deleteAssetModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/70 z-50">

  <div class="bg-card border border-border rounded-lg w-full max-w-sm p-6">

    <h3 class="text-lg font-semibold mb-2 text-white">
      Delete Asset
    </h3>

    <p class="text-sm text-muted mb-6">
      Are you sure you want to permanently delete this asset?
      This action cannot be undone.
    </p>

    <div class="flex justify-end gap-3">
      <button
        type="button"
        onclick="closeDeleteModal()"
        class="px-4 py-2 bg-gray-700 rounded text-white">
        Cancel
      </button>

      <button
        type="button"
        onclick="confirmDeleteAsset()"
        class="px-4 py-2 bg-red-600 rounded text-white font-semibold">
        Delete
      </button>
    </div>

  </div>
</div>



<!-- ================= JS ================= -->
<script>
lucide.createIcons();

function openUploadForm() {
  const f = document.getElementById('uploadAssetForm');
  f.classList.remove('hidden');
  requestAnimationFrame(() => {
    f.style.maxHeight = f.scrollHeight + 'px';
    f.style.opacity = '1';
  });
}

function closeUploadForm() {
  const f = document.getElementById('uploadAssetForm');
  f.style.maxHeight = '0px';
  f.style.opacity = '0';
  setTimeout(() => {
    f.classList.add('hidden');
    document.getElementById('assetUploadForm').reset();
    document.getElementById('progressWrap').classList.add('hidden');
    document.getElementById('progressBar').style.width = '0%';
  }, 300);
}

/* AJAX upload with progress */
document.getElementById('assetUploadForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const xhr = new XMLHttpRequest();
  const formData = new FormData(this);

  const bar = document.getElementById('progressBar');
  const percent = document.getElementById('progressPercent');
  document.getElementById('progressWrap').classList.remove('hidden');

  xhr.upload.onprogress = e => {
    if (e.lengthComputable) {
      const p = Math.round((e.loaded / e.total) * 100);
      bar.style.width = p + '%';
      percent.innerText = p + '%';
    }
  };

	  
	  xhr.onload = () => {
	  const res = JSON.parse(xhr.responseText);
	  if (res.status === 'success') {
		location.reload();
	  } else {
		alert(res.message);
	  }
	};


  xhr.open('POST', '<?= site_url("assets/upload_asset") ?>');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.send(formData);
});
</script>

<script>
function openEditAssetModal(asset) {
  const modal = document.getElementById('editAssetModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');

  const form = document.getElementById('editAssetForm');
  Object.keys(asset).forEach(k => {
    if (form[k]) form[k].value = asset[k] ?? '';
  });
}

function closeEditAssetModal() {
  document.getElementById('editAssetModal').classList.add('hidden');
}

document.getElementById('editAssetForm').addEventListener('submit', function(e) {
  e.preventDefault();

  fetch('<?= site_url("assets/update_asset") ?>', {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: new FormData(this)
  })
  .then(r => r.json())
  .then(res => {
    if (res.status === 'success') location.reload();
    else alert(res.message);
  });
});
</script>


<script>
let assetToDelete = null;

function openDeleteModal(id) {
  assetToDelete = id;
  document.getElementById('deleteAssetModal')
          .classList.remove('hidden');
  document.getElementById('deleteAssetModal')
          .classList.add('flex');
}

function closeDeleteModal() {
  assetToDelete = null;
  document.getElementById('deleteAssetModal')
          .classList.add('hidden');
}

function confirmDeleteAsset() {
  if (!assetToDelete) return;

  const fd = new FormData();
  fd.append('id', assetToDelete);
  fd.append(
    '<?= $this->security->get_csrf_token_name(); ?>',
    '<?= $this->security->get_csrf_hash(); ?>'
  );

  fetch('<?= site_url("assets/delete_asset") ?>', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: fd
  })
  .then(r => r.json())
  .then(res => {
    if (res.status === 'success') {
      location.reload(); // flash message shows
    } else {
      alert(res.message || 'Delete failed');
    }
  })
  .catch(() => alert('Request failed'));
}
</script>


<script>
setTimeout(() => {
  const flash = document.getElementById('flashMessage');
  if (flash) {
    flash.remove(); // instant remove, no transition
  }
}, 3000);
</script>


</body>
</html>
