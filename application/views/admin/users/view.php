<h2 class="text-xl font-semibold mb-4"><?= html_escape($user->name) ?></h2>
<p class="text-muted mb-6"><?= html_escape($user->email) ?></p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

  <div class="bg-[#0f0f0f] border border-border rounded-lg p-4">
    <h3 class="font-semibold mb-3">Singles</h3>
    <?php foreach ($singles as $r): ?>
      <div class="border-b border-border py-2">
        <?= html_escape($r->title) ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="bg-[#0f0f0f] border border-border rounded-lg p-4">
    <h3 class="font-semibold mb-3">Albums</h3>
    <?php foreach ($albums as $a): ?>
      <div class="border-b border-border py-2">
        <?= html_escape($a->album_title) ?>
      </div>
    <?php endforeach; ?>
  </div>

</div>
