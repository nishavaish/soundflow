<?php
// application/views/upload/edit.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Edit Release - <?php echo html_escape($release->title) ?></title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
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

  <!-- Lucide -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-background">

  <!-- Header (same as dashboard) -->
  <?php $this->view('page_header'); ?>
  

  <div class="container mx-auto px-6 py-8">
    <div class="max-w-3xl mx-auto bg-card border border-border rounded p-6">
      <h2 class="text-2xl font-bold text-white mb-4">Edit Release</h2>

      <?php echo form_open('my-releases/edit/'.$release->id, ['class' => 'space-y-4']); ?>

        <div>
          <label class="block text-sm text-muted mb-1">Title</label>
          <input type="text" name="title" value="<?php echo set_value('title', $release->title) ?>" class="w-full p-2 bg-gray-900 border border-border rounded text-white" />
          <?php echo form_error('title', '<div class="text-red-400 text-sm mt-1">', '</div>'); ?>
        </div>

        <div>
          <label class="block text-sm text-muted mb-1">Primary Artist</label>
          <input type="text" name="primary_artist" value="<?php echo set_value('primary_artist', $release->primary_artist) ?>" class="w-full p-2 bg-gray-900 border border-border rounded text-white" />
          <?php echo form_error('primary_artist', '<div class="text-red-400 text-sm mt-1">', '</div>'); ?>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-muted mb-1">Release Date</label>
            <input type="date" name="release_date" value="<?php echo set_value('release_date', $release->release_date) ?>" class="w-full p-2 bg-gray-900 border border-border rounded text-white" />
            <?php echo form_error('release_date', '<div class="text-red-400 text-sm mt-1">', '</div>'); ?>
          </div>

          <div>
            <label class="block text-sm text-muted mb-1">Genre</label>
            <input type="text" name="genre" value="<?php echo set_value('genre', $release->genre) ?>" class="w-full p-2 bg-gray-900 border border-border rounded text-white" />
            <?php echo form_error('genre', '<div class="text-red-400 text-sm mt-1">', '</div>'); ?>
          </div>
        </div>

        <div>
          <label class="block text-sm text-muted mb-1">Description</label>
          <textarea name="description" rows="4" class="w-full p-2 bg-gray-900 border border-border rounded text-white"><?php echo set_value('description', $release->description) ?></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3">
          <a href="<?php echo site_url('my-releases/view/'.$release->id) ?>" class="px-4 py-2 rounded bg-gray-800 text-white">Cancel</a>
          <button type="submit" class="px-4 py-2 rounded bg-primary text-white font-semibold">Save changes</button>
        </div>

      <?php echo form_close(); ?>
    </div>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>
