 <header class="border-b border-zinc-400/30 backdrop-blur-sm sticky top-0 z-50 bg-zinc-300/50">
    <div class="container mx-auto px-6 h-16 flex items-center justify-between">

      <!-- Logo -->
      <a href="<?php echo site_url('Dashboard') ?>" class="flex items-center gap-2">
        <i data-lucide="music" class="w-8 h-8 text-primary"></i>
        <span class="text-2xl font-bold text-black">SoundFlow</span>
      </a>

      <!-- Nav -->
      <nav class="hidden md:flex items-center gap-8 text-sm">
        <a href="<?php echo site_url('Dashboard') ?>" class="hover:text-primary transition-colors text-black">DASHBOARD</a>
		
		<div class="relative group" id="releasesDropdown">

		  <!-- Trigger -->
		  <button  id="releasesBtn" class="flex items-center gap-1 text-black hover:text-primary transition-colors focus:outline-none" >
			MY RELEASES
			<i data-lucide="chevron-down" class="w-4 h-4 text-black/70"></i>
		  </button>

		  <!-- Dropdown -->
		  <div  id="releasesMenu"  class="absolute left-0 mt-3 w-44 bg-[#0f0f0f] border border-border rounded-lg shadow-xl hidden opacity-0 scale-95 transition-all origin-top z-50"  >
			<a href="<?= site_url('my-releases') ?>" class="flex items-center gap-3 px-4 py-2 text-sm text-white hover:bg-white/10 transition">
			  <i data-lucide="music-2" class="w-4 h-4 text-primary"></i>
			  Singles
			</a>

			<a href="<?= site_url('my-albums') ?>" class="flex items-center gap-3 px-4 py-2 text-sm text-white hover:bg-white/10 transition">
			  <i data-lucide="disc-3" class="w-4 h-4 text-primary"></i>
			  Albums
			</a>
		  </div>

		</div>


        <a href="<?= site_url('Sampling') ?>" class="hover:text-primary transition-colors text-black"> SAMPLING </a>
		
        <a href="<?= site_url('my-assets') ?>" class="hover:text-primary transition-colors text-black"> ASSEST LIBRARY</a>
		
        <a href="<?= site_url('analytics') ?>" class="hover:text-primary transition-colors text-black"> ANALYTICS</a>
       <!-- <a href="#" class="hover:text-primary transition-colors text-white">ARTIST SERVICES</a> -->
	   
	    <a href="<?= site_url('profile') ?>" class="hover:text-primary transition-colors text-black"> PROFILE</a>
      </nav>

      <!-- Right Icons -->
      <div class="flex items-center gap-4">

        <a href="<?php echo site_url('upload') ?>"
          class="px-4 py-2 rounded-md bg-gradient-to-r from-[hsl(25,100%,60%)] to-[hsl(350,100%,65%)] hover:opacity-90 font-semibold text-white">
          ADD RELEASE
        </a>


		  
		  <div class="relative" id="profileDropdown">

			  <!-- Profile Button -->
			  <button id="profileBtn"
					  class="p-2 rounded-md hover:bg-white/10 transition flex items-center gap-2">
				<i data-lucide="user" class="w-5 h-5 text-black"></i>
				<i data-lucide="chevron-down" class="w-4 h-4 text-black/70 hidden md:block"></i>
			  </button>

			  <!-- Dropdown -->
			  <div id="profileMenu"
				   class="absolute right-0 mt-2 w-48 bg-[#0f0f0f] border border-border rounded-lg shadow-xl
						  hidden opacity-0 scale-95 transition-all origin-top-right z-50">

				<div class="px-4 py-3 border-b border-border">
				  <p class="text-sm font-semibold text-white">
					<?= html_escape($this->session->userdata('user_name') ?? 'Account'); ?>
				  </p>
				  <p class="text-xs text-muted">
					<?= html_escape($this->session->userdata('user_email') ?? ''); ?>
				  </p>
				</div>
<!--
    <div class="py-2">
      <a href="<?= base_url('profile'); ?>"
         class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-white/10 transition">
        <i data-lucide="user-circle" class="w-4 h-4"></i>
        Profile
      </a>

      <a href="<?= base_url('settings'); ?>"
         class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-white/10 transition">
        <i data-lucide="settings" class="w-4 h-4"></i>
        Settings
      </a>
    </div> -->

    <div class="border-t border-border">
      <form action="<?= base_url('logout'); ?>" method="post">
        <?php
          $csrf_name = $this->security->get_csrf_token_name();
          $csrf_hash = $this->security->get_csrf_hash();
        ?>
        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

        <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-400
                       hover:bg-red-500/10 transition">
          <i data-lucide="log-out" class="w-4 h-4"></i>
          Logout
        </button>
      </form>
    </div>

  </div>
</div>

<script>
const profileBtn = document.getElementById('profileBtn');
const profileMenu = document.getElementById('profileMenu');

profileBtn.addEventListener('click', (e) => {
  e.stopPropagation();
  toggleProfileMenu();
});

document.addEventListener('click', () => {
  closeProfileMenu();
});

function toggleProfileMenu() {
  if (profileMenu.classList.contains('hidden')) {
    profileMenu.classList.remove('hidden');
    setTimeout(() => {
      profileMenu.classList.remove('opacity-0', 'scale-95');
      profileMenu.classList.add('opacity-100', 'scale-100');
    }, 10);
  } else {
    closeProfileMenu();
  }
}

function closeProfileMenu() {
  profileMenu.classList.add('opacity-0', 'scale-95');
  profileMenu.classList.remove('opacity-100', 'scale-100');
  setTimeout(() => profileMenu.classList.add('hidden'), 150);
}
</script>

<script>
const releasesBtn = document.getElementById('releasesBtn');
const releasesMenu = document.getElementById('releasesMenu');
const releasesWrapper = document.getElementById('releasesDropdown');

releasesBtn.addEventListener('click', (e) => {
  e.stopPropagation();
  toggleReleasesMenu();
});

document.addEventListener('click', () => {
  closeReleasesMenu();
});

function toggleReleasesMenu() {
  if (releasesMenu.classList.contains('hidden')) {
    releasesMenu.classList.remove('hidden');
    setTimeout(() => {
      releasesMenu.classList.remove('opacity-0', 'scale-95');
      releasesMenu.classList.add('opacity-100', 'scale-100');
    }, 10);
  } else {
    closeReleasesMenu();
  }
}

function closeReleasesMenu() {
  releasesMenu.classList.add('opacity-0', 'scale-95');
  releasesMenu.classList.remove('opacity-100', 'scale-100');
  setTimeout(() => releasesMenu.classList.add('hidden'), 150);
}


</script>


      </div>
    </div>
  </header>