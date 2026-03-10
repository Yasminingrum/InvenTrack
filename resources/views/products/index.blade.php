@extends('layouts.app')

@section('title', 'Dashboard — InvenTrack')

@section('content')

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statTotal">—</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statValue" style="font-size:1.15rem">—</div>
                <div class="stat-label">Total Nilai (Rp)</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3;color:#ca8a04"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statLow">—</div>
                <div class="stat-label">Stok Menipis</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fdf2f8;color:#9d174d"><i class="bi bi-tags-fill"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statCats">—</div>
                <div class="stat-label">Kategori</div>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header-custom">
        <h2 class="card-title-custom">
            <i class="bi bi-list-ul me-2" style="color:var(--primary)"></i>
            Daftar Produk
        </h2>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <input type="text" class="form-control-custom" id="searchInput"
                   placeholder="&#xF52A; Cari produk..."
                   style="width:200px;font-family:'Plus Jakarta Sans',sans-serif">
            <a href="{{ route('products.create') }}" class="btn-accent">
                <i class="bi bi-plus-lg"></i> Tambah
            </a>
        </div>
    </div>

    <div style="overflow-x:auto">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Supplier</th>
                    <th>Keterangan</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <tr><td colspan="8">
                    <div class="empty-state">
                        <i class="bi bi-hourglass-split"></i>Memuat data…
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <div class="modal-body text-center p-4">
                <div style="width:56px;height:56px;background:#fee2e2;border-radius:14px;display:grid;place-items:center;margin:0 auto 1rem;font-size:1.6rem;color:#dc2626">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <h5 style="font-weight:700;margin-bottom:.4rem">Hapus Produk?</h5>
                <p id="deleteModalName" style="color:var(--text-muted);font-size:.875rem;margin-bottom:1.25rem">
                    Data produk akan dihapus permanen.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn-primary-custom" data-bs-dismiss="modal"
                            style="background:#f1f5f9;color:var(--text-main)">Batal</button>
                    <button class="btn-primary-custom" style="background:#dc2626"
                            id="confirmDeleteBtn">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const FIREBASE_URL = "{{ env('FIREBASE_DATABASE_URL') }}";

    async function fetchProducts() {
        const res = await fetch(`${FIREBASE_URL}/products.json`);
        return await res.json();
    }

    function stockBadge(qty) {
        const q = parseInt(qty) || 0;
        if (q === 0)  return `<span class="badge-stock badge-low">Habis</span>`;
        if (q <= 10)  return `<span class="badge-stock badge-low">Menipis (${q})</span>`;
        if (q <= 30)  return `<span class="badge-stock badge-medium">Sedang (${q})</span>`;
        return `<span class="badge-stock badge-high">Tersedia (${q})</span>`;
    }

    function formatRupiah(n) {
        return new Intl.NumberFormat('id-ID').format(n);
    }

    // Compact format agar tidak overflow stat card
    function compactRupiah(n) {
        if (n >= 1_000_000_000) return (n / 1_000_000_000).toFixed(1).replace('.0','') + ' M';
        if (n >= 1_000_000)     return (n / 1_000_000).toFixed(1).replace('.0','') + ' Jt';
        return formatRupiah(n);
    }

    let allProducts = [];

    async function loadProducts() {
        const tbody = document.getElementById('productTableBody');
        try {
            const data = await fetchProducts();

            if (!data) {
                tbody.innerHTML = `<tr><td colspan="8">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <div style="font-weight:600;margin-bottom:.25rem">Belum ada produk</div>
                        <div style="font-size:.8rem">Klik "Tambah" untuk menambah produk baru</div>
                    </div>
                </td></tr>`;
                updateStats([]);
                return;
            }

            allProducts = Object.entries(data).map(([id, val]) => ({ id, ...val }));
            renderTable(allProducts);
            updateStats(allProducts);

        } catch (e) {
            tbody.innerHTML = `<tr><td colspan="8">
                <div class="alert-custom alert-danger-custom" style="margin:1rem">
                    <i class="bi bi-wifi-off"></i>
                    Gagal memuat data Firebase. Periksa konfigurasi URL database.
                </div>
            </td></tr>`;
        }
    }

    function renderTable(products) {
        const tbody = document.getElementById('productTableBody');
        if (!products.length) {
            tbody.innerHTML = `<tr><td colspan="8">
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <div>Tidak ada produk ditemukan</div>
                </div>
            </td></tr>`;
            return;
        }

        tbody.innerHTML = products.map((p, i) => `
            <tr>
                <td style="color:var(--text-muted);font-family:'DM Mono',monospace;font-size:.8rem">${i + 1}</td>
                <td style="font-weight:600">${escHtml(p.nama_produk)}</td>
                <td><span class="badge-cat">${escHtml(p.kategori)}</span></td>
                <td style="font-family:'DM Mono',monospace;font-size:.82rem">Rp ${formatRupiah(p.harga)}</td>
                <td>${stockBadge(p.stok)}</td>
                <td style="color:var(--text-muted);font-size:.82rem">${escHtml(p.supplier)}</td>
                <td style="color:var(--text-muted);font-size:.8rem;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    ${escHtml(p.keterangan || '-')}
                </td>
                <td>
                    <div class="d-flex gap-1 justify-content-center">
                        <a href="/products/${p.id}" class="btn-icon" style="background:#f0fdf4;color:#16a34a" title="Lihat detail">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="/products/${p.id}/edit" class="btn-icon btn-edit" title="Edit produk">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <button class="btn-icon btn-del" title="Hapus produk"
                                onclick="openDeleteModal('${p.id}', '${escHtml(p.nama_produk)}')">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function updateStats(products) {
        document.getElementById('statTotal').textContent = products.length;

        const totalVal = products.reduce((s, p) => s + (parseInt(p.harga)||0) * (parseInt(p.stok)||0), 0);
        document.getElementById('statValue').textContent = compactRupiah(totalVal);

        document.getElementById('statLow').textContent =
            products.filter(p => (parseInt(p.stok)||0) <= 10).length;

        document.getElementById('statCats').textContent =
            new Set(products.map(p => p.kategori)).size;
    }

    // Search
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        renderTable(allProducts.filter(p =>
            p.nama_produk?.toLowerCase().includes(q) ||
            p.kategori?.toLowerCase().includes(q) ||
            p.supplier?.toLowerCase().includes(q)
        ));
    });

    // Delete
    let pendingDeleteId   = null;
    let pendingDeleteName = '';
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    function openDeleteModal(id, name) {
        pendingDeleteId   = id;
        pendingDeleteName = name;
        document.getElementById('deleteModalName').textContent =
            `"${name}" akan dihapus permanen dan tidak bisa dikembalikan.`;
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
        if (!pendingDeleteId) return;
        showLoading();
        deleteModal.hide();
        const name = pendingDeleteName;
        try {
            const res = await fetch(`${FIREBASE_URL}/products/${pendingDeleteId}.json`, { method: 'DELETE' });
            if (!res.ok) throw new Error();
            await loadProducts();
            showToast('success', 'Produk berhasil dihapus!', `"${name}" telah dihapus dari inventaris.`);
        } catch (e) {
            showToast('danger', 'Gagal menghapus', 'Periksa koneksi Firebase dan coba lagi.');
        } finally {
            hideLoading();
            pendingDeleteId   = null;
            pendingDeleteName = '';
        }
    });

    function escHtml(s) {
        if (!s) return '';
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    loadProducts();
</script>
@endpush
