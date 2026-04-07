<div class="max-w-5xl mx-auto py-10">

    <a href="<?php echo site_url('my-songs'); ?>" 
       class="text-primary-custom text-sm hover:underline mb-6 inline-block">
       ← Back to Library
    </a>

    <div class="flex gap-8">

        <!-- Cover -->
        <div class="w-60">
            <?php if ($album->cover_image): ?>
                <img src="<?php echo base_url('uploads/albums/' . $album->cover_image); ?>"
                     class="w-full rounded-xl shadow-lg mb-4">
            <?php else: ?>
                <div class="w-full h-60 bg-zinc-800 rounded-xl"></div>
            <?php endif; ?>
        </div>

        <!-- Info -->
        <div class="flex-1">
            <h1 class="text-4xl font-bold mb-2"><?php echo $album->album_title; ?></h1>

            <p class="text-gray-400 mb-3">
                Released <?php echo date('F d, Y', strtotime($album->created_at)); ?>
            </p>

            <p class="text-gray-300 max-w-xl">
                <?php echo $album->description; ?>
            </p>
        </div>

    </div>



    <!-- Songs in Album -->
    <h2 class="text-2xl font-semibold mt-10 mb-3">Tracks</h2>

    <?php if (empty($songs)): ?>
        <p class="text-gray-400">No songs in this album.</p>
    <?php else: ?>

        <div class="space-y-4 mt-4">

            <?php foreach ($songs as $track): ?>
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-4 flex items-center justify-between">

                    <div>
                        <h3 class="font-semibold"><?php echo $track->song_title; ?></h3>
                        <p class="text-gray-400 text-xs"><?php echo $track->genre ?: '—'; ?></p>
                    </div>

                    <div>
                        <?php if ($track->audio_file): ?>
                            <audio controls class="w-48">
                                <source src="<?php echo base_url('uploads/singles/' . $track->audio_file); ?>">
                            </audio>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
