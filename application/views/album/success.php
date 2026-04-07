<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> Album Submitted</title>

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
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-background to-[hsl(263,40%,10%)] text-white">

    <div class="max-w-xl w-full">
        <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-10 text-center shadow-2xl">

            <!-- Glowing check icon -->
            <div class="relative inline-flex items-center justify-center mb-6">
                <div class="w-24 h-24 rounded-full bg-green-500/20 blur-xl absolute"></div>
                <div class="w-20 h-20 rounded-full bg-green-500/20 border border-green-400 flex items-center justify-center relative">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5"
                         viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold mb-3">Album Submitted Successfully</h1>

            <p class="text-gray-300 mb-4">
                Your album has been saved and queued for distribution.  
                Our system will now process your release and deliver it to the selected stores.
            </p>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gray-800/80 border border-gray-700 mb-6 text-sm">
                <span class="text-gray-400">Album ID:</span>
                <span class="font-semibold text-white">
                    <?= htmlspecialchars($album_id) ?>
                </span>
            </div>

            <p class="text-xs text-gray-500 mb-8">
                You can track the status of this album and view analytics from your dashboard at any time.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="<?= base_url('dashboard') ?>"
                   class="px-6 py-2.5 rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 font-semibold text-sm shadow-lg hover:opacity-90 transition">
                    Go to Dashboard
                </a>
                <a href="<?= base_url('upload') ?>"
                   class="px-6 py-2.5 rounded-full border border-gray-700 bg-gray-900/80 text-sm font-semibold hover:border-indigo-400 hover:text-indigo-300 transition">
                    Upload Another Release
                </a>
            </div>

        </div>
    </div>

</body>
</html>
