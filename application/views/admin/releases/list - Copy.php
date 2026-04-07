<div class="flex justify-between items-center mb-6">
  <h2 class="text-xl font-semibold">Singles</h2>

  <form method="get">
    <input type="text" name="q" placeholder="Search singles or user…"
           value="<?= html_escape($this->input->get('q')) ?>"
           class="bg-black border border-border rounded px-3 py-2 text-sm">
  </form>
</div>

<table class="w-full text-sm border border-border rounded-lg overflow-hidden">
  <thead class="bg-[#0f0f0f] text-muted">
    <tr>
      <th class="p-3 text-left">Cover</th>
      <th class="p-3 text-left">Title</th>
      <th class="p-3 text-left">Artist</th>
      <th class="p-3 text-left">User</th>
      <th class="p-3 text-left">Approved?</th>
      <th class="p-3 text-right">Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($releases as $r): ?>
    <tr class="border-t border-border hover:bg-white/5">

      <td class="p-3">
        <?php if ($r->file_path): ?>
          <img src="<?= base_url($r->file_path) ?>" class="w-12 h-12 rounded object-cover">
        <?php else: ?>
          <div class="w-12 h-12 bg-gray-800 rounded"></div>
        <?php endif; ?>
      </td>

      <td class="p-3 font-semibold"><?= html_escape($r->title) ?></td>
      <td class="p-3"><?= html_escape($r->primary_artist) ?></td>
      <td class="p-3"><?= html_escape($r->name) ?></td>
	   <td class="p-3"> <?= $r->is_active ? 'Yes' : 'No' ?>  </td>

      <td class="p-3 text-right space-x-3">
		  <button onclick="toggleLink(<?= $r->id ?>)" class="text-yellow-400">Toggle</button>
		  
			<a href="<?= site_url('admin/streaming-links/single/'.$r->id) ?>"
			 class="text-primary hover:underline">
			 Links
		  </a>

		  <button class="delete-btn text-red-400" data-id="<?= $r->id ?>">
			 Delete
		  </button>
		</td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- DELETE MODAL -->
<div id="deleteModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
  <div class="bg-[#0f0f0f] border border-border rounded-lg p-6 w-full max-w-sm">
    <h3 class="text-lg font-semibold mb-3">Delete Single</h3>
    <p class="text-muted mb-5">This will permanently remove the single.</p>

    <div class="flex justify-end gap-3">
      <button id="cancelDelete" class="px-4 py-2 bg-gray-700 rounded">Cancel</button>
      <button id="confirmDelete" class="px-4 py-2 bg-red-600 rounded">Delete</button>
    </div>
  </div>
</div>

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
  fetch("<?= site_url('admin/releases/delete/') ?>" + deleteId)
    .then(r => r.json())
    .then(() => location.reload());
};
</script>
<script>

function toggleLink(id) {
  fetch("<?= site_url('admin/releases/toggle/') ?>" + id)
    .then(() => location.reload());
}
</script>