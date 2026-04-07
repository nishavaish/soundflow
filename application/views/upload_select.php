<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Select Upload Type - SoundFlow</title>

  <style>
@keyframes slideInRight {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate-slideInRight {
  animation: slideInRight 0.4s ease-out forwards;
}
</style>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom Tailwind Colors -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#ff531a",
            background: "#eee",
            border: "#27272a",
            muted: "#9ca3af"
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

</head>

<!-- <body class="min-h-screen bg-background flex items-center justify-center px-4 text-black"> -->
<body style="background-image: url('uploads/covers/back-img.png');
         background-size: contain;
         background-position: left;
         background-repeat: no-repeat;" class="min-h-screen bg-black/40 flex justify-end">

  <!-- <div class="w-full max-w-4xl relative"> -->
  <div
  class="relative h-screen w-full sm:w-[90%] md:w-[40%] lg:w-[35%]
         bg-background text-black
         shadow-2xl
         animate-slideInRight">

  <!-- Close Button -->
  <a href="<?php echo site_url('dashboard') ?>"
     class="absolute top-4 right-4 z-10">
    <button class="p-2 rounded-md hover:bg-black/10">
      <i data-lucide="x" class="w-6 h-6"></i>
    </button>
  </a>

  <!-- Vertically centered content -->
  <div class="h-full flex flex-col justify-center px-6 py-8">

    <!-- Heading -->
    <div class="text-center mb-12">
      <h1 class="text-4xl md:text-5xl font-bold mb-8">
        What would you like to release?
      </h1>
    </div>

    <!-- Selection Grid -->
    <div class="grid md:grid-cols-2 gap-8">

      <a href="<?php echo site_url('UploadSingle/step1') ?>"
         class="group block border-2 border-border hover:border-primary rounded-lg p-12 transition-all hover:scale-105 text-center">
        <h2 class="text-xl font-bold group-hover:text-primary">
          SINGLE
        </h2>
      </a>

      <a href="<?php echo site_url('UploadAlbum/step1') ?>"
         class="group block border-2 border-border hover:border-primary rounded-lg p-12 transition-all hover:scale-105 text-center">
        <h2 class="text-xl font-bold group-hover:text-primary">
          ALBUM
        </h2>
      </a>

    </div>
  </div>
</div>


  <script>
    lucide.createIcons();
  </script>

</body>

</html>
