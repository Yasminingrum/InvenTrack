@extends('layouts.app')

@section('title', 'Detail Produk — InvenTrack')

@section('content')

@php
    $role    = session('firebase_role', 'viewer');
    $canEdit = in_array($role, ['admin', 'superadmin']);
@endphp

<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- Breadcrumb -->
        <div style="font-size:.8rem;color:var(--text-muted);margin-bottom:1.25rem">
            <a href="{{ route('products.index') }}" style="color:var(--text-muted);text-decoration:none">Dashboard</a>
            <i class="bi bi-chevron-right mx-1" style="font-size:.65rem"></i>
            <span style="color:var(--text-main);font-weight:600">Detail Produk</span>
        </div>

        <!-- Loading -->
        <div id="pageLoading" style="text-align:center;padding:3rem;color:var(--text-muted)">
            <div class="spinner" style="margin:0 auto .75rem;border-color:var(--border);border-top-color:var(--primary)"></div>
            Memuat data produk…
        </div>

        <div id="alertArea"></div>

        <div id="pageContent" style="display:none">

            <!-- Header card -->
            <div class="card mb-3">
                <div style="padding:1.5rem;display:flex;align-items:flex-start;gap:1.25rem;flex-wrap:wrap">
                    <div id="productAvatar" style="width:64px;height:64px;border-radius:14px;background:#eff6ff;display:grid;place-items:center;font-size:1.8rem;color:#2563eb;flex-shrink:0">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;margin-bottom:.35rem">
                            <h1 id="productName" style="font-size:1.4rem;font-weight:800;margin:0;color:var(--text-main)">—</h1>
                            <span id="stockBadge">—</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap">
                            <span id="categoryBadge" class="badge-cat">—</span>
                            <span style="font-size:.75rem;color:var(--text-muted);font-family:'DM Mono',monospace" id="productIdLabel">ID: —</span>
                        </div>
                    </div>

                    {{-- Tombol Edit & Hapus: hanya untuk admin & superadmin --}}
                    @if($canEdit)
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                        <a id="btnEdit" href="#" class="btn-primary-custom" style="font-size:.8rem;padding:.45rem .9rem">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <button id="btnDelete" class="btn-primary-custom" style="background:#fef2f2;color:#dc2626;font-size:.8rem;padding:.45rem .9rem">
                            <i class="bi bi-trash3-fill"></i> Hapus
                        </button>
                    </div>
                    @else
                    {{-- Viewer: info badge --}}
                    <div style="display:flex;align-items:center;gap:.4rem;background:#eff6ff;color:#1e40af;padding:.4rem .85rem;border-radius:8px;font-size:.75rem;font-weight:600">
                        <i class="bi bi-eye-fill"></i> Mode Lihat Saja
                    </div>
                    @endif
                </div>
            </div>

            <div class="row g-3">
                <!-- Left: Detail fields -->
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-header-custom">
                            <h2 class="card-title-custom">
                                <i class="bi bi-info-circle-fill me-2" style="color:var(--primary)"></i>
                                Informasi Produk
                            </h2>
                        </div>
                        <div style="padding:1.25rem">
                            <div class="detail-row">
                                <div class="detail-label"><i class="bi bi-tag-fill"></i> Nama Produk</div>
                                <div class="detail-value" id="dNama">—</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label"><i class="bi bi-folder-fill"></i> Kategori</div>
                                <div class="detail-value" id="dKategori">—</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label"><i class="bi bi-currency-dollar"></i> Harga Satuan</div>
                                <div class="detail-value" id="dHarga" style="font-family:'DM Mono',monospace;color:var(--primary);font-weight:700">—</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label"><i class="bi bi-boxes"></i> Jumlah Stok</div>
                                <div class="detail-value" id="dStok">—</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label"><i class="bi bi-truck"></i> Supplier</div>
                                <div class="detail-value" id="dSupplier">—</div>
                            </div>
                            <div class="detail-row" style="border:none;padding-bottom:0">
                                <div class="detail-label"><i class="bi bi-chat-left-text-fill"></i> Keterangan</div>
                                <div class="detail-value" id="dKeterangan" style="color:var(--text-muted)">—</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Stats & timestamps -->
                <div class="col-lg-5">
                    <div class="card mb-3">
                        <div style="padding:1.25rem">
                            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.75rem">
                                <i class="bi bi-calculator-fill me-1"></i> Kalkulasi Nilai
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.65rem">
                                <div style="display:flex;justify-content:space-between;align-items:center">
                                    <span style="font-size:.8rem;color:var(--text-muted)">Harga × Stok</span>
                                    <span id="dNilaiTotal" style="font-size:1.1rem;font-weight:800;color:var(--primary);font-family:'DM Mono',monospace">—</span>
                                </div>
                                <div style="height:1px;background:var(--border)"></div>
                                <div style="display:flex;justify-content:space-between;align-items:center">
                                    <span style="font-size:.8rem;color:var(--text-muted)">Status stok</span>
                                    <span id="dStatusStok">—</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div style="padding:1.25rem">
                            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.75rem">
                                <i class="bi bi-clock-history me-1"></i> Riwayat Waktu
                            </div>
                            <div style="display:flex;flex-direction:column;gap:.6rem">
                                <div>
                                    <div style="font-size:.72rem;color:var(--text-muted);margin-bottom:.15rem">Dibuat</div>
                                    <div id="dCreatedAt" style="font-size:.82rem;font-weight:600;font-family:'DM Mono',monospace">—</div>
                                </div>
                                <div>
                                    <div style="font-size:.72rem;color:var(--text-muted);margin-bottom:.15rem">Diperbarui</div>
                                    <div id="dUpdatedAt" style="font-size:.82rem;font-weight:600;font-family:'DM Mono',monospace">—</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:1.25rem">
                <a href="{{ route('products.index') }}" class="btn-primary-custom" style="background:#f1f5f9;color:var(--text-main)">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

        </div>
    </div>
</div>

{{-- Modal Hapus: hanya render untuk admin & superadmin --}}
@if($canEdit)
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15)">
            <div class="modal-body text-center p-4">
                <div style="width:56px;height:56px;background:#fee2e2;border-radius:14px;display:grid;place-items:center;margin:0 auto 1rem;font-size:1.6rem;color:#dc2626">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <h5 style="font-weight:700;margin-bottom:.4rem">Hapus Produk?</h5>
                <p style="color:var(--text-muted);font-size:.875rem;margin-bottom:1.25rem">
                    Data produk akan dihapus permanen dan tidak bisa dikembalikan.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn-primary-custom" data-bs-dismiss="modal"
                            style="background:#f1f5f9;color:var(--text-main)">Batal</button>
                    <button class="btn-primary-custom" style="background:#dc2626" id="confirmDeleteBtn">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    .detail-row { display:flex; gap:1rem; padding:.7rem 0; border-bottom:1px solid var(--border); align-items:flex-start; }
    .detail-label { width:150px; flex-shrink:0; font-size:.78rem; font-weight:700; color:var(--text-muted); display:flex; align-items:center; gap:.4rem; padding-top:.05rem; }
    .detail-value { flex:1; font-size:.875rem; font-weight:600; color:var(--text-main); word-break:break-word; }
</style>
@endpush

@push('scripts')
<script>
    const FIREBASE_URL = "{{ env('FIREBASE_DATABASE_URL') }}";
    const PRODUCT_ID   = "{{ $id }}";
    const CAN_EDIT     = {{ $canEdit ? 'true' : 'false' }};

    function formatRupiah(n) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(n); }

    function stockBadgeHtml(qty) {
        const q = parseInt(qty) || 0;
        if (q === 0) return `<span class="badge-stock badge-low">Habis</span>`;
        if (q <= 10) return `<span class="badge-stock badge-low">Menipis (${q})</span>`;
        if (q <= 30) return `<span class="badge-stock badge-medium">Sedang (${q})</span>`;
        return `<span class="badge-stock badge-high">Tersedia (${q})</span>`;
    }

    function formatDate(iso) {
        if (!iso) return '—';
        return new Date(iso).toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
    }

    function categoryIcon(kat) {
        const map = {
            'Elektronik':       { icon:'bi-lightning-charge-fill', bg:'#fef9c3', color:'#ca8a04' },
            'Komputer & Laptop':{ icon:'bi-laptop',                bg:'#eff6ff', color:'#2563eb' },
            'Aksesoris':        { icon:'bi-headphones',            bg:'#fdf4ff', color:'#a21caf' },
            'Perabot Rumah':    { icon:'bi-house-fill',            bg:'#f0fdf4', color:'#16a34a' },
            'Pakaian':          { icon:'bi-bag-fill',              bg:'#fff7ed', color:'#ea580c' },
            'Makanan & Minuman':{ icon:'bi-cup-straw',             bg:'#fef2f2', color:'#dc2626' },
            'Kesehatan':        { icon:'bi-heart-pulse-fill',      bg:'#fdf2f8', color:'#9d174d' },
            'Olahraga':         { icon:'bi-trophy-fill',           bg:'#f0fdf4', color:'#15803d' },
        };
        return map[kat] || { icon:'bi-box-seam', bg:'#eff6ff', color:'#2563eb' };
    }

    async function loadProduct() {
        try {
            const res  = await fetch(`${FIREBASE_URL}/products/${PRODUCT_ID}.json`);
            const data = await res.json();

            if (!data) {
                document.getElementById('pageLoading').style.display = 'none';
                document.getElementById('alertArea').innerHTML =
                    `<div class="alert-custom alert-danger-custom"><i class="bi bi-exclamation-circle-fill"></i> Produk tidak ditemukan.</div>`;
                return;
            }

            const cat    = categoryIcon(data.kategori);
            const avatar = document.getElementById('productAvatar');
            avatar.style.background = cat.bg;
            avatar.style.color      = cat.color;
            avatar.innerHTML        = `<i class="bi ${cat.icon}"></i>`;

            document.getElementById('productName').textContent   = data.nama_produk || '—';
            document.getElementById('stockBadge').innerHTML      = stockBadgeHtml(data.stok);
            document.getElementById('categoryBadge').textContent = data.kategori    || '—';
            document.getElementById('productIdLabel').textContent = `ID: ${PRODUCT_ID}`;

            if (CAN_EDIT) {
                document.getElementById('btnEdit').href = `/products/${PRODUCT_ID}/edit`;
            }

            document.getElementById('dNama').textContent       = data.nama_produk  || '—';
            document.getElementById('dKategori').textContent   = data.kategori     || '—';
            document.getElementById('dHarga').textContent      = formatRupiah(data.harga || 0);
            document.getElementById('dStok').innerHTML         = stockBadgeHtml(data.stok);
            document.getElementById('dSupplier').textContent   = data.supplier     || '—';
            document.getElementById('dKeterangan').textContent = data.keterangan   || 'Tidak ada keterangan.';

            const total = (parseInt(data.harga)||0) * (parseInt(data.stok)||0);
            document.getElementById('dNilaiTotal').textContent = formatRupiah(total);
            document.getElementById('dStatusStok').innerHTML   = stockBadgeHtml(data.stok);
            document.getElementById('dCreatedAt').textContent  = formatDate(data.created_at);
            document.getElementById('dUpdatedAt').textContent  = data.updated_at ? formatDate(data.updated_at) : '(belum pernah diubah)';

            document.getElementById('pageLoading').style.display = 'none';
            document.getElementById('pageContent').style.display  = 'block';

        } catch (e) {
            document.getElementById('pageLoading').style.display = 'none';
            document.getElementById('alertArea').innerHTML =
                `<div class="alert-custom alert-danger-custom"><i class="bi bi-wifi-off"></i> Gagal terhubung ke Firebase.</div>`;
        }
    }

    @if($canEdit)
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('btnDelete').addEventListener('click', () => deleteModal.show());
    document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
        showLoading();
        deleteModal.hide();
        try {
            await fetch(`${FIREBASE_URL}/products/${PRODUCT_ID}.json`, { method: 'DELETE' });
            window.location.href = "{{ route('products.index') }}";
        } catch (e) {
            hideLoading();
            showToast('danger', 'Gagal menghapus', 'Periksa koneksi Firebase.');
        }
    });
    @endif

    loadProduct();
</script>
@endpush

@endsection
