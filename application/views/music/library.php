<div class="w-full max-w-7xl mx-auto py-10">

    <!-- Page Title -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-primary-custom">Your Music Library</h1>

        <a href="<?php echo site_url('UploadAlbum/step1'); ?>" 
           class="bg-primary-custom px-4 py-2 rounded-full text-sm font-semibold hover:bg-orange-600">
           + Upload Album
        </a>
<a href="<?php echo site_url('UploadSingle/step1'); ?>" 
           class="bg-primary-custom px-4 py-2 rounded-full text-sm font-semibold hover:bg-orange-600 ml-3">
           + Upload Single
        </a>
    </div>

<form method="get" class="mb-6 flex flex-wrap gap-4 items-center">

    <!-- Search by Title -->
    <input 
        type="text" 
        name="q" 
        placeholder="Search title…" 
        value="<?= $this->input->get('q'); ?>"
        class="px-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white w-64"
    />

    <!-- Genre -->
    <select name="genre"
        class="px-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white w-40">
        <option value="">All Genres</option>
        <option value="pop"      <?= ($this->input->get('genre')=='pop') ? 'selected' : '' ?>>Pop</option>
        <option value="rock"     <?= ($this->input->get('genre')=='rock') ? 'selected' : '' ?>>Rock</option>
        <option value="hiphop"   <?= ($this->input->get('genre')=='hiphop') ? 'selected' : '' ?>>Hip-Hop</option>
        <option value="electronic" <?= ($this->input->get('genre')=='electronic') ? 'selected' : '' ?>>Electronic</option>
    </select>

    <!-- Release Date -->
    <input 
        type="date" 
        name="date" 
        value="<?= $this->input->get('date'); ?>"
        class="px-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white"
    />

    <button class="bg-primary-custom text-black px-4 py-2 rounded-full">
        Filter
    </button>

</form>



    <!-- ===================================================== -->
    <!--                       ALBUM GRID                      -->
    <!-- ===================================================== -->
    <h2 class="text-xl font-semibold mb-3">Your Albums</h2>

    <?php if (empty($albums)): ?>
        <p class="text-gray-400 mb-10">You have no uploaded albums yet.</p>
    <?php else: ?>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-12">

            <?php foreach ($albums as $album): ?>
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-3 hover:bg-zinc-800 transition">

                    <!-- Cover -->
                    <?php if (!empty($album->cover_image)): ?>
                        <a href="<?php echo site_url('albums/detail/' . $album->id); ?>">
                            <img src="<?php echo base_url('uploads/albums/' . $album->cover_image); ?>"
                                class="w-full h-40 object-cover rounded-lg mb-3 shadow-lg">
                        </a>
                    <?php else: ?>
                        <a href="<?php echo site_url('albums/detail/' . $album->id); ?>">
                            <div class="w-full h-40 rounded-lg bg-zinc-800 flex items-center justify-center text-gray-500">
                                No Cover
                            </div>
                        </a>
                    <?php endif; ?>

                    <!-- Title -->
                    <h3 class="font-semibold text-sm truncate mb-1"><?php echo @$album->album_title; ?></h3>

                    <!-- Release Date -->
                    <p class="text-xs text-gray-400 mb-2">
                        <?php echo date('M d, Y', strtotime($album->created_at)); ?>
                    </p>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <a href="<?php echo site_url('UploadAlbum/edit/' . $album->id); ?>"
                           class="text-primary-custom text-xs hover:underline">Edit</a>

                        <a href="<?php echo site_url('UploadAlbum/delete/' . $album->id); ?>"
                           class="text-red-500 text-xs hover:underline"
                           onclick="return confirm('Delete this album?')">Delete</a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- Pagination -->
        <div class="text-center my-6">
            <?php echo $album_pagination_links; ?>
        </div>

    <?php endif; ?>



    <!-- ===================================================== -->
    <!--                    SINGLE TRACKS LIST                 -->
    <!-- ===================================================== -->
    <h2 class="text-xl font-semibold mb-3 mt-12">Your Single Tracks</h2>

    <?php if (empty($singles)): ?>
        <p class="text-gray-400">No single tracks uploaded yet.</p>

    <?php else: ?>

        <table class="w-full border border-zinc-800 rounded-xl overflow-hidden">
            <thead>
                <tr class="bg-zinc-800 text-gray-300 text-left">
                    <th class="px-4 py-3">Track</th>
                    <th class="px-4 py-3">Genre</th>
                    <th class="px-4 py-3">Duration</th>
                    <th class="px-4 py-3">Uploaded</th>
                    <th class="px-4 py-3">Preview</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($singles as $song): ?>
                    <tr class="border-t border-zinc-800">

                        <!-- Name -->
                        <td class="px-4 py-3 font-medium">
                            <?php echo $song->title; ?>
                        </td>

                        <!-- Genre -->
                        <td class="px-4 py-3 text-gray-400">
                            <?php echo $song->genre ?: '—'; ?>
                        </td>

                        <!-- Duration -->
                        <td class="px-4 py-3 text-gray-400">
                            <?php echo $song->release_date ?: '—'; ?>
                        </td>

                        <!-- Date -->
                        <td class="px-4 py-3 text-gray-400">
                            <?php echo date('M d, Y', strtotime($song->created_at)); ?>
                        </td>

                        <!-- Preview -->
                        <td class="px-4 py-3">
                            <?php if (!empty($song->audio_file)): ?>
                                <audio controls class="w-40">
                                    <source src="<?php echo base_url('uploads/singles/' . $song->audio_file); ?>" type="audio/mpeg">
                                </audio>
                            <?php else: ?>
                                <span class="text-gray-500 text-sm">No audio</span>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 flex gap-3">
                            <a href="<?php echo site_url('UploadSingle/edit/' . $song->id); ?>"
                               class="text-primary-custom text-sm hover:underline">Edit</a>

                            <a href="<?php echo site_url('UploadSingle/delete/' . $song->id); ?>"
                               class="text-red-500 text-sm hover:underline"
                               onclick="return confirm('Delete this track?')">Delete</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="text-center my-6">
            <?php echo $single_pagination_links; ?>
        </div>

    <?php endif; ?>

</div>


<script>
let song_page = 0;

function loadMoreSingles() {
    song_page++;

    fetch("<?= site_url('UploadSingle/ajaxLoadMore/') ?>" + song_page)
        .then(res => res.text())
        .then(html => {
            document.getElementById("singleList").insertAdjacentHTML("beforeend", html);
        });
}
</script>

