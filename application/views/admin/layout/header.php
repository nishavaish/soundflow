<header class="h-16 bg-black border-b border-border flex items-center justify-between px-6">

  <h1 class="text-lg font-semibold text-white">
    <?= $title ?? 'Admin' ?>
  </h1>

  <!-- Right -->
  <div class="relative" id="adminProfile">

    <button id="adminProfileBtn"
            class="flex items-center gap-2 p-2 rounded hover:bg-white/10 transition">
      <i data-lucide="user" class="w-5 h-5"></i>
      <span class="text-sm hidden md:block">
        <?= html_escape($this->session->userdata('admin_name')) ?>
      </span>
      <i data-lucide="chevron-down" class="w-4 h-4 opacity-70"></i>
    </button>

    <!-- Dropdown -->
    <div id="adminProfileMenu"
         class="absolute right-0 mt-2 w-40 bg-[#0f0f0f] border border-border
                rounded-lg shadow-xl hidden opacity-0 scale-95 transition-all z-50">

      <form action="<?= site_url('admin/logout') ?>" method="post">
	   <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <button class="w-full text-left px-4 py-2 text-sm text-red-400
                       hover:bg-red-500/10 flex items-center gap-2">
          <i data-lucide="log-out"></i> Logout
        </button>
      </form>

    </div>
  </div>
</header>
