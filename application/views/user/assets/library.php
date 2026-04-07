<!DOCTYPE html>
<html lang="en">
	
<head>
  <meta charset="UTF-8">
  <title>Dashboard - SoundFlow</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom Tailwind Colors -->
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
  
 <style>
#createProjectForm {
  max-height: 0;
  opacity: 0;
}
</style>


  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-white">

  <!-- Header -->
 <?php $this->view('page_header'); ?>


<div class="container mx-auto px-6 py-8 text-black">

  <!-- Page Title -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold">Asset Library</h1>
    <p class="text-muted">Manage your projects and uploaded assets</p>
  </div>

  <!-- Storage Usage -->
  <div class="bg-card border-b border-zinc-400/30 rounded-lg p-6 mb-8">
    <div class="flex justify-between text-sm mb-2">
      <span class="text-muted">Storage Used</span>
      <span><?= number_format($storage_used, 2) ?> GB / 10 GB</span>
    </div>

    <div class="w-full bg-border h-2 rounded">
      <div class="bg-primary h-2 rounded"
           style="width: <?= min(($storage_used / 10) * 100, 100) ?>%">
      </div>
    </div>
  </div>

  <!-- Header -->
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Your Projects</h2>

  <button
  type="button"
  onclick="openProjectForm()"
  class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
  + Create Project
</button>


  </div>
  
  
  
  <!-- Create Project Form -->
<div id="createProjectForm"
     class="bg-card border-b border-zinc-400/30 rounded-lg p-6 mb-8 hidden overflow-hidden transition-all duration-300 ease-out">

<h2 class="text-xl font-semibold mb-6">Create New Project</h2>


  <form id="projectForm">



<input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">

    <!-- Row 1 -->
    <div class="grid md:grid-cols-2 gap-6 mb-4">

      <div>
        <label class="text-sm font-medium">Project Name *</label>
        <input type="text" name="name" required
               placeholder="Song title or album name"
               class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
      </div>

      <div>
        <label class="text-sm font-medium">Project Type</label>
        <select name="project_type"
                class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
          <option value="song">Song</option>
          <option value="album">Album</option>
        </select>
      </div>

    </div>

    <!-- Row 2 -->
    <div class="grid md:grid-cols-3 gap-6 mb-4">

      <div>
        <label class="text-sm font-medium">Genre</label>
        <input name="genre"
               placeholder="e.g. Pop, Hip Hop"
               class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
      </div>

      <div>
        <label class="text-sm font-medium">BPM</label>
        <input type="number" name="bpm"
               placeholder="120"
               class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
      </div>

      <div>
        <label class="text-sm font-medium">Key</label>
        <input name="musical_key"
               placeholder="C major, Am"
               class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
      </div>

    </div>

    <!-- Description -->
    <div class="mb-4">
      <label class="text-sm font-medium">Description</label>
      <textarea name="description"
                placeholder="Project notes and description"
                class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black"></textarea>
    </div>

    <!-- Row 3 -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">

      <div>
        <label class="text-sm font-medium">Status</label>
        <select name="status"
                class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
          <option value="idea">Idea</option>
          <option value="draft">Draft</option>
          <option value="final">Final</option>
        </select>
      </div>

      <div>
        <label class="text-sm font-medium">Tags</label>
        <input name="tags"
               placeholder="electronic, synth, dance"
               class="w-full mt-1 bg-form border-b border-zinc-400/30 rounded px-3 py-2 text-black">
      </div>

    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-3">
      <button type="reset"
              class="px-4 py-2 bg-gray-700 rounded text-white">
        Reset
      </button>
	  
      <button type="submit"
              class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
        Create Project
      </button>
    </div>

  </form>
</div>



  <!-- Project List -->
  <div class="space-y-4">
    <?php foreach ($projects as $p): ?>
      <div
        class="bg-card border-b border-zinc-400/30 rounded-lg p-5 flex justify-between items-center">

        <div>
          <div class="font-semibold text-lg"><?= $p->name ?></div>
          <div class="text-sm text-muted">
            <div class="text-sm text-muted">
  <?= ucfirst($p->project_type) ?>
  • <?= ucfirst($p->status) ?>
  • <?= $p->asset_count ?> assets
</div>

          </div>
        </div>

        <a href="<?= site_url('assets/project/'.$p->id) ?>"
           class="text-primary hover:underline text-sm">
          Manage Assets →
        </a>
      </div>
    <?php endforeach; ?>

    <?php if (empty($projects)): ?>
      <div class="bg-card border-b border-zinc-400/30 rounded-lg p-8 text-center text-muted">
        No projects yet. Create one to start uploading assets.
      </div>
    <?php endif; ?>
  </div>

</div>



 <script>
    lucide.createIcons();
  </script>
  
 <script>
function openProjectForm() {
  const form = document.getElementById('createProjectForm');
  form.classList.remove('hidden');

  // slide-down
  requestAnimationFrame(() => {
    form.style.maxHeight = form.scrollHeight + 'px';
    form.style.opacity = '1';
  });

  // auto focus
  setTimeout(() => {
    form.querySelector('input[name="name"]').focus();
  }, 200);
}

function closeProjectForm() {
  const form = document.getElementById('createProjectForm');

  // slide-up
  form.style.maxHeight = '0px';
  form.style.opacity = '0';

  // reset form AFTER animation
  setTimeout(() => {
    form.classList.add('hidden');
    form.querySelector('form').reset();
  }, 300);
}
</script>




<script>
document.getElementById('projectForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('<?= site_url("assets/create_project") ?>', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(resp => {
    if (resp.status === 'success') {
      location.reload();
    } else {
      alert(resp.message || 'Failed to create project');
    }
  });
});
</script>

</body>

</html>

