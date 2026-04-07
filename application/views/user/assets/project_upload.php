<div class="bg-card border border-border rounded-lg p-6 mb-8">

  <h2 class="text-lg font-semibold mb-6">
    Upload Assets to "<span class="text-primary"><?= $project->name ?></span>"
  </h2>

  <form id="assetUploadForm" enctype="multipart/form-data">

    <input type="hidden" name="project_id" value="<?= $project->id ?>">

    <!-- Row 1 -->
    <div class="grid md:grid-cols-2 gap-6 mb-4">
      <div>
        <label class="text-sm font-medium">Asset Name (optional)</label>
        <input name="asset_name"
               placeholder="Leave blank to use filename"
               class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white">
      </div>

      <div>
        <label class="text-sm font-medium">Asset Type</label>
        <select name="asset_type"
                class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white">
          <option>Master Track</option>
          <option>Instrumental</option>
          <option>Stem</option>
          <option>Artwork</option>
          <option>Document</option>
        </select>
      </div>
    </div>

    <!-- Row 2 -->
    <div class="grid md:grid-cols-2 gap-6 mb-4">
      <div>
        <label class="text-sm font-medium">Version</label>
        <input name="version"
               placeholder="v1, final, radio edit"
               class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white">
      </div>

      <div>
        <label class="text-sm font-medium">Tags</label>
        <input name="tags"
               placeholder="lead vocal, verse, chorus"
               class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white">
      </div>
    </div>

    <!-- Credits -->
    <div class="mb-4">
      <label class="text-sm font-medium">Credits</label>
      <input name="credits"
             placeholder="John Doe, Jane Smith"
             class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white">
    </div>

    <!-- Notes -->
    <div class="mb-4">
      <label class="text-sm font-medium">Notes</label>
      <textarea name="notes"
                placeholder="Additional notes about this asset"
                class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white"></textarea>
    </div>

    <!-- File -->
    <div class="mb-6">
      <label class="text-sm font-medium">Select Files</label>
      <input type="file" name="file" required
             class="w-full mt-1 bg-black border border-border rounded px-3 py-2 text-white">
      <p class="text-xs text-muted mt-1">
        Supported: Audio (WAV, MP3, FLAC), Images (JPG, PNG), Videos (MP4), Documents (PDF, TXT)
      </p>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-3">
      <button type="submit"
              class="px-5 py-2 bg-primary text-black font-semibold rounded">
        Upload Files
      </button>
    </div>

  </form>
</div>
