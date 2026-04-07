<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile & Payouts</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            background: "#000000",
            border: "#27272a",
            muted: "#9ca3af",
            card: "#111111"
          }
        }
      }
    }
  </script>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body class="bg-white min-h-screen text-black">

<?php $this->view('page_header'); ?>


<!-- 🔐 GLOBAL CSRF (ONE TIME) -->
<script>
window.CSRF = {
  name: '<?= $this->security->get_csrf_token_name(); ?>',
  hash: '<?= $this->security->get_csrf_hash(); ?>'
};
</script>


<!-- 🔥 GLOBAL FETCH OVERRIDE -->
<script>
const _fetch = window.fetch;

window.fetch = function (url, options = {}) {
  options.method = options.method || 'GET';

  if (options.body instanceof FormData) {
    options.body.append(CSRF.name, CSRF.hash);
  }

  if (options.body && !(options.body instanceof FormData)) {
    options.headers = options.headers || {};
    options.headers['Content-Type'] = 'application/json';

    try {
      const data = JSON.parse(options.body);
      data[CSRF.name] = CSRF.hash;
      options.body = JSON.stringify(data);
    } catch (e) {}
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
  
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
	<h1 class="text-3xl font-bold mb-6">All Invoices</h1>
  
	  <!-- Back to Profile -->
	  <a href="<?= site_url('profile') ?>"
		 class="inline-flex items-center gap-2 text-sm text-muted hover:text-white">
		← Back to Profile
	  </a>

	</div>

   <div id="alertBox" class="hidden mb-4 text-sm"></div>

  

  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
	<h1 class="text-3xl font-bold mb-6"> &nbsp;</h1>
  
  <!-- Upload Invoice Toggle -->
  <button id="toggleUpload"
          class="bg-primary px-4 py-2 rounded font-semibold text-sm">
    + Upload Invoice
  </button>

</div>

<div id="uploadBox"
     class="hidden bg-card border border-border rounded-lg p-6 mb-6">

  <h3 class="text-lg font-semibold mb-4">Upload Invoice</h3>

  <form id="invoiceForm" enctype="multipart/form-data" class="space-y-4">

    <input
      name="title"
      placeholder="Invoice Title"
      class="w-full bg-white border border-border rounded-lg px-3 py-2 text-sm"
      required>

    <select name="invoice_month"
            class="w-full bg-white border border-border rounded-lg px-3 py-2 text-sm"
            required>
      <option value="">Select Invoice Month</option>
      <?php for ($i = 0; $i < 12; $i++):
        $m = date('Y-m', strtotime("-$i months")); ?>
        <option value="<?= $m ?>">
          <?= date('F Y', strtotime($m . '-01')) ?>
        </option>
      <?php endfor; ?>
    </select>

    <input
      type="file"
      name="invoice_file"
      accept=".pdf,.jpg,.jpeg,.png"
      class="w-full text-muted"
      required>

    <div class="flex gap-3">
      <button class="bg-primary px-6 py-2 rounded font-semibold">
        Upload
      </button>
      <button type="button"
              id="cancelUpload"
              class="px-6 py-2 border border-border rounded">
        Cancel
      </button>
    </div>

  </form>
</div>


  <form method="get" class="mb-6 flex gap-4">
    <input type="month"
           name="month"
           value="<?= $selected_month ?>"
           class="bg-background border border-border px-4 py-2 rounded text-white">

    <button class="bg-primary px-6 py-2 rounded font-semibold">
      Filter
    </button>

    <a href="<?= site_url('invoices') ?>"
       class="px-4 py-2 border border-border rounded">
      Reset
    </a>
  </form>

  <div class="bg-card border border-border rounded-lg">
    <?php if (empty($invoices)): ?>
      <p class="p-6 text-muted">No invoices found</p>
    <?php endif; ?>

    <?php foreach ($invoices as $inv): ?>
      <div class="flex justify-between p-4 border-b border-border">
        <div>
          <div class="font-semibold"><?= $inv->title ?></div>
          <div class="text-xs text-muted">
            <?= date('d M Y', strtotime($inv->created_at)) ?>
            · <?= date('F Y', strtotime($inv->invoice_month . '-01')) ?>
          </div>
        </div>
        <div class="flex items-center gap-6">

			<?php
			$statusClasses = [
		  'pending'  => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/30',
		  'approved' => 'bg-blue-500/10 text-blue-400 border-blue-500/30',
		  'paid'     => 'bg-green-500/10 text-green-400 border-green-500/30',
		];
		?>

		<span class="px-2 py-1 text-xs rounded border <?= $statusClasses[$inv->status] ?>">
		  <?= ucfirst($inv->status) ?>
		</span>

		  <!-- View -->
		  <a href="<?= base_url($inv->file_path) ?>"
			 target="_blank"
			 title="View Invoice"
			 class="text-primary hover:text-orange-400 transition">
			<i data-lucide="eye" class="w-5 h-5"></i>
		  </a>

		  <!-- Delete -->
		  <?php if ($inv->status !== 'paid'): ?>
		  <button
			onclick="openDeleteConfirm(<?= $inv->id ?>)"
			title="Delete Invoice"
			class="text-red-400 hover:text-red-500 transition">
			<i data-lucide="trash-2" class="w-5 h-5"></i>
		  </button>
		<?php endif; ?>
		</div>

      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Delete Confirm Modal -->
<div id="deleteConfirmModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

  <div class="bg-card border border-border rounded-lg w-full max-w-sm p-6">
    <h3 class="text-lg font-semibold text-white mb-2">
      Delete Invoice
    </h3>
    <p class="text-sm text-muted mb-6">
      This action cannot be undone.
    </p>

    <div class="flex justify-end gap-3">
      <button id="cancelDelete"
              class="px-4 py-2 rounded bg-border text-white">
        Cancel
      </button>
      <button id="confirmDelete"
              class="px-4 py-2 rounded bg-red-500 text-white font-semibold">
        Delete
      </button>
    </div>
  </div>
</div>


<script>lucide.createIcons();</script>
<script>
function showAlert(msg, type = 'success') {
  const box = document.getElementById('alertBox');
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
let deleteInvoiceId = null;

function openDeleteConfirm(id) {
  deleteInvoiceId = id;
  $('#deleteConfirmModal').removeClass('hidden').addClass('flex');
}

$('#cancelDelete').on('click', function () {
  deleteInvoiceId = null;
  $('#deleteConfirmModal').addClass('hidden').removeClass('flex');
});

$('#confirmDelete').on('click', function () {
  if (!deleteInvoiceId) return;

  const fd = new FormData();
  fd.append('id', deleteInvoiceId);

  fetch('<?= site_url("profile/delete_invoice") ?>', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(res => {
    showAlert(res.message, res.status);
    $('#deleteConfirmModal').addClass('hidden').removeClass('flex');

    if (res.status === 'success') {
      setTimeout(() => location.reload(), 600);
    }
  })
  .catch(() => showAlert('Delete failed', 'error'));
});
</script>

<script>
$('#toggleUpload').on('click', function () {
  $('#uploadBox').slideDown();
});

$('#cancelUpload').on('click', function () {
  $('#uploadBox').slideUp();
});
</script>


<script>
$('#invoiceForm').on('submit', function (e) {
  e.preventDefault();

  fetch('<?= site_url("profile/upload_invoice_ajax") ?>', {
    method: 'POST',
    body: new FormData(this)
  })
  .then(r => r.json())
  .then(res => {
    showAlert(res.message, res.status);
    if (res.status === 'success') {
      setTimeout(() => location.reload(), 800);
    }
  })
  .catch(() => showAlert('Upload failed', 'error'));
});
</script>


</body>
</html>
