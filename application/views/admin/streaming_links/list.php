<?php foreach ($links as $l): ?>
<div class="flex items-center justify-between border border-border p-3 rounded">
  <div class="flex gap-3 items-center">
    <i data-lucide="<?= $platforms[$l->platform]['icon'] ?>"></i>
    <span><?= $platforms[$l->platform]['label'] ?></span>
  </div>

  <div class="flex gap-2">
    <a href="<?= $l->url ?>" target="_blank">Open</a>
    <a href="<?= base_url('admin/streaming-links/toggle/'.$l->id) ?>">
      <?= $l->is_active ? 'Disable' : 'Enable' ?>
    </a>
    <a href="<?= base_url('admin/streaming-links/delete/'.$l->id) ?>" class="text-red-400">
      Delete
    </a>
  </div>
</div>
<?php endforeach; ?>
