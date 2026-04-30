<input type="file" id="artworkInput">
<input type="file" id="audioInput">
<button onclick="uploadSong()">Upload</button>

<div>
  Artwork <div id="aBar" style="height:10px;background:blue;width:0%"></div>
  Audio <div id="bBar" style="height:10px;background:green;width:0%"></div>
</div>

<script>
async function uploadSong() {

    const art = artworkInput.files[0];
    const aud = audioInput.files[0];

    const [artUrl, audioUrl] = await Promise.all([
        uploadArtwork(art),
        uploadAudio(aud)
    ]);

  /*   await fetch('/AWSUploading/saveSong', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({artwork: artUrl, audio: audioUrl})
    });
 */
 
 
 console.log(artUrl);
 console.log(audioUrl);
 
    alert("Done");
}

async function uploadArtwork(file) {
const safeName = file.name.replace(/\s+/g, "_");
    const r = await fetch(`/AWSUploading/getArtworkUrl?file_name=${safeName}`);
    const d = await r.json();

    await fetch(d.url, {method:'PUT', body:file});

    aBar.style.width = '100%';

    return d.file_url;
}

async function uploadAudio(file) {
	
	try {
		console.log("🚀 uploadAudio called");
		const safeName = file.name.replace(/\s+/g, "_");

		const init = await fetch(`/AWSUploading/initiateMultipart?file_name=${safeName}`);
		console.log("INIT RESPONSE RAW:", init);
		
		
		const data = await init.json();
		console.log("INIT DATA:", data);
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

			const res = await fetch(url, { method: 'PUT', body: blob });

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
				ETag: etag.replaceAll('"',''),
				PartNumber: i
			});

			bBar.style.width = (i / total * 100) + '%';
		}

		console.log("FINAL PAYLOAD:", { key: data.key, uploadId: data.uploadId, parts });

		const done = await fetch('/AWSUploading/completeMultipart', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ key: data.key, uploadId: data.uploadId, parts })
		});

		const final = await done.json();

		return final.file_url;
		
	} catch (err) {
        console.error("❌ ERROR:", err);
        alert("JS Error: " + err);
    }
}
</script>