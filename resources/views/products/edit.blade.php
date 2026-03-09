@extends('layouts.app')

@section('title', 'Edit Produk — InvenTrack')
@section('page-title', 'Edit Produk')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">

        <!-- Breadcrumb -->
        <div style="font-size:.8rem;color:var(--text-muted);margin-bottom:1.25rem">
            <a href="{{ route('products.index') }}" style="color:var(--text-muted);text-decoration:none">Dashboard</a>
            <i class="bi bi-chevron-right mx-1" style="font-size:.65rem"></i>
            <span style="color:var(--text-main);font-weight:600">Edit Produk</span>
        </div>

        <div class="card">
            <div class="card-header-custom">
                <h2 class="card-title-custom">
                    <i class="bi bi-pencil-square me-2" style="color:var(--primary)"></i>
                    Edit Data Produk
                </h2>
                <span id="productIdBadge" style="font-size:.7rem;color:var(--text-muted);font-family:'DM Mono',monospace;background:var(--surface);padding:.2rem .6rem;border-radius:6px;border:1px solid var(--border)">
                    ID: {{ $id }}
                </span>
            </div>

            <div style="padding:1.5rem">

                <!-- Alert area -->
                <div id="alertArea"></div>

                <!-- Loading state -->
                <div id="formLoading" style="text-align:center;padding:2rem;color:var(--text-muted)">
                    <div class="spinner" style="margin:0 auto .75rem;border-top-color:var(--primary);border-color:var(--border);border-top-color:var(--primary)"></div>
                    Memuat data…
                </div>

                <form id="editForm" style="display:none">

                    <div class="row g-3">

                        <!-- Nama Produk -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label-custom">
                                    Nama Produk <span style="color:var(--danger)">*</span>
                                </label>
                                <input type="text" name="nama_produk" id="nama_produk"
                                       class="form-control-custom"
                                       required>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">
                                    Kategori <span style="color:var(--danger)">*</span>
                                </label>
                                <select name="kategori" id="kategori" class="form-control-custom" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Komputer & Laptop">Komputer & Laptop</option>
                                    <option value="Aksesoris">Aksesoris</option>
                                    <option value="Perabot Rumah">Perabot Rumah</option>
                                    <option value="Pakaian">Pakaian</option>
                                    <option value="Makanan & Minuman">Makanan & Minuman</option>
                                    <option value="Kesehatan">Kesehatan</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">
                                    Harga (Rp) <span style="color:var(--danger)">*</span>
                                </label>
                                <div style="position:relative">
                                    <span style="position:absolute;left:.85rem;top:50%;transform:translateY(-50%);font-size:.8rem;color:var(--text-muted);font-weight:600">Rp</span>
                                    <input type="number" name="harga" id="harga"
                                           class="form-control-custom"
                                           style="padding-left:2.5rem"
                                           min="0" required>
                                </div>
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">
                                    Jumlah Stok <span style="color:var(--danger)">*</span>
                                </label>
                                <input type="number" name="stok" id="stok"
                                       class="form-control-custom"
                                       min="0" required>
                            </div>
                        </div>

                        <!-- Supplier -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">
                                    Supplier / Pemasok <span style="color:var(--danger)">*</span>
                                </label>
                                <input type="text" name="supplier" id="supplier"
                                       class="form-control-custom"
                                       required>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label-custom">Keterangan</label>
                                <textarea name="keterangan" id="keterangan"
                                          class="form-control-custom"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div style="display:flex;gap:.75rem;margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--border);flex-wrap:wrap">
                        <button type="submit" class="btn-primary-custom" id="updateBtn">
                            <i class="bi bi-cloud-check-fill"></i>
                            Update
                        </button>
                        <a href="{{ route('products.index') }}" class="btn-primary-custom"
                           style="background:#f1f5f9;color:var(--text-main)">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    const FIREBASE_URL = "{{ env('FIREBASE_DATABASE_URL') }}";
    const PRODUCT_ID   = "{{ $id }}";

    // Load existing data
    async function loadProduct() {
        try {
            const res  = await fetch(`${FIREBASE_URL}/products/${PRODUCT_ID}.json`);
            const data = await res.json();

            if (!data) {
                showAlert('danger', '<i class="bi bi-exclamation-circle-fill"></i> Produk tidak ditemukan.');
                document.getElementById('formLoading').innerHTML = '';
                return;
            }

            // Populate form
            document.getElementById('nama_produk').value = data.nama_produk || '';
            document.getElementById('kategori').value    = data.kategori    || '';
            document.getElementById('harga').value       = data.harga       || '';
            document.getElementById('stok').value        = data.stok        || '';
            document.getElementById('supplier').value    = data.supplier    || '';
            document.getElementById('keterangan').value  = data.keterangan  || '';

            document.getElementById('formLoading').style.display = 'none';
            document.getElementById('editForm').style.display    = 'block';

        } catch (e) {
            showAlert('danger', '<i class="bi bi-wifi-off"></i> Gagal terhubung.');
        }
    }

    // Submit update (PUT)
    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('updateBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner" style="width:16px;height:16px;border-width:2px;border-color:rgba(255,255,255,.3);border-top-color:#fff"></span> Menyimpan...';
        showLoading();

        const payload = {
            nama_produk: document.getElementById('nama_produk').value.trim(),
            kategori:    document.getElementById('kategori').value,
            harga:       parseInt(document.getElementById('harga').value) || 0,
            stok:        parseInt(document.getElementById('stok').value) || 0,
            supplier:    document.getElementById('supplier').value.trim(),
            keterangan:  document.getElementById('keterangan').value.trim(),
            updated_at:  new Date().toISOString(),
        };

        try {
            const res = await fetch(`${FIREBASE_URL}/products/${PRODUCT_ID}.json`, {
                method:  'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify(payload),
            });

            if (!res.ok) throw new Error();

            hideLoading();
            showAlert('success', `<i class="bi bi-check-circle-fill"></i> Produk berhasil diperbarui!`);

        } catch (err) {
            hideLoading();
            showAlert('danger', '<i class="bi bi-exclamation-circle-fill"></i> Gagal memperbarui data.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-cloud-check-fill"></i> Update';
        }
    });

    function showAlert(type, msg) {
        const area = document.getElementById('alertArea');
        area.innerHTML = `<div class="alert-custom alert-${type}-custom">${msg}</div>`;
        if (type === 'success') setTimeout(() => area.innerHTML = '', 5000);
    }

    loadProduct();
</script>
@endpush
