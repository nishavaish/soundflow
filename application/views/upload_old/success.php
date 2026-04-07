<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Success – Upload Complete | SoundFlow</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            background: "#000000",
            border: "#27272a",
            card: "#0f0f0f",
            muted: "#9ca3af"
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-black to-[#1b0e26] text-white flex items-center justify-center px-4">

  <div class="w-full max-w-2xl bg-card border border-border rounded-2xl p-12 text-center shadow-xl">

    <div class="flex justify-center mb-6">
      <div class="w-28 h-28 rounded-full bg-gradient-to-br from-primary to-[#4e6bff] flex items-center justify-center shadow-lg">
        <i data-lucide="check" class="w-14 h-14 text-white"></i>
      </div>
    </div>

    <h1 class="text-4xl font-bold mb-4">🎉 Release Created Successfully!</h1>

    <p class="text-muted text-lg mb-8">
      Your single has been saved and is now ready for review.  
      You can return to your dashboard or upload another release.
    </p>

    <div class="flex flex-col md:flex-row gap-4 justify-center">

      <a href="<?= base_url('dashboard') ?>"
         class="px-8 py-3 rounded-lg border border-border hover:bg-white/10 transition font-semibold text-center">
        Go to Dashboard
      </a>

      <a href="<?= base_url('UploadSingle/step1') ?>"
         class="px-8 py-3 rounded-lg bg-gradient-to-r from-primary to-[#4e6bff] hover:opacity-90 font-semibold text-center">
        Create Another Release
      </a>

    </div>

  </div>

  <script> lucide.createIcons(); </script>

</body>
</html>
