<script src="https://unpkg.com/lucide@latest"></script>
<script>
lucide.createIcons();

/* Admin profile dropdown */
const adminBtn = document.getElementById('adminProfileBtn');
const adminMenu = document.getElementById('adminProfileMenu');

adminBtn?.addEventListener('click', e => {
  e.stopPropagation();
  toggleAdminMenu();
});

document.addEventListener('click', () => closeAdminMenu());

function toggleAdminMenu() {
  if (adminMenu.classList.contains('hidden')) {
    adminMenu.classList.remove('hidden');
    setTimeout(() => {
      adminMenu.classList.remove('opacity-0','scale-95');
      adminMenu.classList.add('opacity-100','scale-100');
    }, 10);
  } else closeAdminMenu();
}

function closeAdminMenu() {
  adminMenu.classList.add('opacity-0','scale-95');
  adminMenu.classList.remove('opacity-100','scale-100');
  setTimeout(() => adminMenu.classList.add('hidden'), 150);
}
</script>
