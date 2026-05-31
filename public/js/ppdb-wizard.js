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
        if (step === total) buildPreview();
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
        const raw = localStorage.getItem('ppdb_dapodik_draft');
        if (!raw || draftToken.value) return;
        try {
            const data = JSON.parse(raw);
            Object.keys(data).forEach(k => {
                if (k.startsWith('__')) return;
                const els = form.querySelectorAll(`[name="${k}"], [name="${k}[]"]`);
                if (!els.length) return;
                if (els[0].type === 'checkbox') {
                    const vals = Array.isArray(data[k]) ? data[k] : [data[k]];
                    els.forEach(el => { el.checked = vals.includes(el.value); });
                } else if (els.length === 1) {
                    els[0].value = data[k];
                }
            });
            if (data.__step) step = parseInt(data.__step, 10) || 0;
        } catch (e) {}
    }

    async function saveDraft(showMsg = true) {
        try {
            const res = await fetch(cfg.draftUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': cfg.csrf, 'Accept': 'application/json' },
                body: formData(),
            });
            const json = await res.json();
            if (json.ok) {
                draftToken.value = json.draft_token;
                if (localReg) localReg.value = json.registration_number || localReg.value;
                if (statusEl) statusEl.textContent = 'Draft tersimpan ' + new Date().toLocaleTimeString('id-ID');
                saveLocal();
            } else if (showMsg && statusEl) {
                statusEl.textContent = 'Gagal menyimpan draft';
            }
        } catch (e) {
            if (showMsg && statusEl) statusEl.textContent = 'Offline — draft disimpan lokal';
            saveLocal();
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

    function validateCurrent() {
        const current = form.querySelector(`.wizard-step[data-step="${step}"]`);
        if (!current) return true;
        const required = current.querySelectorAll('[required]');
        for (const el of required) {
            if (!el.value.trim()) {
                el.focus();
                el.classList.add('is-invalid');
                return false;
            }
            el.classList.remove('is-invalid');
        }
        return true;
    }

    btnPrev?.addEventListener('click', () => showStep(step - 1));
    btnNext?.addEventListener('click', () => {
        if (!validateCurrent()) return;
        saveDraft(false);
        showStep(step + 1);
    });
    btnSaveDraft?.addEventListener('click', () => saveDraft(true));
    form.addEventListener('input', () => {
        saveLocal();
        clearTimeout(form._autosaveTimer);
        form._autosaveTimer = setTimeout(() => saveDraft(false), 8000);
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

    loadLocal();
    showStep(step);
})();
