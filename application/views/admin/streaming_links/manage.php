<h2 class="text-xl font-semibold mb-4">Streaming Links |  ISRC:   <?= $release->isrc ?></h2>
  
 <div class="flex justify-between items-center mb-6">
        <div>
          	<?php if($type=='single') { ?>
				<p class="text-md text-gray-400">
					<?= $release->title ?> By <?= $release->primary_artist ?> 
				</p>
				<?php } else { ?>
				<p class="text-md text-gray-400">
					Track  |  <?= $release->track_title ?>
				</p>
				<?php }  ?>
        </div>
			<?php if($type=='single') { ?>
				<a href="<?= base_url('admin/releases') ?>"
				   class="text-gray-400 hover:text-white text-sm">
					← Back to Singles
				</a>
			<?php } else { ?>
				<a href="<?= base_url('admin/albums/tracks/'.$release->album_id ) ?>"
				   class="text-gray-400 hover:text-white text-sm">
					← Back to Tracks Listing
				</a>
			<?php } ?>
		
    </div>


<?php if ($this->session->flashdata('error')): ?>
  <div class="mb-6 rounded-lg border border-red-700 bg-red-900/20 p-4 text-red-300">
    <div class="flex items-center gap-2 mb-2">
      <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path d="M12 9v4M12 17h.01M10.29 3.86l-8.6 14.94A1 1 0 0 0 2.5 20h19a1 1 0 0 0 .87-1.5l-8.6-14.94a1 1 0 0 0-1.73 0z"/>
      </svg>
      <span class="font-semibold">
        <?= $this->session->flashdata('error') ?>
      </span>
    </div>

  </div>
<?php endif; ?>
<br>



<form method="post" action="<?= site_url('admin/streaminglinks/add') ?>"
      class="bg-[#0f0f0f] border border-border rounded-lg p-4 mb-6 flex gap-3">
 <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

  <input type="hidden" name="content_type" value="<?= $type ?>">
  <input type="hidden" name="content_id" value="<?= $id ?>">

  <select name="platform" class="bg-black border border-border rounded px-3 py-2 text-sm">
   
	 <?php foreach ($platforms as $key => $p): ?>
      <option value="<?= $key ?>"><?= $p['label'] ?></option>
    <?php endforeach; ?>
  </select>

  <input type="url" name="url" placeholder="Streaming URL" class="flex-1 bg-black border border-border rounded px-3 py-2 text-sm"  required>

  <button class="bg-primary px-4 py-2 rounded text-sm font-semibold">
    Add
  </button>
</form>

<table class="w-full text-sm border border-border rounded-lg overflow-hidden">
  <thead class="bg-[#0f0f0f] text-muted">
    <tr>
      <th class="p-3 text-left">Platform</th>
      <th class="p-3 text-left">URL</th>
      <th class="p-3 text-center">Status</th>
      <th class="p-3 text-right">Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($links as $l): ?>
    <tr class="border-t border-border hover:bg-white/5">
      <td class="p-3"><?= $l->platform ?></td>
      <td class="p-3 truncate max-w-xs"><?= $l->url ?></td>
      <td class="p-3 text-center">
        <?= $l->is_active ? 'Active' : 'Hidden' ?>
      </td>
      <td class="p-3 text-right space-x-3">
        <button onclick="toggleLink(<?= $l->id ?>)" class="text-yellow-400">Toggle</button>
        <button  data-id="<?= $l->id ?>" class="text-red-400 delete-btn">Delete</button>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<!-- DELETE MODAL -->
<div id="deleteModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
  <div class="bg-[#0f0f0f] border border-border rounded-lg p-6 w-full max-w-sm">
    <h3 class="text-lg font-semibold mb-3">Delete Streaming Link</h3>
    <p class="text-muted mb-5">This will permanently remove this streaming link.</p>

    <div class="flex justify-end gap-3">
      <button id="cancelDelete" class="px-4 py-2 bg-gray-700 rounded">Cancel</button>
      <button id="confirmDelete" class="px-4 py-2 bg-red-600 rounded">Delete</button>
    </div>
  </div>
</div>

<script>
	/*
function deleteLink(id) {
  fetch("<?= site_url('admin/streaminglinks/delete/') ?>" + id)
    .then(() => location.reload());
} */
function toggleLink(id) {
  fetch("<?= site_url('admin/streaminglinks/toggle/') ?>" + id)
    .then(() => location.reload());
}
</script>

<script>
let deleteId = null;

document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    deleteId = btn.dataset.id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
  });
});

document.getElementById('cancelDelete').onclick = () => closeModal();
function closeModal() {
  document.getElementById('deleteModal').classList.add('hidden');
  document.getElementById('deleteModal').classList.remove('flex');
}

document.getElementById('confirmDelete').onclick = () => {
  fetch("<?= site_url('admin/streaminglinks/delete/') ?>" + deleteId)
    .then(r => r.json())
    .then(() => location.reload());
};
</script>
