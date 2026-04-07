
<script>
window.CSRF = {
  name: '<?= $this->security->get_csrf_token_name(); ?>',
  hash: '<?= $this->security->get_csrf_hash(); ?>'
};
</script>


<script>
const _fetch = window.fetch;

window.fetch = function (url, options = {}) {
  options.method = options.method || 'GET';

  if (options.body instanceof FormData) {
    options.body.append(CSRF.name, CSRF.hash);
  }

  return _fetch(url, options).then(async response => {
    try {
      const clone = response.clone();
      const data = await clone.json();
      if (data.csrf_hash) CSRF.hash = data.csrf_hash;
    } catch (e) {}
    return response;
  });
};
</script>

<div class="container mx-auto px-6 py-8">

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">
      Invoices – <?= $user->name ?>
    </h1>

    <a href="<?= site_url('admin/users') ?>"
       class="text-sm text-muted hover:text-white">
      ← Back to Users
    </a>
  </div>

  <div id="alertBox" class="hidden mb-4 text-sm"></div>

  <div class="bg-card border border-border rounded-lg">
    <?php foreach ($invoices as $inv): ?>
      <div class="flex justify-between items-center p-4 border-b border-border">

        <div>
          <div class="font-semibold"><?= $inv->title ?></div>
          <div class="text-xs text-muted">
            <?= date('d M Y', strtotime($inv->created_at)) ?> ·
            <?= date('F Y', strtotime($inv->invoice_month . '-01')) ?>
          </div>
        </div>

        <div class="flex items-center gap-4">
		
		


<?php
$statusMap = [
  'pending'  => ['Pending',  'bg-yellow-500/10 text-yellow-400 border-yellow-500/30'],
  'approved' => ['Approved', 'bg-blue-500/10 text-blue-400 border-blue-500/30'],
  'paid'     => ['Paid',     'bg-green-500/10 text-green-400 border-green-500/30'],
];
[$label, $cls] = $statusMap[$inv->status];
?>

<div class="relative inline-flex items-center gap-2">

  <!-- Badge -->
  <span id="statusBadge<?= $inv->id ?>"
        class="px-2 py-1 text-xs rounded border <?= $cls ?>">
    <?= $label ?>
  </span>

  <!-- Edit -->
  <?php if ($inv->status !== 'paid'): ?>
    <button onclick="toggleStatusMenu(<?= $inv->id ?>)"
            class="text-muted hover:text-white">
      <i data-lucide="edit-3" class="w-4 h-4"></i>
    </button>
  <?php endif; ?>

  <!-- Dropdown -->
  <div id="statusMenu<?= $inv->id ?>"
       class="hidden absolute right-0 top-7 w-32 bg-card border border-border rounded-lg shadow-lg z-50">

    <?php foreach ($statusMap as $key => [$text, $style]): ?>
      <button
        onclick="setStatus(<?= $inv->id ?>, '<?= $key ?>')"
        class="w-full text-left px-3 py-2 text-sm hover:bg-white/5 <?= $style ?>">
        <?= $text ?>
      </button>
    <?php endforeach; ?>

  </div>

</div>

<select id="status-select-<?= $inv->id ?>"
        onchange="saveStatus(<?= $inv->id ?>, this.value)"
        class="hidden mt-1 px-3 py-1.5 rounded-md text-sm border
               bg-background border-border text-white">

  <option value="pending"  <?= $inv->status === 'pending' ? 'selected' : '' ?>>
    Pending
  </option>
  <option value="approved" <?= $inv->status === 'approved' ? 'selected' : '' ?>>
    Approved
  </option>
  <option value="paid"     <?= $inv->status === 'paid' ? 'selected' : '' ?>>
    Paid
  </option>
</select>


          <!-- View -->
          <a href="<?= base_url($inv->file_path) ?>"
             target="_blank"
             class="text-primary hover:underline text-sm">
            View
          </a>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

</div>

<script>
function showAlert(msg, type='success') {
  const box = document.getElementById('alertBox');
  if (!box) return;

  box.className = `mb-4 px-4 py-2 rounded ${
    type === 'success'
      ? 'bg-green-500/10 text-green-400'
      : 'bg-red-500/10 text-red-400'
  }`;

  box.innerText = msg;
  box.classList.remove('hidden');
  setTimeout(() => box.classList.add('hidden'), 3000);
}
</script>

<script>
function updateStatus(invoiceId, status) {
  const fd = new FormData();
  fd.append('invoice_id', invoiceId);
  fd.append('status', status);

  fetch('<?= site_url("admin/users/update_invoice_status") ?>', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(res => showAlert(res.message, res.status))
  .catch(() => showAlert('Update failed', 'error'));
}
</script>
<script>
function toggleStatusMenu(id) {
  document.querySelectorAll('[id^="statusMenu"]').forEach(el => el.classList.add('hidden'));
  document.getElementById('statusMenu' + id).classList.toggle('hidden');
}

function setStatus(id, status) {
  const fd = new FormData();
  fd.append('invoice_id', id);
  fd.append('status', status);

  fetch('<?= site_url("admin/users/update_invoice_status") ?>', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(res => {
    showAlert(res.message, res.status);
    if (res.status === 'success') location.reload();
  });
}

// Close on outside click
document.addEventListener('click', e => {
  if (!e.target.closest('[id^="statusMenu"]') && !e.target.closest('button')) {
    document.querySelectorAll('[id^="statusMenu"]').forEach(el => el.classList.add('hidden'));
  }
});
</script>
