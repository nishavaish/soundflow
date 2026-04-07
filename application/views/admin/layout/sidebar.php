<aside class="w-64 bg-black border-r border-border min-h-screen flex flex-col">

  <!-- Logo -->
  <div class="px-6 py-5 flex items-center gap-2 border-b border-border">
   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="music" class="lucide lucide-music w-8 h-8 text-primary"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
    <span class="text-xl font-bold text-white">SoundFlow </span>
  </div>

  <!-- Nav -->
  <nav class="flex-1 px-4 py-6 space-y-1 text-sm">
    <a href="<?= site_url('admin/dashboard') ?>" class="admin-link">
      <i data-lucide="layout-dashboard"></i> Dashboard
    </a>

    <a href="<?= site_url('admin/users') ?>" class="admin-link">
      <i data-lucide="users"></i> Users
    </a>

    <a href="<?= site_url('admin/releases') ?>" class="admin-link">
      <i data-lucide="music-2"></i> Singles
    </a>

    <a href="<?= site_url('admin/albums') ?>" class="admin-link">
      <i data-lucide="disc-3"></i> Albums
    </a>

  </nav>

  <!-- Footer -->
  <div class="px-4 py-4 border-t border-border text-xs text-muted">
    Admin Panel
  </div>

</aside>

<style>
.admin-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 6px;
  color: white;
  transition: background .2s ease;
}
.admin-link:hover {
  background: rgba(255,255,255,0.08);
}
</style>
