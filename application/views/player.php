<!DOCTYPE html>
<html>
<head>
<title><?= $song->song_name ?></title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white flex items-center justify-center h-screen">

<div class="text-center">

<img src="<?= base_url($song->artwork_path) ?>" 
class="w-64 mx-auto rounded mb-4">

<h1 class="text-2xl font-bold"><?= $song->song_name ?></h1>
<p class="text-gray-400"><?= $song->artist_name ?></p>

<audio controls controlsList="nodownload" class="mt-4 w-full">
  <source src="<?= base_url('Sampling/stream/'.$song->id) ?>" type="audio/mpeg">
</audio>

</div>

</body>
</html>