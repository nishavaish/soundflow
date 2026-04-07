<!DOCTYPE html>
<html>
<head>
  <title>Admin Login | SoundFlow</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-black flex items-center justify-center text-white">

  <form method="post" class="bg-[#0f0f0f] p-8 rounded-xl w-full max-w-sm border border-border">
   <!-- CSRF -->
        <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

    <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

    <?php if (!empty($error)): ?>
      <div class="text-red-400 text-sm mb-4"><?= $error ?></div>
    <?php endif; ?>

    <input type="email" name="email" placeholder="Email"
           class="w-full mb-4 p-3 bg-black border border-border rounded" required>

    <input type="password" name="password" placeholder="Password"
           class="w-full mb-6 p-3 bg-black border border-border rounded" required>

    <button class="w-full bg-gradient-to-r from-primary to-pink-500 py-3 rounded font-semibold">
      LOGIN
    </button>
  </form>

</body>
</html>
