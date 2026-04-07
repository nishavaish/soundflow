<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

  <div class="bg-[#0f0f0f] border border-border rounded-lg p-5">
    <p class="text-muted text-sm">Users</p>
    <h3 class="text-3xl font-bold"><?= $stats['users'] ?></h3>
  </div>

  <div class="bg-[#0f0f0f] border border-border rounded-lg p-5">
    <p class="text-muted text-sm">Singles</p>
    <h3 class="text-3xl font-bold"><?= $stats['singles'] ?></h3>
  </div>

  <div class="bg-[#0f0f0f] border border-border rounded-lg p-5">
	  <p class="text-muted text-sm">Albums</p>
    <h3 class="text-3xl font-bold"><?= $stats['albums'] ?></h3>
  </div>

  <div class="bg-[#0f0f0f] border border-border rounded-lg p-5">
    <p class="text-muted text-sm">Streaming Links</p>
    <h3 class="text-3xl font-bold"><?= $stats['links'] ?></h3>
  </div>

</div>

<!-- LATEST CONTENT -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

  <!-- Latest Singles -->
  <div class="bg-[#0f0f0f] border border-border rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold">Latest Singles</h3>
      <a href="<?= site_url('admin/releases') ?>" class="text-primary text-sm">View All</a>
    </div>

    <table class="w-full text-sm">
      <thead class="text-muted">
        <tr>
          <th class="text-left py-2">Title</th>
          <th class="text-left py-2">User</th>
          <th class="text-right py-2">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($latest_singles as $r): ?>
        <tr class="border-t border-border hover:bg-white/5">
          <td class="py-2"><?= html_escape($r->title) ?></td>
          <td class="py-2"><?= html_escape($r->name) ?></td>
          <td class="py-2 text-right text-muted"><?= date('d M Y', strtotime($r->created_at)) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Latest Albums -->
  <div class="bg-[#0f0f0f] border border-border rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold">Latest Albums</h3>
      <a href="<?= site_url('admin/albums') ?>" class="text-primary text-sm">View All</a>
    </div>

    <table class="w-full text-sm">
      <thead class="text-muted">
        <tr>
          <th class="text-left py-2">Album</th>
          <th class="text-left py-2">User</th>
          <th class="text-right py-2">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($latest_albums as $a): ?>
        <tr class="border-t border-border hover:bg-white/5">
          <td class="py-2"><?= html_escape($a->album_title) ?></td>
          <td class="py-2"><?= html_escape($a->name) ?></td>
          <td class="py-2 text-right text-muted"><?= date('d M Y', strtotime($a->created_at)) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>
