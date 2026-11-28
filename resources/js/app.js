const sidebarElement = () => document.querySelector('[data-mobile-sidebar]');
const backdropElement = () => document.querySelector('[data-sidebar-backdrop]');
const mainContentElement = () => document.querySelector('[data-main-content]');

let sidebarOpen = false;
const COLLAPSE_STORAGE_KEY = 'smpppln.sidebar.collapsed';

function setSidebar(open) {
    const sidebar = sidebarElement();

    if (!sidebar) {
        return;
    }

    sidebarOpen = open;
    sidebar.classList.toggle('-translate-x-[calc(100%+1.5rem)]', !open);
    sidebar.classList.toggle('translate-x-0', open);
    backdropElement()?.classList.toggle('hidden', !open);

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.setAttribute('aria-expanded', String(open));
    });
}

function applySidebarCollapse(collapsed) {
    const sidebar = sidebarElement();
    const main = mainContentElement();

    if (!sidebar || !main) {
        return;
    }

    sidebar.classList.toggle('lg:w-[220px]', !collapsed);
    sidebar.classList.toggle('w-[220px]', !collapsed);
    sidebar.classList.toggle('lg:w-[72px]', collapsed);

    main.classList.toggle('lg:pl-[248px]', !collapsed);
    main.classList.toggle('lg:pl-[100px]', collapsed);

    sidebar.querySelectorAll('[data-sidebar-text]').forEach((el) => {
        el.classList.toggle('lg:hidden', collapsed);
    });

    const collapseIcon = sidebar.querySelector('[data-collapse-icon]');
    collapseIcon?.classList.toggle('rotate-180', collapsed);
}

function initSidebarCollapse() {
    try {
        const saved = localStorage.getItem(COLLAPSE_STORAGE_KEY);
        if (saved === '1') {
            applySidebarCollapse(true);
        }
    } catch {
        // Abaikan jika localStorage tidak tersedia
    }
}

function switchTab(targetName) {
    document.querySelectorAll('[data-tab-target]').forEach((btn) => {
        const isActive = btn.dataset.tabTarget === targetName;
        btn.setAttribute('aria-selected', String(isActive));
        btn.classList.toggle('bg-[#1A1A1A]', isActive);
        btn.classList.toggle('text-white', isActive);
        btn.classList.toggle('border-[#1A1A1A]', isActive);
        btn.classList.toggle('bg-white', !isActive);
        btn.classList.toggle('text-[#6B6B6B]', !isActive);
        btn.classList.toggle('border-[#EAEAEA]', !isActive);
    });

    document.querySelectorAll('[data-tab-panel]').forEach((panel) => {
        const isMatch = panel.dataset.tabPanel === targetName;
        panel.classList.toggle('hidden', !isMatch);
    });
}

function exportTable(trigger) {
    const table = document.getElementById(trigger.dataset.export);

    if (!table) {
        return;
    }

    const rows = [...table.querySelectorAll('tr')].map((row) =>
        [...row.querySelectorAll('th, td')]
            .map((cell) => {
                const text = cell.innerText.replace(/\s+/g, ' ').trim().replace(/"/g, '""');

                return `"${text}"`;
            })
            .join(','),
    );

    const blob = new Blob(['\uFEFF' + rows.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const stamp = new Date().toISOString().slice(0, 10);

    link.href = URL.createObjectURL(blob);
    link.download = `${trigger.dataset.filename ?? 'laporan'}-${stamp}.csv`;
    document.body.appendChild(link);
    link.click();
    link.remove();
    URL.revokeObjectURL(link.href);
}

function applyPelangganFilters() {
    const searchInput = document.querySelector('[data-pelanggan-search]');
    const wilayahSelect = document.querySelector('[data-pelanggan-wilayah]');
    const garduSelect = document.querySelector('[data-pelanggan-gardu]');
    const rows = document.querySelectorAll('[data-pelanggan-row]');

    if (!rows.length) {
        return;
    }

    const keyword = (searchInput?.value ?? '').toLowerCase().trim();
    const wilayah = wilayahSelect?.value ?? 'semua';
    const gardu = garduSelect?.value ?? 'semua';

    let visible = 0;

    rows.forEach((row) => {
        const matchKeyword = keyword === '' || row.innerText.toLowerCase().includes(keyword);
        const matchWilayah = wilayah === 'semua' || row.dataset.wilayah === wilayah;
        const matchGardu = gardu === 'semua' || row.dataset.gardu === gardu;
        const show = matchKeyword && matchWilayah && matchGardu;

        row.classList.toggle('hidden', !show);

        if (show) {
            visible += 1;
        }
    });

    document.querySelector('[data-pelanggan-empty]')?.classList.toggle('hidden', visible > 0);
}

function formatRupiah(value) {
    return 'Rp' + Number(value || 0).toLocaleString('id-ID');
}

function setDetailStatus(status) {
    const modal = document.querySelector('[data-detail-modal]');

    if (!modal) {
        return;
    }

    const isLunas = status === 'lunas';

    modal.dataset.status = status;

    const badge = modal.querySelector('[data-detail-badge]');
    if (badge) {
        badge.textContent = isLunas ? 'Lunas' : 'Belum Lunas';
        badge.classList.toggle('bg-[#DDF5E6]', isLunas);
        badge.classList.toggle('text-[#22A95B]', isLunas);
        badge.classList.toggle('bg-[#FBE3E1]', !isLunas);
        badge.classList.toggle('text-[#D9453D]', !isLunas);
    }

    const toggle = modal.querySelector('[data-detail-toggle]');
    if (toggle) {
        toggle.textContent = isLunas ? 'Tandai Belum Lunas' : 'Tandai Lunas';
    }
}

function openDetail(trigger) {
    const source = trigger.closest('[data-pelanggan-row], [data-tagihan-row]');
    const modal = document.querySelector('[data-detail-modal]');

    if (!source || !modal) {
        return;
    }

    const data = source.dataset;
    const setText = (selector, value) => {
        const el = modal.querySelector(selector);
        if (el) {
            el.textContent = value;
        }
    };

    modal.dataset.idpel = data.idpel ?? '';

    setText('[data-detail-nama]', data.nama || '-');
    setText('[data-detail-idpel]', data.idpel || '-');
    setText('[data-detail-alamat]', data.alamat || '-');
    setText('[data-detail-tarifdaya]', [data.tarif, data.daya].filter(Boolean).join(' / ') || '-');
    setText('[data-detail-hp]', data.hp || '-');
    setText('[data-detail-promo]', data.promo || '-');
    setText('[data-detail-periode]', data.periode || '-');
    setText('[data-detail-total]', formatRupiah(data.total));
    setText('[data-detail-initial]', (data.nama || 'A').charAt(0).toUpperCase());

    updateDetailMap(modal, data.lat, data.lng);

    setDetailStatus(data.status === 'lunas' ? 'lunas' : 'belum');

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function updateDetailMap(modal, latValue, lngValue) {
    const frame = modal.querySelector('[data-detail-map]');
    const link = modal.querySelector('[data-detail-map-link]');
    const coords = modal.querySelector('[data-detail-coords]');
    const lat = Number(latValue);
    const lng = Number(lngValue);
    const hasCoords = latValue !== '' && lngValue !== '' && Number.isFinite(lat) && Number.isFinite(lng);

    if (!hasCoords) {
        frame?.removeAttribute('src');
        if (coords) {
            coords.textContent = 'Belum tersedia';
        }
        link?.classList.add('hidden');

        return;
    }

    const delta = 0.004;
    const bbox = [lng - delta, lat - delta, lng + delta, lat + delta].join(',');

    if (frame) {
        frame.src = `https://www.openstreetmap.org/export/embed.html?bbox=${bbox}&layer=mapnik&marker=${lat},${lng}`;
    }

    if (coords) {
        coords.textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
    }

    if (link) {
        link.href = `https://www.openstreetmap.org/?mlat=${lat}&mlon=${lng}#map=17/${lat}/${lng}`;
        link.classList.remove('hidden');
    }
}

function closeDetail() {
    document.querySelector('[data-detail-modal]')?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function toggleDetailStatus() {
    const modal = document.querySelector('[data-detail-modal]');

    if (!modal) {
        return;
    }

    const nextStatus = modal.dataset.status === 'lunas' ? 'belum' : 'lunas';
    const idpel = modal.dataset.idpel;
    const isLunas = nextStatus === 'lunas';

    setDetailStatus(nextStatus);

    document.querySelectorAll('[data-tagihan-row]').forEach((row) => {
        if (row.dataset.idpel !== idpel) {
            return;
        }

        row.dataset.status = nextStatus;

        const badge = row.querySelector('[data-status-badge]');
        if (badge) {
            badge.textContent = isLunas ? 'Lunas' : 'Belum';
            badge.classList.toggle('bg-[#DDF5E6]', isLunas);
            badge.classList.toggle('text-[#22A95B]', isLunas);
            badge.classList.toggle('bg-[#FBE3E1]', !isLunas);
            badge.classList.toggle('text-[#D9453D]', !isLunas);
        }
    });

    document.querySelectorAll('[data-pelanggan-row]').forEach((row) => {
        if (row.dataset.idpel === idpel) {
            row.dataset.status = nextStatus;
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initSidebarCollapse();
});

document.addEventListener('click', (event) => {
    if (event.target.closest('[data-sidebar-toggle]')) {
        setSidebar(!sidebarOpen);

        return;
    }

    if (event.target.closest('[data-sidebar-backdrop]')) {
        setSidebar(false);

        return;
    }

    if (event.target.closest('[data-sidebar-collapse]')) {
        const sidebar = sidebarElement();
        const isCurrentlyCollapsed = sidebar?.classList.contains('lg:w-[72px]') ?? false;
        const nextState = !isCurrentlyCollapsed;
        applySidebarCollapse(nextState);
        try {
            localStorage.setItem(COLLAPSE_STORAGE_KEY, nextState ? '1' : '0');
        } catch {
            // Abaikan
        }

        return;
    }

    const tabTrigger = event.target.closest('[data-tab-target]');
    if (tabTrigger) {
        switchTab(tabTrigger.dataset.tabTarget);

        return;
    }

    const filterPill = event.target.closest('[data-filter-pill]');
    if (filterPill) {
        const group = filterPill.closest('[data-filter-group]');
        group?.querySelectorAll('[data-filter-pill]').forEach((pill) => {
            const active = pill === filterPill;
            pill.classList.toggle('bg-[#1A1A1A]', active);
            pill.classList.toggle('text-white', active);
            pill.classList.toggle('border-[#1A1A1A]', active);
            pill.classList.toggle('bg-white', !active);
            pill.classList.toggle('text-[#6B6B6B]', !active);
            pill.classList.toggle('border-[#EAEAEA]', !active);
        });

        return;
    }

    const detailTrigger = event.target.closest('[data-detail-open]');
    if (detailTrigger) {
        openDetail(detailTrigger);

        return;
    }

    if (event.target.closest('[data-detail-close]')) {
        closeDetail();

        return;
    }

    if (event.target.closest('[data-detail-toggle]')) {
        toggleDetailStatus();

        return;
    }

    if (event.target.closest('[data-print]')) {
        window.print();

        return;
    }

    const exportTrigger = event.target.closest('[data-export]');
    if (exportTrigger) {
        exportTable(exportTrigger);
    }
});

document.addEventListener('input', (event) => {
    if (event.target.closest('[data-pelanggan-search]')) {
        applyPelangganFilters();
    }
});

document.addEventListener('change', (event) => {
    if (event.target.closest('[data-pelanggan-wilayah]') || event.target.closest('[data-pelanggan-gardu]')) {
        applyPelangganFilters();

        return;
    }

    const tagihanSelect = event.target.closest('[data-tagihan-status]');
    if (tagihanSelect) {
        const selected = tagihanSelect.value;
        document.querySelectorAll('[data-tagihan-row]').forEach((row) => {
            const match = selected === 'semua' || row.dataset.status === selected;
            row.classList.toggle('hidden', !match);
        });

        return;
    }

    const statusSelect = event.target.closest('[data-laporan-status-filter]');
    if (statusSelect) {
        const selected = statusSelect.value;
        document.querySelectorAll('[data-laporan-row]').forEach((row) => {
            const match = selected === 'semua' || row.dataset.status === selected;
            row.classList.toggle('hidden', !match);
        });
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && sidebarOpen) {
        setSidebar(false);
    }

    if (event.key === 'Escape' && !document.querySelector('[data-detail-modal]')?.classList.contains('hidden')) {
        closeDetail();
    }
});
