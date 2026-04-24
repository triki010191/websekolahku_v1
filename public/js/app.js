(function () {
    // Theme toggle (light/dark)
    const STORAGE_KEY = 's8-theme';
    const html = document.documentElement;
    const btn  = document.getElementById('themeToggle');
    const ico  = document.getElementById('themeIcon');

    function applyTheme(mode) {
        html.setAttribute('data-bs-theme', mode);
        if (ico) ico.className = mode === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
    }

    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) applyTheme(saved);
    else if (window.matchMedia && matchMedia('(prefers-color-scheme: dark)').matches) applyTheme('dark');

    if (btn) {
        btn.addEventListener('click', function () {
            const next = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem(STORAGE_KEY, next);
        });
    }

    // Reveal on scroll
    const io = 'IntersectionObserver' in window ? new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); } });
    }, { threshold: 0.08 }) : null;

    document.querySelectorAll('.reveal').forEach(el => {
        if (io) io.observe(el); else el.classList.add('show');
    });

    // Admin sidebar toggle (mobile)
    const sideBtn = document.getElementById('adminSidebarToggle');
    if (sideBtn) {
        sideBtn.addEventListener('click', () => {
            document.getElementById('adminSidebar')?.classList.toggle('open');
        });
    }
})();
