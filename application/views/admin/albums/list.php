<meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
<meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">


<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

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




<div class="flex justify-between items-center mb-6">
  <h2 class="text-xl font-semibold">Albums</h2>

  <form method="get">
    <input type="text" name="q" placeholder="Search album or user…"
           value="<?= html_escape($this->input->get('q')) ?>"
           class="bg-black border border-border rounded px-3 py-2 text-sm">
  </form>
</div>

<table id="releasesTable" class="w-full text-sm border border-border rounded-lg overflow-hidden">
  <thead class="bg-[#0f0f0f] text-muted">
    <tr>
      <th class="p-3 text-left">Cover</th>
      <th class="p-3 text-left">Album</th>
	  <th class="p-3 text-left">Release Date</th>
      <th class="p-3 text-left">User</th>
      <th class="p-3 text-center">Tracks</th>
	  
	    <th class="px-4 py-3 text-right">Streams</th>
		<th class="px-4 py-3 text-right">Revenue</th>
		<th class="px-4 py-3 text-right">Downloads</th>
               
			   
      <th class="p-3 text-center">Status</th>
      <th class="p-3 text-right">Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($albums as $a): ?>
    <tr class="border-t border-border hover:bg-white/5">

      <td class="p-3">
        <?php if ($a->cover_art): ?>
          <img src="<?= base_url($a->cover_art) ?>" class="w-12 h-12 rounded object-cover">
        <?php else: ?>
          <div class="w-12 h-12 bg-gray-800 rounded"></div>
        <?php endif; ?>
      </td>

      <td class="p-3 font-semibold"><?= html_escape($a->album_title) ?></td>
	  
	   <td class="px-4 py-3 text-white">
		  <?= date('d M Y', strtotime($a->release_date)) ?>
        </td>
	  
      <td class="p-3"><?= html_escape($a->name) ?></td>
      <td class="p-3 text-center"><?= $a->tracks_count ?></td>
	  
	  
	   <!-- Streams -->               
		<td class="px-4 py-3 text-right font-semibold"
			data-order="<?= @$a->total_streams ?>">
			<?= number_format($a->total_streams) ?>
		</td>

		<!-- Revenue -->              
		<td class="px-4 py-3 text-right font-semibold text-green-400"
			data-order="<?= $a->total_revenue ?>">
				₹<?= number_format($a->total_revenue, 2) ?>
		</td>

		
		
		<!-- downloads -->
	   <td class="px-4 py-3 text-right font-semibold"
			data-order="<?= $a->total_downloads ?>">
			<?= number_format($a->total_downloads) ?>
		</td>

	  
  
		<td class="px-4 py-3 text-gray-400">
		   <?= $a->is_active ? 'Yes' : 'No' ?> 
		</td>
			
			


     <td class="p-3 text-right space-x-3">
	 <button onclick="toggleLink(<?= $a->id ?>)" class="text-yellow-400 hover:underline">Toggle</button>
	 <a href="<?= site_url('admin/albums/tracks/'.$a->id) ?>" class=" text-primary hover:underline"> Add Streams </a>
	 
	 
	 <!-- <a href="<?= site_url('admin/streaming-links/album/'.$a->id) ?>"
		 class="text-primary hover:underline">
		 Links
		 </a>

	  <button class="delete-btn text-red-400" data-id="<?= $a->id ?>">
		 Delete
	  </button> -->
	</td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- DELETE MODAL -->
<div id="deleteModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
  <div class="bg-[#0f0f0f] border border-border rounded-lg p-6 w-full max-w-sm">
    <h3 class="text-lg font-semibold mb-3">Delete Album</h3>
    <p class="text-muted mb-5">
      This will permanently delete the album and all tracks.
    </p>

    <div class="flex justify-end gap-3">
      <button id="cancelDelete" class="px-4 py-2 bg-gray-700 rounded">Cancel</button>
      <button id="confirmDelete" class="px-4 py-2 bg-red-600 rounded">Delete</button>
    </div>
  </div>
</div>

<script>
let deleteId = null;

document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.onclick = () => {
    deleteId = btn.dataset.id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
  };
});

document.getElementById('cancelDelete').onclick = closeModal;
function closeModal() {
  document.getElementById('deleteModal').classList.add('hidden');
  document.getElementById('deleteModal').classList.remove('flex');
}

document.getElementById('confirmDelete').onclick = () => {
  fetch("<?= site_url('admin/albums/delete/') ?>" + deleteId)
    .then(r => r.json())
    .then(() => location.reload());
};
</script>
<script>

function toggleLink(id) {
  fetch("<?= site_url('admin/albums/toggle/') ?>" + id)
    .then(() => location.reload());
}
</script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script>
$(document).ready(function () {
    $('#releasesTable').DataTable({
        pageLength: 25,
        order: [[2, 'desc']], // Release Date
        columnDefs: [
            { orderable: false, targets: [9] } //  Actions
        ],
        dom: '<"flex justify-between items-center mb-3"lf>rt<"flex justify-between items-center mt-3"ip>'
    });
});
</script>
