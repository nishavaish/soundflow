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
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
<style>
@keyframes slideIn {
from { transform: translateX(100%); opacity:0; }
  to { transform: translateX(0); opacity:1; }
}

.animate-slide-in {
  animation: slideIn 0.3s ease;
}


.lazy-artwork {
  background: #f3f3f3 url('<?php echo base_url() ?>/assets/img/img-loader.webp') center no-repeat;
}
</style>


</head>

<body class="bg-white">
	


<?php $this->view('page_header'); ?>

<div class="container mx-auto px-6 py-8">



<div class="flex justify-between items-center mb-6">
  <h1 class="text-3xl font-bold"> My Showcase</h1>
  
  <button onclick="openModal()" 
    class="bg-primary text-white px-4 py-2 rounded shadow hover:opacity-90">
    + Upload Song
  </button>
</div>




<!-- SONG LIST -->
<div class="bg-white border rounded-lg p-6 shadow">

<h2 class="text-xl font-semibold mb-4">Your Songs</h2>

<?php if(empty($songs)): ?>
<p class="text-gray-500">No songs uploaded yet</p>
<?php else: ?>

<div class="overflow-x-auto">
<table class="w-full text-left">

<thead>
<tr class="border-b">
<th class="p-3">Artwork</th>
<th class="p-3">Song</th>
<!-- <th class="p-3">Stats</th> -->
<th class="p-3">Share</th>
</tr>
</thead>

<tbody>

<?php foreach($songs as $s): ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-3">
	<?php //$artPath =  $this->s3uploader->getSignedGetUrl($s->artwork_path, 3600); ?>
<!-- <img src="<?= $artPath; ?>" class="w-24 h-24 rounded object-cover"> -->

<img  class="lazy-artwork" data-key="<?= $s->artwork_path ?>"  src="<?php echo base_url() ?>/assets/img/img-loader.webp"  style="width:100px;height:100px;" />
</td>

<td class="p-3">
<div class="font-semibold"><?= $s->song_name ?></div>
<div class="text-sm text-gray-500"><?= $s->artist_name ?></div>
</td>

<!--
<td class="p-3 text-sm">
🎧 <?= number_format($s->total_plays) ?><br>
🔗 <?= number_format($s->total_clicks) ?>
</td> -->

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
    lucide.createIcons();
  </script>

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
        <input type="file" name="artwork" accept="image/*" id="artworkInput" hidden>
      </div>

      <!-- DRAG DROP AUDIO -->
      <div class="border-2 border-dashed p-4 text-center rounded" id="audioDrop">
        <p class="text-sm text-gray-500">Drop MP3 here or click</p>
        <input type="file" name="audio" accept="audio/mpeg" id="audioInput" hidden>
      </div>

      <!-- PROGRESS BAR -->
      <div class="w-full bg-gray-200 rounded h-3 hidden" id="progressBox">
        <div id="progressBar" class="bg-primary h-3 rounded w-0"></div>
      </div>
	  
	  <input type="hidden" name="artwork_url" id="artwork_url">
	<input type="hidden" name="audio_url" id="audio_url">
	  
	  <button id="uploadBtn" type="button"  class="w-full bg-primary text-white py-2 rounded"  onclick="uploadSong()">
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





<script>
async function uploadSong() {

    const btn = document.getElementById("uploadBtn");
    const loader = document.getElementById("globalLoader");

    try {
        const art = artworkInput.files[0];
        const aud = audioInput.files[0];

        if (!art || !aud) {
            showToast("Select artwork & audio", "error");
            return;
        }

        // ✅ Disable button + show loader
        btn.disabled = true;
        btn.innerText = "Uploading...";
       loader.classList.remove("hidden"); // show

        const [artUrl, audioUrl] = await Promise.all([
            uploadArtwork(art),
            uploadAudio(aud)
        ]);

        console.log("ART:", artUrl);
        console.log("AUDIO:", audioUrl);
		
		 // ✅ Inject into form
        document.getElementById("artwork_url").value = artUrl;
        document.getElementById("audio_url").value = audioUrl;

        // ✅ Trigger form submit
        document.getElementById("uploadForm").dispatchEvent(new Event('submit', { cancelable: true }));


        showToast("Upload successful", "success");

        setTimeout(() => location.reload(), 1200);

    } catch (err) {
        console.error(err);
        showToast("Upload failed", "error");
    } finally {
        // ✅ Reset UI
        btn.disabled = false;
        btn.innerText = "Upload Song";
        loader.classList.add("hidden");
    }
}



async function uploadArtwork(file) {
const safeName = file.name.replace(/\s+/g, "_");
    const r = await fetch(`/AWSUploading/getArtworkUrl?file_name=${safeName}`);
    const d = await r.json();

    await fetch(d.url, {method:'PUT',  headers: {
        "x-amz-acl": "private"
    }, body:file});

   // aBar.style.width = '100%';

    return d.file_url;
}

async function uploadAudio(file) {
	
	try {
		//console.log("🚀 uploadAudio called");
		const safeName = file.name.replace(/\s+/g, "_");

		const init = await fetch(`/AWSUploading/initiateMultipart?file_name=${safeName}`);
		//console.log("INIT RESPONSE RAW:", init);
		
		
		const data = await init.json();
		//console.log("INIT DATA:", data);
		if (!data.key || !data.uploadId) {
			alert("Failed to initiate upload");
			return;
		}

		const chunk = 5 * 1024 * 1024;
		const total = Math.ceil(file.size / chunk);
		let parts = [];

		for (let i = 1; i <= total; i++) {

			const start = (i - 1) * chunk;
			const blob = file.slice(start, start + chunk);

			const u = await fetch(`/AWSUploading/getChunkUploadUrl?key=${data.key}&uploadId=${data.uploadId}&partNumber=${i}`);
			const { url } = await u.json();

			const res = await fetch(url, { method: 'PUT',   body: blob });

			if (!res.ok) {
				alert("Upload failed at part " + i);
				return;
			}

			const etag = res.headers.get('ETag');

			if (!etag) {
				alert("Missing ETag. Fix S3 CORS.");
				return;
			}

			parts.push({
			ETag: `"${etag.replace(/"/g,'')}"`,
				
				PartNumber: i
			});

			//bBar.style.width = (i / total * 100) + '%';
		}

		//console.log("FINAL PAYLOAD:", { key: data.key, uploadId: data.uploadId, parts });

		const done = await fetch('/AWSUploading/completeMultipart', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ key: data.key, uploadId: data.uploadId, parts })
		});

		const final = await done.json();
		
		//console.log("COMPLETE RESPONSE", final);

		return final.file_url;
		
	} catch (err) {
       // console.error("❌ ERROR:", err);
        alert("JS Error: " + err);
    }
}
</script>



<div id="globalLoader" class="hidden fixed inset-0 bg-black/70 z-[9999] flex items-center justify-center">
  <div class="text-white text-center">
    <div class="animate-spin rounded-full h-10 w-10 border-4 border-white border-t-transparent mx-auto"></div>
    <p class="mt-3 text-sm">Uploading your track...</p>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

	const images = document.querySelectorAll('.lazy-artwork');

	const keys = Array.from(images).map(img => img.dataset.key);

	fetch('<?= site_url("Sampling/getBulkSignedUrls") ?>', {
	  method: 'POST',
	  headers: {
		'Content-Type': 'application/json'
	  },
	 body: JSON.stringify({
  keys,
  '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
})
	})
	.then(async (r) => {
	  const text = await r.text();

	  try {
		return JSON.parse(text);
	  } catch (e) {
		console.error("RAW RESPONSE:", text); // 👈 see actual error
		throw new Error("Invalid JSON");
	  }
	})
	.then(res => {

	  if (res.status !== 'success') {
		console.error(res.message);
		return;
	  }

	  images.forEach(img => {
		const key = img.dataset.key;
		if (res.data[key]) {
		  img.src = res.data[key];
		}
	  });

	})
	.catch(err => {
	  console.error("Fetch error:", err);
	});

});
</script>

</body>
</html>