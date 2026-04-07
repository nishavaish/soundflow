<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sampling Manager</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: "#ff531a",
        card: "#111111",
        border: "#27272a"
      }
    }
  }
}
</script>

<style>
@keyframes slideIn {
from { transform: translateX(100%); opacity:0; }
  to { transform: translateX(0); opacity:1; }
}

.animate-slide-in {
  animation: slideIn 0.3s ease;
}
</style>


</head>

<body class="bg-white">

<?php $this->view('page_header'); ?>

<div class="container mx-auto px-6 py-8">



<div class="flex justify-between items-center mb-6">
  <h1 class="text-3xl font-bold">🎧 My Songs</h1>
  
  <button onclick="openModal()" 
    class="bg-primary text-white px-4 py-2 rounded shadow hover:opacity-90">
    + Upload Song
  </button>
</div>




<!-- SONG LIST -->
<div class="bg-white border rounded-lg p-6 shadow">

<h2 class="text-xl font-semibold mb-4">Your Uploads</h2>

<?php if(empty($songs)): ?>
<p class="text-gray-500">No songs uploaded yet</p>
<?php else: ?>

<div class="overflow-x-auto">
<table class="w-full text-left">

<thead>
<tr class="border-b">
<th class="p-3">Artwork</th>
<th class="p-3">Song</th>
<th class="p-3">Stats</th>
<th class="p-3">Share</th>
</tr>
</thead>

<tbody>

<?php foreach($songs as $s): ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-3">
<img src="<?= base_url($s->artwork_path) ?>" class="w-12 h-12 rounded object-cover">
</td>

<td class="p-3">
<div class="font-semibold"><?= $s->song_name ?></div>
<div class="text-sm text-gray-500"><?= $s->artist_name ?></div>
</td>

<td class="p-3 text-sm">
🎧 <?= number_format($s->total_plays) ?><br>
🔗 <?= number_format($s->total_clicks) ?>
</td>

<td class="p-3">

<div class="flex items-center gap-2">

<input 
type="text" 
value="<?= base_url('Sampling/song/'.$s->unique_slug) ?>" 
id="link<?= $s->id ?>"
class="border p-1 text-xs w-full rounded" readonly>

<button onclick="copyLink(<?= $s->id ?>)" 
class="bg-black text-white px-2 py-1 text-xs rounded">
Copy
</button>

</div>


<div class="flex gap-2 mt-2">

<button onclick="openEditModal(
  <?= $s->id ?>,
  '<?= htmlspecialchars($s->song_name, ENT_QUOTES) ?>',
  '<?= htmlspecialchars($s->artist_name, ENT_QUOTES) ?>'
)" 
class="bg-blue-500 text-white px-2 py-1 text-xs rounded">
Edit
</button>

<button onclick="openDeleteModal(<?= $s->id ?>)" 
class="bg-red-500 text-white px-2 py-1 text-xs rounded">
Delete
</button>

</div>

</td>

</tr>

<?php endforeach; ?>

</tbody>
</table>
</div>

<?php endif; ?>

</div>

</div>

<script>
function copyLink(id){
    let copyText = document.getElementById("link"+id);
    copyText.select();
    document.execCommand("copy");
    //alert("Link copied!");
	showToast("Link copied!", 'success'); // ✅ TOAST
}
</script>




<!-- UPLOAD MODAL -->
<div id="uploadModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

  <div class="bg-white w-full max-w-lg rounded-lg p-6 relative shadow-lg">

    <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 text-xl">✕</button>

    <h2 class="text-xl font-semibold mb-4">Upload New Song</h2>

    <form id="uploadForm" enctype="multipart/form-data" class="space-y-4">

      <input type="hidden" 
        name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>" />

      <input type="text" name="song_name" placeholder="Song Name" required class="w-full p-2 border rounded">

      <input type="text" name="artist_name" placeholder="Artist Name" class="w-full p-2 border rounded">

      <!-- DRAG DROP ARTWORK -->
      <div class="border-2 border-dashed p-4 text-center rounded" id="artworkDrop">
        <p class="text-sm text-gray-500">Drop Artwork here or click</p>
        <input type="file" name="artwork" accept="image/*" hidden>
      </div>

      <!-- DRAG DROP AUDIO -->
      <div class="border-2 border-dashed p-4 text-center rounded" id="audioDrop">
        <p class="text-sm text-gray-500">Drop MP3 here or click</p>
        <input type="file" name="audio" accept="audio/mpeg" hidden>
      </div>

      <!-- PROGRESS BAR -->
      <div class="w-full bg-gray-200 rounded h-3 hidden" id="progressBox">
        <div id="progressBar" class="bg-primary h-3 rounded w-0"></div>
      </div>

      <button type="submit" class="w-full bg-primary text-white py-2 rounded">
        Upload Song
      </button>

    </form>

  </div>
</div>



<script>
function openModal(){
  document.getElementById('uploadModal').classList.remove('hidden');
  document.getElementById('uploadModal').classList.add('flex');
}

function closeModal(){
  document.getElementById('uploadModal').classList.add('hidden');
}
</script>



<script>
function setupDrop(id){
  const box = document.getElementById(id);
  const input = box.querySelector("input");

  box.addEventListener("click", () => input.click());

  box.addEventListener("dragover", e => {
    e.preventDefault();
    box.classList.add("bg-gray-100");
  });

  box.addEventListener("dragleave", () => {
    box.classList.remove("bg-gray-100");
  });

  box.addEventListener("drop", e => {
    e.preventDefault();
    box.classList.remove("bg-gray-100");

    const files = e.dataTransfer.files;

    if(files.length === 0) return;

    // ✅ FIX: Properly assign file
    const dt = new DataTransfer();
    dt.items.add(files[0]); // only first file
    input.files = dt.files;

    box.querySelector("p").innerText = files[0].name;
  });

  input.addEventListener("change", () => {
    if(input.files.length > 0){
      box.querySelector("p").innerText = input.files[0].name;
    }
  });
}

setupDrop("artworkDrop");
setupDrop("audioDrop");
</script>


<script>
document.getElementById("uploadForm").addEventListener("submit", function(e){
  e.preventDefault();

  let form = this;
  let formData = new FormData(form);

  let csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
  let csrfHash = "<?= $this->security->get_csrf_hash(); ?>";
  formData.append(csrfName, csrfHash);

  let xhr = new XMLHttpRequest();

  document.getElementById("progressBox").classList.remove("hidden");

  xhr.upload.addEventListener("progress", function(e){
    if(e.lengthComputable){
      let percent = (e.loaded / e.total) * 100;
      document.getElementById("progressBar").style.width = percent + "%";
    }
  });

  xhr.onload = function(){
    //console.log("RESPONSE:", xhr.responseText);

    if(xhr.status == 200){
      try {
        let res = JSON.parse(xhr.responseText);

        if(res.status === 'success'){
          showToast(res.message, 'success'); // ✅ TOAST
          
          setTimeout(() => {
            location.reload();
          }, 1200);

        } else {
          showToast(res.message, 'error'); // ✅ ERROR TOAST
        }

      } catch(e){
        showToast("Server error occurred", 'error');
      }
    } else {
      showToast("Upload failed", 'error');
    }
  };

  xhr.open("POST", "<?= base_url('Sampling/save') ?>", true);
  xhr.send(formData);
});
</script>



<div id="editModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

  <div class="bg-white w-full max-w-md p-6 rounded">

    <h2 class="text-lg font-bold mb-4">Edit Song</h2>

    <form method="post" action="<?= base_url('Sampling/update') ?>">

      <input type="hidden" name="id" id="edit_id">

      <input type="hidden" 
        name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>" />

      <input type="text" name="song_name" id="edit_song" class="w-full mb-3 p-2 border rounded">

      <input type="text" name="artist_name" id="edit_artist" class="w-full mb-3 p-2 border rounded">

      <button class="w-full bg-primary text-white py-2 rounded">Update</button>

    </form>

  </div>
</div>

<script>
function openEditModal(id, song, artist){
  document.getElementById("edit_id").value = id;
  document.getElementById("edit_song").value = song;
  document.getElementById("edit_artist").value = artist;

  document.getElementById("editModal").classList.remove("hidden");
  document.getElementById("editModal").classList.add("flex");
}
</script>
<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

  <div class="bg-white p-6 rounded-lg w-full max-w-sm text-center">

    <h2 class="text-lg font-bold mb-4">Delete Song</h2>
    <p class="text-gray-600 mb-6">Are you sure you want to delete this song?</p>

    <form method="post" action="<?= base_url('Sampling/delete') ?>">

      <input type="hidden" name="id" id="delete_id">

      <input type="hidden" 
        name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>" />

      <div class="flex justify-center gap-3">
        <button type="button" onclick="closeDeleteModal()" 
          class="px-4 py-2 border rounded">
          Cancel
        </button>

        <button type="submit" 
          class="px-4 py-2 bg-red-500 text-white rounded">
          Delete
        </button>
      </div>

    </form>

  </div>
</div>

<script>
function openDeleteModal(id){
  document.getElementById("delete_id").value = id;
  document.getElementById("deleteModal").classList.remove("hidden");
  document.getElementById("deleteModal").classList.add("flex");
}

function closeDeleteModal(){
  document.getElementById("deleteModal").classList.add("hidden");
}
</script>


<?php if($this->session->flashdata('success')): ?>
<div id="toast-success" class="fixed top-5 right-5 bg-green-500 z-[9999] text-white px-5 py-3 rounded-lg shadow-xl flex items-center gap-3 animate-slide-in">

  <span> <?= $this->session->flashdata('success') ?></span>

</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div id="toast-error" class="fixed top-5 right-5 z-[9999] bg-green-500 text-white px-5 py-3 rounded-lg shadow-xl flex items-center gap-3 animate-slide-in">

  <span> <?= $this->session->flashdata('error') ?></span>

</div>
<?php endif; ?>

<script>
setTimeout(() => {
  let success = document.getElementById('toast-success');
  let error = document.getElementById('toast-error');

  if(success){
    success.style.transition = "opacity 0.5s";
    success.style.opacity = "0";
    setTimeout(() => success.remove(), 500);
  }

  if(error){
    error.style.transition = "opacity 0.5s";
    error.style.opacity = "0";
    setTimeout(() => error.remove(), 500);
  }

}, 3000);
</script>


<script>
function showToast(message, type = 'success') {

  const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';

  const toast = document.createElement('div');
  toast.className = `fixed top-20 right-5 z-[9999] ${bgColor} text-white px-5 py-3 rounded-lg shadow-xl flex items-center gap-3 animate-slide-in`;

  toast.innerHTML = `<span>${message}</span>`;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.transition = "opacity 0.5s";
    toast.style.opacity = "0";
    setTimeout(() => toast.remove(), 500);
  }, 3000);
}
</script>

</body>
</html>