<div class="flex justify-between items-center mb-6">
  <h2 class="text-xl font-semibold">Plans</h2>

  <div class="flex gap-2">
    <!-- Search -->
    <form method="get">
      <input type="text" name="q" placeholder="Search plans..."
	 value="<?= html_escape($this->input->get('q')) ?>"
             class="bg-black border border-border rounded px-3 py-2 text-sm">
    </form>

    <!-- Add Plan -->
    <a href="<?= site_url('admin/plans/create') ?>"
       class="bg-primary text-white px-4 py-2 rounded text-sm hover:opacity-90">
       + Add Plan
    </a>
  </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
  <div class="mb-4 text-green-400 text-sm">
    <?= $this->session->flashdata('success') ?>
  </div>
<?php endif; ?>

<table class="w-full text-sm border border-border rounded-lg overflow-hidden">
  <thead class="bg-[#0f0f0f] text-muted">
    <tr>
      <th class="p-3 text-left">Plan Name</th>
      <th class="p-3 text-center">Price</th>
      <th class="p-3 text-center">Duration</th>
    <!--  <th class="p-3 text-left">Features</th> -->
      <th class="p-3 text-left">Status</th>
      <th class="p-3 text-right">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($plans)): ?>
      <?php foreach ($plans as $p): ?>
      <tr class="border-t border-border hover:bg-white/5">
        
        <!-- Plan Name -->
        <td class="p-3 font-medium">
          <?= html_escape($p->name) ?>
        </td>

        <!-- Price -->
        <td class="p-3 text-center">
          ₹<?= number_format($p->price, 2) ?>
        </td>

        <!-- Duration -->
        <td class="p-3 text-center capitalize">
          <?= $p->duration ?>
        </td>

        <!-- Features -->
      <!--  <td class="p-3">
          <?php if (!empty($p->features)): ?>
            <ul class="list-disc ml-4 space-y-1">
              <?php foreach ($p->features as $f): ?>
                <li><?= html_escape($f->feature) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <span class="text-muted">No features</span>
          <?php endif; ?>
        </td> -->
		
		<td class="p-3 text-center">
		  <button onclick="toggleStatus(<?= $p->id ?>)"
				  class="px-2 py-1 text-xs rounded 
				  <?= $p->status == 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' ?>">
			<?= ucfirst($p->status) ?>
		  </button>
		</td>
        <!-- Actions -->
        <td class="p-3 text-right space-x-2">
          
          <a href="<?= site_url('admin/plans/edit/'.$p->id) ?>"
             class="text-primary hover:underline">Edit</a>

         <button onclick="deletePlan(<?= $p->id ?>)"
					class="text-red-400 hover:underline">
			  Delete
			</button>

        </td>
		
		
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="5" class="p-4 text-center text-muted">
          No plans found
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="mt-4">
  <?= $pagination ?>
</div>


<script>
const csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
const csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

function deletePlan(id){
  if(!confirm('Delete this plan?')) return;

  fetch("<?= site_url('admin/plans/delete/') ?>" + id, {
    method: "POST",
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: csrfName + "=" + csrfHash
  })
  .then(res => res.json())
  .then(data => {
    if(data.status === 'success'){
      location.reload();
    }
  });
}

function toggleStatus(id){
  fetch("<?= site_url('admin/plans/toggle_status') ?>", {
    method: "POST",
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: "id=" + id + "&" + csrfName + "=" + csrfHash
  })
  .then(res => res.json())
  .then(data => {
    if(data.status === 'success'){
      location.reload();
    }
  });
}
</script>