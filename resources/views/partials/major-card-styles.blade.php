{{-- Warna kartu jurusan: dimuat dari Blade agar aktif setelah git pull tanpa salin ulang public_html/css --}}
<style>
.card.major-card {
    --bs-card-bg: transparent;
    border: 0;
    border-radius: 0.75rem;
    color: #fff;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    box-shadow: 0 0.35rem 1rem rgba(15, 23, 42, 0.12);
}
.card.major-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.65rem 1.35rem rgba(15, 23, 42, 0.18);
}
.card.major-card .major-card__badge {
    background: rgba(255, 255, 255, 0.22);
    color: inherit;
    font-weight: 700;
    letter-spacing: 0.04em;
}
.card.major-card .major-card__title { color: inherit; }
.card.major-card .major-card__text { opacity: 0.88; }
.card.major-card .major-card__btn {
    border-width: 1.5px;
    font-weight: 600;
}
.card.major-card:not(.major-card--ak) .major-card__btn {
    color: #fff;
    border-color: rgba(255, 255, 255, 0.7);
    background: transparent;
}
.card.major-card:not(.major-card--ak) .major-card__btn:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.16);
    border-color: #fff;
}
.card.major-card.major-card--ak .major-card__btn {
    color: #422006;
    border-color: #422006;
    background: rgba(255, 255, 255, 0.35);
}
.card.major-card.major-card--ak .major-card__btn:hover {
    color: #422006;
    background: rgba(255, 255, 255, 0.55);
    border-color: #422006;
}
.card.major-card.major-card--rpl { background: linear-gradient(155deg, #52525b 0%, #3f3f46 55%, #27272a 100%); }
.card.major-card.major-card--rpl .major-card__badge,
.card.major-card.major-card--rpl .major-card__title { color: #f4f4f5; }
.card.major-card.major-card--rpl .major-card__text { color: #d4d4d8; }
.card.major-card.major-card--dkv { background: linear-gradient(155deg, #2563eb 0%, #1d4ed8 55%, #1e3a8a 100%); }
.card.major-card.major-card--dkv .major-card__badge,
.card.major-card.major-card--dkv .major-card__title { color: #eff6ff; }
.card.major-card.major-card--dkv .major-card__text { color: #bfdbfe; }
.card.major-card.major-card--tsm { background: linear-gradient(155deg, #ef4444 0%, #dc2626 55%, #991b1b 100%); }
.card.major-card.major-card--tsm .major-card__badge,
.card.major-card.major-card--tsm .major-card__title { color: #fef2f2; }
.card.major-card.major-card--tsm .major-card__text { color: #fecaca; }
.card.major-card.major-card--titl { background: linear-gradient(155deg, #22c55e 0%, #16a34a 55%, #14532d 100%); }
.card.major-card.major-card--titl .major-card__badge,
.card.major-card.major-card--titl .major-card__title { color: #f0fdf4; }
.card.major-card.major-card--titl .major-card__text { color: #bbf7d0; }
.card.major-card.major-card--ak { background: linear-gradient(155deg, #facc15 0%, #eab308 45%, #a16207 100%); }
.card.major-card.major-card--ak .major-card__badge,
.card.major-card.major-card--ak .major-card__title { color: #422006; }
.card.major-card.major-card--ak .major-card__text { color: #713f12; }
.card.major-card.major-card--default { background: linear-gradient(155deg, #64748b 0%, #475569 100%); color: #f8fafc; }
</style>
