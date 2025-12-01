(function () {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const toggleDesktop = document.getElementById('sidebarToggleDesktop');

    if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    if (toggleDesktop && sidebar) {
        toggleDesktop.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }
})();
