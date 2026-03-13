@extends('layouts.app')

@section('title', 'Laporan Stok — InvenTrack')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="rTotal">—</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2;color:#dc2626"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="rHabis">—</div>
                <div class="stat-label">Stok Habis</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3;color:#ca8a04"><i class="bi bi-arrow-down-circle-fill"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="rLow">—</div>
                <div class="stat-label">Stok Menipis (≤10)</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="rNilai" style="font-size:1.1rem">—</div>
                <div class="stat-label">Total Nilai Inventaris</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Tabel per Kategori -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header-custom">
                <h2 class="card-title-custom">
                    <i class="bi bi-tags-fill me-2" style="color:var(--primary)"></i>
                    Ringkasan per Kategori
                </h2>
            </div>
            <div style="overflow-x:auto">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th style="text-align:right">Produk</th>
                            <th style="text-align:right">Total Stok</th>
                            <th style="text-align:right">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody id="catTableBody">
                        <tr><td colspan="4">
                            <div class="empty-state"><i class="bi bi-hourglass-split"></i>Memuat…</div>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Produk Stok Kritis -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header-custom">
                <h2 class="card-title-custom">
                    <i class="bi bi-exclamation-circle-fill me-2" style="color:#dc2626"></i>
                    Produk Stok Kritis
                </h2>
                <span style="font-size:.75rem;color:var(--text-muted)">Stok ≤ 10</span>
            </div>
            <div style="overflow-x:auto">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th style="text-align:center">Stok</th>
                        </tr>
                    </thead>
                    <tbody id="lowStockBody">
                        <tr><td colspan="3">
                            <div class="empty-state"><i class="bi bi-hourglass-split"></i>Memuat…</div>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const FIREBASE_URL = "{{ env('FIREBASE_DATABASE_URL') }}";

    function formatRupiah(n) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    }
    function compactRupiah(n) {
        if (n >= 1_000_000_000) return (n / 1_000_000_000).toFixed(1).replace('.0','') + ' M';
        if (n >= 1_000_000)     return (n / 1_000_000).toFixed(1).replace('.0','') + ' Jt';
        return new Intl.NumberFormat('id-ID').format(n);
    }

    async function loadReport() {
        try {
            const res  = await fetch(`${FIREBASE_URL}/products.json`);
            const data = await res.json();

            if (!data) {
                document.getElementById('catTableBody').innerHTML  = `<tr><td colspan="4"><div class="empty-state"><i class="bi bi-inbox"></i>Belum ada data.</div></td></tr>`;
                document.getElementById('lowStockBody').innerHTML  = `<tr><td colspan="3"><div class="empty-state"><i class="bi bi-inbox"></i>Belum ada data.</div></td></tr>`;
                ['rTotal','rHabis','rLow','rNilai'].forEach(id => document.getElementById(id).textContent = '0');
                return;
            }

            const products = Object.values(data);

            // Stats
            document.getElementById('rTotal').textContent = products.length;
            document.getElementById('rHabis').textContent = products.filter(p => (parseInt(p.stok)||0) === 0).length;
            document.getElementById('rLow').textContent   = products.filter(p => (parseInt(p.stok)||0) > 0 && (parseInt(p.stok)||0) <= 10).length;
            const totalVal = products.reduce((s,p) => s + (parseInt(p.harga)||0)*(parseInt(p.stok)||0), 0);
            document.getElementById('rNilai').textContent = compactRupiah(totalVal);

            // By Category
            const catMap = {};
            products.forEach(p => {
                const k = p.kategori || 'Lainnya';
                if (!catMap[k]) catMap[k] = { count: 0, stok: 0, nilai: 0 };
                catMap[k].count++;
                catMap[k].stok  += parseInt(p.stok)  || 0;
                catMap[k].nilai += (parseInt(p.harga)||0) * (parseInt(p.stok)||0);
            });
            const sortedCats = Object.entries(catMap).sort((a,b) => b[1].nilai - a[1].nilai);
            document.getElementById('catTableBody').innerHTML = sortedCats.map(([kat, v]) => `
                <tr>
                    <td><span class="badge-cat">${kat}</span></td>
                    <td style="text-align:right;font-family:'DM Mono',monospace;font-size:.82rem">${v.count}</td>
                    <td style="text-align:right;font-family:'DM Mono',monospace;font-size:.82rem">${v.stok}</td>
                    <td style="text-align:right;font-family:'DM Mono',monospace;font-size:.82rem">${compactRupiah(v.nilai)}</td>
                </tr>
            `).join('') || `<tr><td colspan="4"><div class="empty-state"><i class="bi bi-inbox"></i>Tidak ada data.</div></td></tr>`;

            // Low Stock
            const lowStocks = products
                .filter(p => (parseInt(p.stok)||0) <= 10)
                .sort((a,b) => (parseInt(a.stok)||0) - (parseInt(b.stok)||0));

            const badgeCls = qty => qty === 0 ? 'badge-low' : (qty <= 10 ? 'badge-low' : 'badge-medium');
            document.getElementById('lowStockBody').innerHTML = lowStocks.length ? lowStocks.map(p => `
                <tr>
                    <td style="font-weight:600">${p.nama_produk || '—'}</td>
                    <td><span class="badge-cat">${p.kategori || '—'}</span></td>
                    <td style="text-align:center">
                        <span class="badge-stock ${badgeCls(parseInt(p.stok)||0)}">
                            ${parseInt(p.stok) === 0 ? 'Habis' : p.stok}
                        </span>
                    </td>
                </tr>
            `).join('') : `<tr><td colspan="3"><div class="empty-state"><i class="bi bi-check-circle"></i>Semua stok aman!</div></td></tr>`;

        } catch(e) {
            console.error(e);
        }
    }

    loadReport();
</script>
@endpush
