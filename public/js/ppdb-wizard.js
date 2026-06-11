(function () {
    const cfg = window.PPDB_WIZARD || {};
    const form = document.getElementById('ppdbWizardForm');
    if (!form) return;

    let step = 0;
    const total = 10;
    const steps = form.querySelectorAll('.wizard-step');
    const progress = document.getElementById('wizardProgress');
    const statusEl = document.getElementById('autosaveStatus');
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

    function showStep(n) {
        step = Math.max(0, Math.min(total, n));
        steps.forEach(el => {
            el.classList.toggle('d-none', parseInt(el.dataset.step, 10) !== step);
        });
        btnPrev.disabled = step === 0;
        btnNext.classList.toggle('d-none', step === total);
        btnSubmit.classList.toggle('d-none', step !== total);
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
        localStorage.setItem('ppdb_dapodik_draft', JSON.stringify(data));
    }

    function loadLocal() {
        if (cfg.isCorrectionMode) {
            localStorage.removeItem('ppdb_dapodik_draft');
            return;
        }

        const raw = localStorage.getItem('ppdb_dapodik_draft');
        if (!raw) return;
        try {
            const data = JSON.parse(raw);
            const hasServerDraft = Boolean(draftToken.value);

            if (hasServerDraft && data.draft_token && data.draft_token !== draftToken.value) {
                localStorage.removeItem('ppdb_dapodik_draft');
                return;
            }

            Object.keys(data).forEach(k => {
                if (k.startsWith('__')) return;
                if (!hasServerDraft && k !== 'spmb_banten_number' && k !== 'draft_token') return;
                const els = form.querySelectorAll(`[name="${k}"], [name="${k}[]"]`);
                if (!els.length) return;
                if (els[0].type === 'checkbox') {
                    const vals = Array.isArray(data[k]) ? data[k] : [data[k]];
                    els.forEach(el => { el.checked = vals.includes(el.value); });
                } else if (els.length === 1) {
                    if (hasServerDraft && !String(data[k] ?? '').trim() && String(els[0].value ?? '').trim()) {
                        return;
                    }
                    els[0].value = data[k];
                }
            });
            if (hasServerDraft && data.__step) {
                step = parseInt(data.__step, 10) || 0;
            }
        } catch (e) {}
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
                if (statusEl) statusEl.textContent = 'Menyimpan draft ditunda — data aman di browser';
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
                if (statusEl) statusEl.textContent = spmbMsg || errors[0] || 'Data belum dapat disimpan';
                const spmb = document.getElementById('spmb_banten_number');
                if (spmb && spmbMsg) {
                    spmb.classList.add('is-invalid');
                }
                return false;
            }
            if (showMsg && statusEl) statusEl.textContent = 'Gagal menyimpan draft';
            return false;
        } catch (e) {
            if (showMsg && statusEl) statusEl.textContent = 'Offline — draft disimpan lokal';
            saveLocal();
            return step === 0;
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
        window.alert(`${label} wajib diisi sebelum lanjut ke tahap berikutnya.`);
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

    async function checkSpmbAvailable() {
        const input = document.getElementById('spmb_banten_number');
        if (!input || !cfg.checkSpmbUrl) return true;

        if (cfg.isCorrectionMode) {
            input.classList.remove('is-invalid');
            input.parentElement?.querySelector('.spmb-check-error')?.remove();
            return true;
        }

        const number = input.value.trim();
        if (!number) return true;
        if (!/^\d{10}$/.test(number)) {
            input.classList.add('is-invalid');
            let err = input.parentElement.querySelector('.spmb-check-error');
            if (!err) {
                err = document.createElement('div');
                err.className = 'text-danger small spmb-check-error';
                input.parentElement.appendChild(err);
            }
            err.textContent = 'NISN harus 10 digit angka.';
            input.focus();
            return false;
        }

        try {
            const params = new URLSearchParams({
                spmb_banten_number: number,
                draft_token: draftToken?.value || '',
            });
            const res = await fetch(`${cfg.checkSpmbUrl}?${params}`, {
                credentials: 'same-origin',
                headers: { Accept: 'application/json' },
            });
            const json = await res.json();
            if (json.available) {
                input.classList.remove('is-invalid');
                return true;
            }
            input.classList.add('is-invalid');
            input.focus();
            let err = input.parentElement.querySelector('.spmb-check-error');
            if (!err) {
                err = document.createElement('div');
                err.className = 'text-danger small spmb-check-error';
                input.parentElement.appendChild(err);
            }
            err.textContent = json.message || 'Nomor SPMB Banten sudah terdaftar.';
            return false;
        } catch (e) {
            return true;
        }
    }

    btnNext?.addEventListener('click', async () => {
        if (!validateCurrent()) return;
        if (step === 0 && !await checkSpmbAvailable()) return;
        const saved = await saveDraft(false);
        if (!saved) return;
        showStep(step + 1);
    });
    btnSaveDraft?.addEventListener('click', () => saveDraft(true));
    document.getElementById('spmb_banten_number')?.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 10);
        e.target.classList.remove('is-invalid');
        e.target.parentElement.querySelector('.spmb-check-error')?.remove();
    });

    form.addEventListener('input', () => {
        saveLocal();
        clearTimeout(form._autosaveTimer);
        form._autosaveTimer = setTimeout(() => saveDraft(false), 25000);
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
                localStorage.removeItem('ppdb_dapodik_draft');
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

    setInterval(() => {
        refreshCsrfToken().catch(() => {});
    }, 4 * 60 * 1000);

    loadLocal();
    if (cfg.hasValidationErrors) {
        showStep(total);
    } else {
        showStep(step);
    }
})();
