<section class="upload-album">
  <h1>Upload Album</h1>
  <p>This page can contain forms for multiple file uploads and metadata fields.</p>
  <form method="post" action="<?php echo base_url('upload/album') ?>" enctype="multipart/form-data">
    <div>
      <label>Album Name</label>
      <input type="text" name="album_name">
    </div>
    <div>
      <label>Files</label>
      <input type="file" name="files[]" multiple>
    </div>
    <button type="submit">Create Album</button>
  </form>
</section>
