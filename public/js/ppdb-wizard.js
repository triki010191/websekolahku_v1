(function () {
    const cfg = window.PPDB_WIZARD || {};
    const form = document.getElementById('ppdbWizardForm');
    if (!form) return;

    const STORAGE_KEY = 'ppdb_dapodik_draft';
    let step = 0;
    const total = 10;
    const steps = form.querySelectorAll('.wizard-step');
    const progress = document.getElementById('wizardProgress');
    const statusEl = document.getElementById('autosaveStatus');
    const stepWarning = document.getElementById('stepWarning');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnSaveDraft = document.getElementById('btnSaveDraft');
    const draftToken = document.getElementById('draft_token');
    const localReg = document.getElementById('local_reg_number');
    const previewContent = document.getElementById('previewContent');

    function updateCsrf(token) {
        if (!token) return;
        cfg.csrf = token;
        const input = form.querySelector('input[name="_token"]');
        if (input) input.value = token;
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) meta.content = token;
    }

    async function refreshCsrfToken() {
        if (!cfg.csrfUrl) return cfg.csrf;
        const res = await fetch(cfg.csrfUrl, {
            method: 'GET',
            credentials: 'same-origin',
            headers: { Accept: 'application/json' },
        });
        if (!res.ok) throw new Error('csrf refresh failed');
        const json = await res.json();
        updateCsrf(json.token);
        return json.token;
    }

    function renderProgress() {
        if (!progress) return;
        progress.innerHTML = (cfg.stepLabels || []).map((label, i) => {
            const active = i === step ? 'primary' : (i < step ? 'success' : 'secondary');
            const opacity = i === step ? '' : 'opacity-50';
            return `<span class="badge text-bg-${active} ${opacity}">${i}. ${label}</span>`;
        }).join('');
    }

    function hideStepWarning() {
        if (stepWarning) {
            stepWarning.textContent = '';
            stepWarning.classList.add('d-none');
        }
    }

    function showStep(n) {
        step = Math.max(0, Math.min(total, n));
        steps.forEach(el => {
            el.classList.toggle('d-none', parseInt(el.dataset.step, 10) !== step);
        });
        btnPrev.disabled = step === 0;
        btnNext.classList.toggle('d-none', step === total);
        btnSubmit.classList.toggle('d-none', step !== total);
        hideStepWarning();
        if (step === total) {
            buildPreview();
            refreshCsrfToken().catch(() => {});
        }
        renderProgress();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        saveLocal();
    }

    function formData() {
        return new FormData(form);
    }

    function saveLocal() {
        const data = {};
        new FormData(form).forEach((v, k) => {
            if (k.endsWith('[]')) {
                const key = k.slice(0, -2);
                data[key] = data[key] || [];
                data[key].push(v);
            } else {
                data[k] = v;
            }
        });
        data.__step = step;
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        } catch (e) {}
    }

    function readLocal() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
        } catch (e) {
            return null;
        }
    }

    function clearLocal() {
        try {
            localStorage.removeItem(STORAGE_KEY);
        } catch (e) {}
    }

    function hasMeaningfulData(data) {
        if (!data) return false;
        return Object.keys(data).some(k => {
            if (k.startsWith('__') || k === '_token' || k === 'draft_token') return false;
            const v = data[k];
            return Array.isArray(v) ? v.length > 0 : String(v ?? '').trim() !== '';
        });
    }

    // Isi field formulir dari objek data. skipEmptyOverServer: jangan timpa nilai server yang sudah terisi dengan nilai kosong lokal.
    function applyData(data, opts) {
        opts = opts || {};
        const skipEmptyOverServer = opts.skipEmptyOverServer || false;
        Object.keys(data).forEach(k => {
            if (k.startsWith('__') || k === '_token') return;
            const els = form.querySelectorAll(`[name="${k}"], [name="${k}[]"]`);
            if (!els.length) return;
            if (els[0].type === 'checkbox') {
                const vals = Array.isArray(data[k]) ? data[k] : [data[k]];
                els.forEach(el => { el.checked = vals.includes(el.value); });
            } else if (els[0].type === 'radio') {
                els.forEach(el => { el.checked = el.value === data[k]; });
            } else if (els.length === 1) {
                if (skipEmptyOverServer && !String(data[k] ?? '').trim() && String(els[0].value ?? '').trim()) {
                    return;
                }
                els[0].value = data[k];
            }
        });
    }

    async function saveDraft(showMsg = true, retried = false) {
        try {
            const res = await fetch(cfg.draftUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': cfg.csrf, Accept: 'application/json' },
                body: formData(),
            });
            if (res.status === 419 && !retried) {
                await refreshCsrfToken();
                return saveDraft(showMsg, true);
            }
            if (res.status === 429) {
                if (statusEl) statusEl.textContent = 'Menyimpan draft ditunda — data aman di perangkat ini';
                saveLocal();
                return true;
            }
            if (res.status === 403) {
                const json403 = await res.json().catch(() => ({}));
                if (statusEl) statusEl.textContent = json403.message || 'Pendaftaran formulir ditutup';
                return false;
            }
            const json = await res.json().catch(() => ({}));
            if (json.ok) {
                if (json.csrf_token) updateCsrf(json.csrf_token);
                draftToken.value = json.draft_token;
                if (localReg) localReg.value = json.registration_number || localReg.value;
                if (statusEl) statusEl.textContent = 'Draft tersimpan ' + new Date().toLocaleTimeString('id-ID');
                saveLocal();
                return true;
            }
            if (res.status === 422) {
                const errors = flattenErrors(json.errors);
                const spmbMsg = errors.find(m => /SPMB|NISN/i.test(m));
                if (statusEl) statusEl.textContent = spmbMsg || errors[0] || 'Sebagian data belum valid (cek saat kirim)';
                const spmb = document.getElementById('spmb_banten_number');
                if (spmb && spmbMsg) {
                    spmb.classList.add('is-invalid');
                }
                return false;
            }
            if (showMsg && statusEl) statusEl.textContent = 'Draft belum tersimpan ke server — data aman di perangkat ini';
            saveLocal();
            return false;
        } catch (e) {
            if (showMsg && statusEl) statusEl.textContent = 'Offline — draft disimpan di perangkat ini';
            saveLocal();
            return false;
        }
    }

    function buildPreview() {
        const fd = formData();
        const lines = [];
        fd.forEach((v, k) => {
            if (!v || k === '_token' || k === 'draft_token') return;
            if (k === 'data_declaration') return;
            lines.push(`<div><strong>${k.replace(/_/g, ' ')}:</strong> ${escapeHtml(String(v))}</div>`);
        });
        previewContent.innerHTML = lines.join('') || '<em>Tidak ada data</em>';
    }

    function escapeHtml(s) {
        return s.replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    }

    function fieldLabel(el) {
        const wrap = el.closest('.col-12, [class*="col-md-"], [class*="col-lg-"]');
        const label = wrap?.querySelector('.form-label')?.textContent || el.name || 'Field ini';
        return label.replace(/\s*\*\s*$/, '').trim();
    }

    function showRequiredWarning(label) {
        const msg = `${label} wajib diisi sebelum lanjut ke tahap berikutnya.`;
        if (stepWarning) {
            stepWarning.textContent = msg;
            stepWarning.classList.remove('d-none');
            stepWarning.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            window.alert(msg);
        }
    }

    function markInvalid(el) {
        el.focus();
        el.classList.add('is-invalid');
    }

    function validateCurrent() {
        const current = form.querySelector(`.wizard-step[data-step="${step}"]`);
        if (!current) return true;
        const required = current.querySelectorAll('[required]');
        for (const el of required) {
            if (!el.value.trim()) {
                markInvalid(el);
                showRequiredWarning(fieldLabel(el));
                return false;
            }
            el.classList.remove('is-invalid');
        }
        const conditionalRequired = current.querySelectorAll('[data-required-if]');
        for (const el of conditionalRequired) {
            const [field, expectedValue] = (el.dataset.requiredIf || '').split(':');
            const trigger = field ? form.querySelector(`[name="${field}"]`) : null;
            if (trigger?.value === expectedValue && !el.value.trim()) {
                markInvalid(el);
                showRequiredWarning(fieldLabel(el));
                return false;
            }
            el.classList.remove('is-invalid');
        }
        const requiredGroups = current.querySelectorAll('[data-required-group]');
        for (const group of requiredGroups) {
            const name = group.dataset.requiredGroup;
            const checked = name ? group.querySelectorAll(`[name="${name}"]:checked`).length : 0;
            if (!checked) {
                const first = name ? group.querySelector(`[name="${name}"]`) : null;
                first?.focus();
                group.classList.add('border', 'border-danger', 'rounded', 'p-2');
                showRequiredWarning(group.dataset.requiredLabel || 'Pilihan ini');
                return false;
            }
            group.classList.remove('border', 'border-danger', 'rounded', 'p-2');
        }
        return true;
    }

    btnPrev?.addEventListener('click', () => showStep(step - 1));

    function setSpmbStatus(type, msg) {
        const el = document.getElementById('spmbCheckStatus');
        if (!el) return;
        if (!msg) {
            el.classList.add('d-none');
            el.innerHTML = '';
            return;
        }
        const color = type === 'success' ? 'text-success'
            : type === 'error' ? 'text-danger'
            : 'text-primary';
        const icon = type === 'checking'
            ? '<span class="spinner-border spinner-border-sm me-1" style="width:.85rem;height:.85rem"></span>'
            : type === 'success' ? '<i class="bi bi-check-circle-fill me-1"></i>'
            : type === 'error' ? '<i class="bi bi-exclamation-triangle-fill me-1"></i>'
            : '<i class="bi bi-info-circle me-1"></i>';
        el.className = 'small mt-1 fw-semibold ' + color;
        el.innerHTML = icon + escapeHtml(msg);
        el.classList.remove('d-none');
    }

    function setBtnLoading(btn, loading, loadingHtml) {
        if (!btn) return;
        if (loading) {
            if (btn.dataset.originalHtml === undefined) btn.dataset.originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = loadingHtml;
        } else {
            btn.disabled = false;
            if (btn.dataset.originalHtml !== undefined) {
                btn.innerHTML = btn.dataset.originalHtml;
                delete btn.dataset.originalHtml;
            }
        }
    }

    async function checkSpmbAvailable() {
        const input = document.getElementById('spmb_banten_number');
        if (!input || !cfg.checkSpmbUrl) return true;

        if (cfg.isCorrectionMode) {
            input.classList.remove('is-invalid');
            setSpmbStatus(null, '');
            return true;
        }

        const number = input.value.trim();
        if (!number) return true;
        if (!/^\d{10}$/.test(number)) {
            input.classList.add('is-invalid');
            setSpmbStatus('error', 'NISN harus 10 digit angka.');
            input.focus();
            return false;
        }

        setSpmbStatus('checking', 'Memeriksa ketersediaan NISN ke server, mohon tunggu...');

        const controller = new AbortController();
        const timer = setTimeout(() => controller.abort(), 15000);
        try {
            const params = new URLSearchParams({
                spmb_banten_number: number,
                draft_token: draftToken?.value || '',
            });
            const res = await fetch(`${cfg.checkSpmbUrl}?${params}`, {
                credentials: 'same-origin',
                headers: { Accept: 'application/json' },
                signal: controller.signal,
            });
            clearTimeout(timer);
            const json = await res.json().catch(() => ({}));
            if (json.available) {
                input.classList.remove('is-invalid');
                setSpmbStatus('success', 'NISN tersedia. Melanjutkan ke tahap berikutnya...');
                return true;
            }
            input.classList.add('is-invalid');
            input.focus();
            setSpmbStatus('error', json.message || 'Nomor NISN ini sudah terdaftar. Gunakan menu Cek Formulir bila ingin perbaikan.');
            return false;
        } catch (e) {
            clearTimeout(timer);
            // Timeout/jaringan: jangan blokir user. Validasi final tetap dilakukan server saat kirim.
            setSpmbStatus('info', 'Server lambat merespons. Anda tetap dapat melanjutkan — NISN akan dicek ulang saat formulir dikirim.');
            return true;
        }
    }

    // Navigasi TIDAK pernah diblokir oleh kegagalan simpan draft.
    // Draft disimpan di latar belakang; data juga selalu aman di perangkat (localStorage).
    btnNext?.addEventListener('click', async () => {
        hideStepWarning();
        if (!validateCurrent()) return;

        if (step === 0) {
            setBtnLoading(btnNext, true, '<span class="spinner-border spinner-border-sm me-1"></span> Memeriksa NISN...');
            let ok = false;
            try {
                ok = await checkSpmbAvailable();
            } finally {
                setBtnLoading(btnNext, false);
            }
            if (!ok) return;
            showStep(step + 1);
            saveDraft(false).catch(() => {});
            return;
        }

        btnNext.disabled = true;
        try {
            showStep(step + 1);
            saveDraft(false).catch(() => {});
        } finally {
            btnNext.disabled = false;
        }
    });

    btnSaveDraft?.addEventListener('click', () => saveDraft(true));

    document.getElementById('spmb_banten_number')?.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 10);
        e.target.classList.remove('is-invalid');
        setSpmbStatus(null, '');
    });

    form.addEventListener('input', () => {
        hideStepWarning();
        saveLocal();
        clearTimeout(form._autosaveTimer);
        form._autosaveTimer = setTimeout(() => saveDraft(false).catch(() => {}), 25000);
    });

    document.getElementById('addAchievement')?.addEventListener('click', () => {
        const wrap = document.getElementById('achievementsWrap');
        const i = wrap.querySelectorAll('.achievement-row').length;
        const div = document.createElement('div');
        div.className = 'achievement-row border rounded p-3 mb-2';
        div.innerHTML = `
            <div class="row g-2">
                <div class="col-md-4"><label class="form-label">Jenis</label><select name="achievements[${i}][type]" class="form-select"><option value="">—</option>${(cfg.achievementTypes||[]).map(t=>`<option value="${t}">${t}</option>`).join('')}</select></div>
                <div class="col-md-4"><label class="form-label">Tingkat</label><select name="achievements[${i}][level]" class="form-select"><option value="">—</option>${(cfg.achievementLevels||[]).map(t=>`<option value="${t}">${t}</option>`).join('')}</select></div>
                <div class="col-md-4"><label class="form-label">Tahun</label><input type="number" class="form-control" name="achievements[${i}][year]"></div>
                <div class="col-md-6"><label class="form-label">Nama Prestasi</label><input class="form-control" name="achievements[${i}][name]"></div>
                <div class="col-md-4"><label class="form-label">Penyelenggara</label><input class="form-control" name="achievements[${i}][organizer]"></div>
                <div class="col-md-2"><label class="form-label">Peringkat</label><input class="form-control" name="achievements[${i}][rank]"></div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2 btn-remove-row">Hapus</button>`;
        wrap.appendChild(div);
    });

    document.getElementById('addScholarship')?.addEventListener('click', () => {
        const wrap = document.getElementById('scholarshipsWrap');
        const i = wrap.querySelectorAll('.scholarship-row').length;
        const div = document.createElement('div');
        div.className = 'scholarship-row border rounded p-3 mb-2';
        div.innerHTML = `
            <div class="row g-2">
                <div class="col-md-4"><label class="form-label">Jenis Beasiswa</label><select name="scholarships[${i}][type]" class="form-select"><option value="">—</option>${(cfg.scholarshipTypes||[]).map(t=>`<option value="${t}">${t}</option>`).join('')}</select></div>
                <div class="col-md-8"><label class="form-label">Keterangan</label><input class="form-control" name="scholarships[${i}][description]"></div>
                <div class="col-md-3"><label class="form-label">Tahun Mulai</label><input type="number" class="form-control" name="scholarships[${i}][year_start]"></div>
                <div class="col-md-3"><label class="form-label">Tahun Selesai</label><input type="number" class="form-control" name="scholarships[${i}][year_end]"></div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2 btn-remove-row">Hapus</button>`;
        wrap.appendChild(div);
    });

    form.addEventListener('click', e => {
        if (e.target.classList.contains('btn-remove-row')) {
            e.target.closest('.achievement-row, .scholarship-row')?.remove();
        }
    });

    function showSubmitErrors(messages) {
        const box = document.getElementById('submitErrors');
        if (!box || !messages.length) return;
        box.innerHTML = '<strong>Formulir belum dapat dikirim.</strong><ul class="mb-0 mt-2 small">' +
            messages.map(m => `<li>${escapeHtml(m)}</li>`).join('') + '</ul>';
        box.classList.remove('d-none');
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function flattenErrors(errors) {
        return Object.values(errors || {}).flatMap(v => Array.isArray(v) ? v : [v]);
    }

    async function submitForm() {
        const decl = form.querySelector('[name="data_declaration"]');
        if (decl && !decl.checked) {
            decl.focus();
            decl.classList.add('is-invalid');
            showSubmitErrors(['Anda harus menyetujui pernyataan kebenaran data.']);
            showStep(total);
            return;
        }

        if (!btnSubmit) return;
        btnSubmit.disabled = true;
        const originalHtml = btnSubmit.innerHTML;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
        document.getElementById('submitErrors')?.classList.add('d-none');

        try {
            await refreshCsrfToken();

            let res = await fetch(cfg.storeUrl || form.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': cfg.csrf,
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData(),
            });

            if (res.status === 419) {
                await refreshCsrfToken();
                res = await fetch(cfg.storeUrl || form.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': cfg.csrf,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData(),
                });
            }

            const json = await res.json().catch(() => ({}));

            if (res.ok && json.redirect) {
                clearLocal();
                window.location.href = json.redirect;
                return;
            }

            if (res.status === 422) {
                const messages = flattenErrors(json.errors);
                showSubmitErrors(messages.length ? messages : ['Periksa kembali data wajib (*) pada setiap langkah.']);
                showStep(total);
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalHtml;
                return;
            }

            if (res.status === 429) {
                showSubmitErrors([json.message || 'Terlalu banyak percobaan kirim. Tunggu 1 menit lalu tekan Kirim Formulir sekali lagi.']);
                showStep(total);
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalHtml;
                return;
            }

            if (res.status === 403) {
                showSubmitErrors([json.message || 'Pendaftaran formulir Dapodik sedang ditutup.']);
                showStep(total);
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalHtml;
                return;
            }

            showSubmitErrors([json.message || 'Gagal mengirim formulir. Coba lagi atau muat ulang halaman.']);
            showStep(total);
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalHtml;
        } catch (err) {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalHtml;
            showSubmitErrors(['Koneksi bermasalah. Periksa internet lalu coba kirim lagi.']);
            showStep(total);
        }
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        submitForm();
    });

    // Tombol "Mulai Formulir Baru" — bersihkan cache perangkat & buka formulir kosong (untuk isi siswa lain).
    document.getElementById('btnResetForm')?.addEventListener('click', () => {
        if (!window.confirm('Mulai formulir baru? Isian yang belum dikirim di perangkat ini akan dihapus.')) return;
        clearLocal();
        window.location.href = cfg.createUrl || form.action;
    });

    function setupRestoreBanner(data) {
        const banner = document.getElementById('restoreBanner');
        if (!banner) return;
        banner.classList.remove('d-none');
        document.getElementById('btnRestoreYes')?.addEventListener('click', () => {
            applyData(data);
            banner.classList.add('d-none');
            const targetStep = parseInt(data.__step, 10);
            showStep(Number.isFinite(targetStep) ? targetStep : 0);
        });
        document.getElementById('btnRestoreNo')?.addEventListener('click', () => {
            clearLocal();
            banner.classList.add('d-none');
        });
    }

    setInterval(() => {
        refreshCsrfToken().catch(() => {});
    }, 4 * 60 * 1000);

    function init() {
        const stored = readLocal();

        // Mode perbaikan (revisi): data dari server adalah sumber kebenaran.
        if (cfg.isCorrectionMode) {
            clearLocal();
            return finishInit();
        }

        const hasServerDraft = Boolean(draftToken.value);

        if (hasServerDraft) {
            // Melanjutkan draft server: pulihkan lokal hanya jika token-nya sama.
            if (stored && stored.draft_token && stored.draft_token === draftToken.value) {
                applyData(stored, { skipEmptyOverServer: true });
                const s = parseInt(stored.__step, 10);
                if (Number.isFinite(s)) step = s;
            } else if (stored) {
                clearLocal();
            }
            return finishInit();
        }

        // Formulir baru: jangan timpa diam-diam (cegah tercampur data siswa lain).
        // Tawarkan pemulihan eksplisit jika ada isian lama yang belum dikirim.
        if (hasMeaningfulData(stored)) {
            setupRestoreBanner(stored);
        }
        return finishInit();
    }

    function finishInit() {
        if (cfg.hasValidationErrors) {
            showStep(total);
        } else {
            showStep(step);
        }
    }

    init();
})();
