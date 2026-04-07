<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> Album Review </title>

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

    <!-- Header -->
    <header class="border-b border-gray-800 bg-black/90 backdrop-blur">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2">
                <!-- Simple music icon -->
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path d="M9 18V5l12-2v13"></path>
                    <circle cx="6" cy="18" r="3"></circle>
                    <circle cx="18" cy="16" r="3"></circle>
                </svg>
                <span class="text-2xl font-bold">SoundFlow</span>
            </a>

            <span class="text-sm text-gray-400 hidden sm:inline">
                Album Upload &raquo; <span class="text-white">Review</span>
            </span>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-6xl mx-auto px-6 py-10">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Review Your Album</h1>
            <p class="text-gray-400">
                Please confirm your album details before submitting it for distribution.
            </p>
        </div>

        <!-- Grid: left details / right artwork -->
        <div class="grid lg:grid-cols-3 gap-8 mb-10">
            <!-- Left: Release, Stores, Tracks -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Release Details -->
                <section class="bg-gray-900/80 border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Release Details</h2>
                        <a href="<?= base_url('UploadAlbum/step1') ?>"
                           class="text-xs px-3 py-1 rounded-full border border-gray-600 hover:border-indigo-400 hover:text-indigo-300 transition">
                            Edit Step 1
                        </a>
                    </div>

                    <?php if (!empty($step1)): ?>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-400">Album Title</div>
                                <div class="font-medium"><?= htmlspecialchars($step1['album_title']) ?></div>
                            </div>
                            <div>
                                <div class="text-gray-400">Primary Artist</div>
                                <div class="font-medium"><?= htmlspecialchars($step1['artist']) ?></div>
                            </div>
                            <div>
                                <div class="text-gray-400">Featuring</div>
                                <div class="font-medium">
                                    <?= $step1['featuring'] ? htmlspecialchars($step1['featuring']) : '<span class="text-gray-500">None</span>' ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-400">Album Type</div>
                                <div class="font-medium"><?= htmlspecialchars($step1['album_type']) ?></div>
                            </div>
                            <div>
                                <div class="text-gray-400">Number of Tracks</div>
                                <div class="font-medium"><?= (int) $step1['num_tracks'] ?></div>
                            </div>
                            <div>
                                <div class="text-gray-400">Genre / Subgenre</div>
                                <div class="font-medium">
                                    <?= htmlspecialchars($step1['genre']) ?>
                                    <?php if (!empty($step1['subgenre'])): ?>
                                        <span class="text-gray-500"> / <?= htmlspecialchars($step1['subgenre']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-400">Release Date</div>
                                <div class="font-medium"><?= htmlspecialchars($step1['release_date']) ?></div>
                            </div>
                            <div>
                                <div class="text-gray-400">Language</div>
                                <div class="font-medium"><?= htmlspecialchars($step1['language']) ?></div>
                            </div>
                            <div>
                                <div class="text-gray-400">UPC Code</div>
                                <div class="font-medium">
                                    <?= $step1['upc_code'] ? htmlspecialchars($step1['upc_code']) : '<span class="text-gray-500">Auto-generated</span>' ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-400">Record Label</div>
                                <div class="font-medium">
                                    <?= $step1['label'] ? htmlspecialchars($step1['label']) : '<span class="text-gray-500">Independent</span>' ?>
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-400">Explicit Content</div>
                                <div class="font-medium uppercase">
                                    <?= htmlspecialchars($step1['explicit']) ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($step1['description'])): ?>
                            <div class="mt-4">
                                <div class="text-gray-400 text-sm mb-1">Description</div>
                                <div class="text-sm text-gray-200 whitespace-pre-line">
                                    <?= nl2br(htmlspecialchars($step1['description'])) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <p class="text-gray-500 text-sm">No release details found in session.</p>
                    <?php endif; ?>
                </section>

                <!-- Stores & Social -->
                <section class="bg-gray-900/80 border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Stores & Social Platforms</h2>
                        <a href="<?= base_url('UploadAlbum/step2') ?>"
                           class="text-xs px-3 py-1 rounded-full border border-gray-600 hover:border-indigo-400 hover:text-indigo-300 transition">
                            Edit Step 2
                        </a>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <div class="text-gray-400 mb-2">Digital Stores</div>
                            <?php if (!empty($step2['stores']) && is_array($step2['stores'])): ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($step2['stores'] as $store): ?>
                                        <span class="px-3 py-1 rounded-full bg-gray-800 text-xs border border-gray-700">
                                            <?= htmlspecialchars($store) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-gray-500 text-xs">No stores selected</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="text-gray-400 mb-2">Social Platforms</div>
                            <?php if (!empty($step2['social']) && is_array($step2['social'])): ?>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($step2['social'] as $soc): ?>
                                        <span class="px-3 py-1 rounded-full bg-gray-800 text-xs border border-gray-700">
                                            <?= htmlspecialchars($soc) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-gray-500 text-xs">No social platforms selected</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Tracks -->
                <section class="bg-gray-900/80 border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Tracks</h2>
                        <a href="<?= base_url('UploadAlbum/step3') ?>"
                           class="text-xs px-3 py-1 rounded-full border border-gray-600 hover:border-indigo-400 hover:text-indigo-300 transition">
                            Edit Step 3
                        </a>
                    </div>

                    <?php if (!empty($step3) && is_array($step3)): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-700 text-gray-400">
                                        <th class="text-left py-2 pr-4">#</th>
                                        <th class="text-left py-2 pr-4">Title</th>
                                        <th class="text-left py-2 pr-4">Explicit</th>
                                        <th class="text-left py-2 pr-4 hidden md:table-cell">Audio File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($step3 as $index => $track): ?>
                                        <tr class="border-b border-gray-800/80">
                                            <td class="py-2 pr-4 text-gray-400">
                                                <?= $index + 1 ?>
                                            </td>
                                            <td class="py-2 pr-4">
                                                <?= htmlspecialchars($track['track_title']) ?>
                                            </td>
                                            <td class="py-2 pr-4">
                                                <?php if (!empty($track['is_explicit'])): ?>
                                                    <span class="px-2 py-1 text-xs rounded bg-red-600/20 border border-red-500 text-red-300">
                                                        Explicit
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-2 py-1 text-xs rounded bg-green-600/20 border border-green-500 text-green-300">
                                                        Clean
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-2 pr-4 text-gray-400 hidden md:table-cell">
                                                <?php if (!empty($track['audio_file'])): ?>
                                                    <span class="break-all text-xs">
                                                        <?= htmlspecialchars(basename($track['audio_file'])) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-gray-500 text-xs">Not uploaded</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">No tracks found in session.</p>
                    <?php endif; ?>
                </section>

            </div>

            <!-- Right: Artwork card -->
            <aside class="space-y-6">
                <section class="bg-gray-900/80 border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Artwork</h2>
                        <a href="<?= base_url('UploadAlbum/step4') ?>"
                           class="text-xs px-3 py-1 rounded-full border border-gray-600 hover:border-indigo-400 hover:text-indigo-300 transition">
                            Edit Step 4
                        </a>
                    </div>

                    <?php if (!empty($step4['cover_art'])): ?>
                        <div class="bg-gray-950/60 border border-gray-800 rounded-lg p-3 mb-4">
                            <img src="<?= base_url($step4['cover_art']) ?>"
                                 alt="Album Cover"
                                 class="w-full h-auto rounded-md shadow-lg">
                        </div>
                    <?php else: ?>
                        <div class="w-full aspect-square bg-gray-800 rounded-lg flex items-center justify-center mb-4">
                            <span class="text-gray-500 text-sm">No cover uploaded</span>
                        </div>
                    <?php endif; ?>

                    <div class="text-sm">
                        <div class="text-gray-400 mb-1">Template</div>
                        <div class="font-medium">
                            <?= !empty($step4['template']) ? htmlspecialchars($step4['template']) : 'None / Custom' ?>
                        </div>
                    </div>
                </section>
            </aside>
        </div>

        <!-- Bottom actions -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-t border-gray-800 pt-6">

            <!-- Back button -->
            <a href="<?= base_url('UploadAlbum/step4') ?>"
               class="inline-flex items-center gap-2 text-sm text-gray-300 hover:text-white">
                <span class="text-lg">&larr;</span>
                <span>Back to Artwork</span>
            </a>

            <!-- Edit step buttons & Submit -->
            <div class="flex flex-wrap gap-3 items-center">
                <a href="<?= base_url('UploadAlbum/step1') ?>"
                   class="px-4 py-2 text-xs md:text-sm rounded-full border border-gray-700 hover:border-indigo-400 hover:text-indigo-300 transition">
                    Edit Step 1
                </a>
                <a href="<?= base_url('UploadAlbum/step2') ?>"
                   class="px-4 py-2 text-xs md:text-sm rounded-full border border-gray-700 hover:border-indigo-400 hover:text-indigo-300 transition">
                    Edit Step 2
                </a>
                <a href="<?= base_url('UploadAlbum/step3') ?>"
                   class="px-4 py-2 text-xs md:text-sm rounded-full border border-gray-700 hover:border-indigo-400 hover:text-indigo-300 transition">
                    Edit Step 3
                </a>
                <a href="<?= base_url('UploadAlbum/step4') ?>"
                   class="px-4 py-2 text-xs md:text-sm rounded-full border border-gray-700 hover:border-indigo-400 hover:text-indigo-300 transition">
                    Edit Step 4
                </a>

                <form action="<?= base_url('UploadAlbum/submit') ?>" method="post" class="ml-0 md:ml-2">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-sm font-semibold shadow-lg hover:opacity-90 transition">
                        Submit Album
                    </button>
                </form>
            </div>
        </div>

    </main>
</body>
</html>
