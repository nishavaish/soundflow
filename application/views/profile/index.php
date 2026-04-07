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

  <h1 class="text-3xl font-bold mb-6">Profile & Payouts</h1>

  <div id="alertBox" class="hidden mb-4 text-sm"></div>

  <div class="grid md:grid-cols-2 gap-6">

    <!-- Bank Details -->
    <div class="bg-card border-b border-zinc-400/30 rounded-lg p-6">
      <h3 class="text-lg font-semibold mb-4">Bank Details</h3>

      <form id="bankForm" class="space-y-4">
        <input name="account_name" value="<?= $bank->account_name ?? '' ?>" placeholder="Account Holder Name" class="w-full bg-white border-b border-zinc-400/30 px-4 py-2 rounded" required>
        <input name="account_number" value="<?= $bank->account_number ?? '' ?>" placeholder="Account Number" class="w-full bg-white border-b border-zinc-400/30 px-4 py-2 rounded" required>
        <input name="ifsc" value="<?= $bank->ifsc ?? '' ?>" placeholder="IFSC Code" class="w-full bg-white border-b border-zinc-400/30 px-4 py-2 rounded uppercase" required>
        <input name="bank_name" value="<?= $bank->bank_name ?? '' ?>" placeholder="Bank Name" class="w-full bg-white border-b border-zinc-400/30 px-4 py-2 rounded" required>

        <button class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
          Save Bank Details
        </button>
      </form>
    </div>

    <!-- Invoices -->
    <div class="bg-card border-b border-zinc-400/30 rounded-lg p-6">
      <h3 class="text-lg font-semibold mb-4">Invoices</h3>

      <form id="invoiceForm" enctype="multipart/form-data" class="space-y-4">
        <input name="title" placeholder="Invoice Title" class="w-full bg-white border-b border-zinc-400/30 px-4 py-2 rounded" required>
       <select name="invoice_month"
        class="w-full bg-white border-b border-zinc-400/30 px-4 py-2 rounded text-black"
        required>
  <option value="">Select Invoice Month</option>
  <?php for ($i = 0; $i < 12; $i++):
      $m = date('Y-m', strtotime("-$i months")); ?>
    <option value="<?= $m ?>"><?= date('F Y', strtotime($m . '-01')) ?></option>
  <?php endfor; ?>
</select>

	   
	   <input type="file" name="invoice_file" accept=".pdf,.jpg,.png" class="w-full text-muted" required>

        <button class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
          Upload Invoice
        </button>
      </form>

      <?php if (!empty($invoices)): ?>
        <div class="mt-6 space-y-2">
  <?php foreach ($invoices as $inv): ?>
    <div class="flex justify-between text-sm border-b border-border pb-2">
      <div>
        <div class="font-medium"><?= $inv->title ?></div>
        <div class="text-xs text-muted">
          <?= date('d M Y', strtotime($inv->created_at)) ?>
          · <?= date('F Y', strtotime($inv->invoice_month . '-01')) ?>
        </div>
      </div>
      <div class="flex gap-4">
       
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
    </div>
  <?php endforeach; ?>
</div>

<!-- View All -->
<div class="mt-4 text-right">
  <a href="<?= site_url('invoices') ?>"
     class="text-primary text-sm hover:underline">
    View All Invoices →
  </a>
</div>

      <?php endif; ?>
    </div>

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
      Are you sure you want to permanently delete this invoice?
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
document.getElementById('bankForm').addEventListener('submit', e => {
  e.preventDefault();

  fetch('<?= site_url("profile/update_bank_ajax") ?>', {
    method: 'POST',
    body: new FormData(e.target)
  })
  .then(r => r.json())
  .then(res => showAlert(res.message, res.status))
  .catch(() => showAlert('Request failed', 'error'));
});
</script>

<script>
document.getElementById('invoiceForm').addEventListener('submit', e => {
  e.preventDefault();

  fetch('<?= site_url("profile/upload_invoice_ajax") ?>', {
    method: 'POST',
    body: new FormData(e.target)
  })
  .then(r => r.json())
  .then(res => {
    showAlert(res.message, res.status);
    if (res.status === 'success') {
      setTimeout(() => location.reload(), 800);
    }
  })
  .catch(() => showAlert('Request failed', 'error'));
});
</script>
<script>
	/*
function deleteInvoice(id) {
  if (!confirm('Delete this invoice?')) return;

  const fd = new FormData();
  fd.append('id', id);

  fetch('<?= site_url("profile/delete_invoice") ?>', {
    method: 'POST',
    body: fd
  })
  .then(r => r.json())
  .then(res => {
    showAlert(res.message, res.status);
    if (res.status === 'success') {
      setTimeout(() => location.reload(), 600);
    }
  })
  .catch(() => showAlert('Delete failed', 'error'));
}  */
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



<script>lucide.createIcons();</script>

</body>
</html>
