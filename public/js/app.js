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

    // Penghitung karakter untuk input dengan maxlength
    document.querySelectorAll('input[maxlength], textarea[maxlength]').forEach(function (el) {
        const max = parseInt(el.getAttribute('maxlength'), 10);
        if (!max || el.dataset.limitInit) return;
        el.dataset.limitInit = '1';

        let counter = el.parentElement.querySelector('[data-char-counter]');
        if (!counter) {
            counter = document.createElement('div');
            counter.className = 'form-text field-limit-counter text-end';
            counter.dataset.charCounter = '1';
            const formText = el.parentElement.querySelector('.form-text:not([data-char-counter])');
            if (formText) {
                formText.appendChild(document.createTextNode(' '));
                formText.appendChild(counter);
            } else {
                el.insertAdjacentElement('afterend', counter);
            }
        }

        function update() {
            const len = (el.value || '').length;
            counter.textContent = '(' + len + ' / ' + max + ' karakter)';
            counter.classList.toggle('is-near', len >= max * 0.9 && len < max);
            counter.classList.toggle('is-full', len >= max);
        }

        el.addEventListener('input', update);
        update();
    });
})();
