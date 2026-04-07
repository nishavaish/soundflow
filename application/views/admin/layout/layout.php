<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $title ?? 'Admin' ?> | SoundFlow</title>

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: "#ff531a",
        border: "#27272a",
        muted: "#9ca3af"
      }
    }
  }
};
</script>
</head>

<body class="bg-[#0a0a0a] text-white">

<div class="flex min-h-screen">

  <?php $this->load->view('admin/layout/sidebar'); ?>

  <div class="flex-1 flex flex-col">
    <?php $this->load->view('admin/layout/header'); ?>

    <main class="flex-1 p-6">
      <?php $this->load->view($view, $data ?? []); ?>
    </main>
  </div>

</div>

<?php $this->load->view('admin/layout/footer'); ?>
</body>
</html>
