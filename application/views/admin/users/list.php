<div class="flex justify-between items-center mb-6">
  <h2 class="text-xl font-semibold">Users</h2>
 
  <form method="get">
    <input type="text" name="q" placeholder="Search users..."
           value="<?= html_escape($this->input->get('q')) ?>"
           class="bg-black border border-border rounded px-3 py-2 text-sm">
  </form>
</div>

<?php if ($this->session->flashdata('success')): ?>
  <div class="mb-4 text-green-400 text-sm">
    <?= $this->session->flashdata('success') ?>
  </div>
<?php endif; ?>

<table class="w-full text-sm border border-border rounded-lg overflow-hidden">
  <thead class="bg-[#0f0f0f] text-muted">
    <tr>
      <th class="p-3 text-left">User</th>
      <th class="p-3 text-left">Email</th>
      <th class="p-3 text-center">Singles</th>
      <th class="p-3 text-center">Albums</th>
      <th class="p-3 text-right">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
    <tr class="border-t border-border hover:bg-white/5">
      <td class="p-3"><?= html_escape($u->name) ?></td>
      <td class="p-3"><?= html_escape($u->email) ?></td>
      <td class="p-3 text-center"><?= $u->singles_count ?></td>
      <td class="p-3 text-center"><?= $u->albums_count ?></td>
      <td class="p-3 text-right space-x-2">
        <a href="<?= site_url('admin/users/view/'.$u->id) ?>"
           class="text-primary hover:underline">View</a>
		   
		  <a href="<?= site_url('admin/users/invoices/' . $u->id) ?>"
   class="px-3 py-1 text-xs rounded bg-blue-500/10 text-blue-400 hover:bg-blue-500/20">
  Invoices
</a>
<!--
        <a href="<?= site_url('admin/users/delete/'.$u->id) ?>"
           onclick="return confirm('Delete this user and all content?')"
           class="text-red-400 hover:underline">Delete</a> -->
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
