<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= "Test" ?> | Soundflow</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>


body {
  margin: 0;
  overflow-x: hidden;
  font-family: 'Poppins', sans-serif;
  color: white;
}

/* ===== MINI PLAYER ===== */
.mini-player {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  background: rgba(0,0,0,0.8);
  backdrop-filter: blur(12px);
  border-top: 1px solid rgba(255,255,255,0.1);
  padding: 10px 15px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 50;
}

.mini-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.mini-art {
  width: 45px;
  height: 45px;
  border-radius: 8px;
  object-fit: cover;
}

.mini-info {
  font-size: 12px;
}

.mini-title {
  font-weight: 600;
}

.mini-artist {
  color: #aaa;
}

/* Title */
.mini-title, h1 {
  font-weight: 600;
  letter-spacing: 0.3px;
}

/* Artist */
.mini-artist {
  font-weight: 400;
  opacity: 0.8;
}

.mini-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: white;
  color: black;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ===== PROGRESS LINE ===== */
.mini-progress {
  position: absolute;
  top: 0;
  left: 0;
  height: 2px;
  background: white;
  width: 0%;
}


/* ===== ARTWORK RING ===== */
.ring-wrapper {
  position: relative;
  width: 260px;
  height: 260px;
}

/* glowing gradient ring */
.ring {
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  background: conic-gradient(
    #ff00cc,
    #3333ff,
    #00ffcc,
    #ffcc00,
    #ff00cc
  );
  filter: blur(4px);
  opacity: 0.9;
  animation: spin 6s linear infinite;
  animation-play-state: paused; /* IMPORTANT */
}

/* inner cut */
.ring::after {
  content: "";
  position: absolute;
  inset: 8px;
  background: black;
  border-radius: 50%;
}

/* artwork */
.artwork {
  position: relative;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
  z-index: 2;
}

/* animation */
@keyframes spin {
  to { transform: rotate(360deg); }
}

/* ===== BLURRED ARTWORK BACKGROUND ===== */
.bg-artwork {
  position: fixed;
  inset: 0;
  background-image: url('<?= $artwork ?>');
  background-size: cover;
  background-position: center;
  filter: blur(60px);
  transform: scale(1.2);
  z-index: -2;
}

/* dark overlay for readability */
.bg-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.6);
  z-index: -1;
}
</style>
</head>

<body class="">

<div class="bg-artwork"></div>
<div class="bg-overlay"></div>

<!-- MAIN PLAYER (keep your existing UI here) -->
<div class="flex flex-col items-center pt-16 text-center">
  <div>
  <div class="ring-wrapper mx-auto">
  <div id="ring" class="ring"></div>

  <img src="<?= $artwork ?>" 
       class="artwork">
</div>


    <h1 class="mt-6 text-2xl font-semibold tracking-wide">
		  <?= "Test"; ?>
		</h1>
  <p class="text-gray-300 text-sm mt-1">
  <?= "Test" ?>
</p>
  </div>
</div>

<!-- AUDIO -->
<audio id="audio">
  <source src="<?= $audio ?>" type="audio/mpeg">
</audio>

<!-- MINI PLAYER -->
<div class="mini-player">

  <div class="mini-progress" id="miniProgress"></div>

  <div class="mini-left">
    <img src="<?= $artwork ?>" class="mini-art">

    <div class="mini-info">
      <div class="mini-title"><?= "Test" ?></div>
      <div class="mini-artist"><?= "Test" ?></div>
    </div>
  </div>

  <button id="miniPlay" class="mini-btn">

    <!-- PLAY -->
    <svg id="miniPlayIcon" viewBox="0 0 24 24" width="20" height="20">
      <path d="M8 5v14l11-7z" fill="black"/>
    </svg>

    <!-- PAUSE -->
    <svg id="miniPauseIcon" viewBox="0 0 24 24" width="20" height="20" class="hidden">
      <path d="M6 5h4v14H6zm8 0h4v14h-4z" fill="black"/>
    </svg>

  </button>

</div>
<script>
document.addEventListener('contextmenu', e => e.preventDefault());
</script>
<script>
	
	const ring = document.getElementById("ring");
const audio = document.getElementById("audio");

/* MINI PLAYER ELEMENTS */
const miniPlay = document.getElementById("miniPlay");
const miniPlayIcon = document.getElementById("miniPlayIcon");
const miniPauseIcon = document.getElementById("miniPauseIcon");
const miniProgress = document.getElementById("miniProgress");

/* PLAY / PAUSE */
miniPlay.onclick = () => {
	
	if (!audio.src) {
    audio.src = "<?= $audio ?>"; // load only when needed
  }

  if(audio.paused){
    audio.play();

    miniPlayIcon.classList.add("hidden");
    miniPauseIcon.classList.remove("hidden");

    ring.style.animationPlayState = "running"; // START RING

  } else {
    audio.pause();

    miniPlayIcon.classList.remove("hidden");
    miniPauseIcon.classList.add("hidden");

    ring.style.animationPlayState = "paused"; // STOP RING
  }
};
/* PROGRESS */
audio.ontimeupdate = () => {
  const percent = (audio.currentTime / audio.duration) * 100;
  miniProgress.style.width = percent + "%";
};
</script>

</body>
</html>