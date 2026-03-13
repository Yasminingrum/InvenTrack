@extends('layouts.app')

@section('title', 'Manajemen User — InvenTrack')

@push('styles')
<style>
    .btn-role {
        border: none; border-radius: 6px; padding: .25rem .6rem;
        font-size: .7rem; font-weight: 700; cursor: pointer;
        font-family: inherit; transition: opacity .15s, transform .1s;
        display: inline-flex; align-items: center; gap: .3rem;
    }
    .btn-role:not([disabled]):hover { opacity: .8; transform: translateY(-1px); }
</style>
@endpush

@section('content')

<div class="card">
    <div class="card-header-custom">
        <h2 class="card-title-custom">
            <i class="bi bi-people-fill me-2" style="color:var(--primary)"></i>
            Manajemen User
        </h2>
        <span style="background:#fef9c3;color:#92400e;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:700">
            <i class="bi bi-shield-fill-check"></i> Super Admin Only
        </span>
    </div>

    <!-- Role Legend -->
    <div style="padding:.85rem 1.5rem;background:#f8fafc;border-bottom:1px solid var(--border);display:flex;flex-wrap:wrap;gap:.75rem;align-items:center">
        <span style="font-size:.75rem;font-weight:700;color:var(--text-muted)">Role:</span>
        <span style="background:#fee2e2;color:#991b1b;padding:.2rem .7rem;border-radius:20px;font-size:.72rem;font-weight:700">
            <i class="bi bi-shield-fill-check"></i> superadmin — Akses penuh + Pengaturan
        </span>
        <span style="background:#dbeafe;color:#1e40af;padding:.2rem .7rem;border-radius:20px;font-size:.72rem;font-weight:700">
            <i class="bi bi-person-gear"></i> admin — CRUD Produk + Dashboard + Laporan
        </span>
        <span style="background:#f1f5f9;color:#475569;padding:.2rem .7rem;border-radius:20px;font-size:.72rem;font-weight:700">
            <i class="bi bi-eye-fill"></i> viewer — Dashboard + Laporan (read-only)
        </span>
    </div>

    <div style="overflow-x:auto">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama / Email</th>
                    <th>Role Saat Ini</th>
                    <th>Terdaftar</th>
                    <th style="text-align:center">Ubah Role</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <tr><td colspan="5">
                    <div class="empty-state">
                        <i class="bi bi-hourglass-split"></i>Memuat data user…
                    </div>
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script type="module">
    import { initializeApp }                 from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getDatabase, ref, get, update } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

    const firebaseConfig = {
        apiKey:            "{{ env('FIREBASE_API_KEY') }}",
        authDomain:        "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        databaseURL:       "{{ env('FIREBASE_DATABASE_URL') }}",
        projectId:         "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket:     "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId:             "{{ env('FIREBASE_APP_ID') }}",
    };

    const app = initializeApp(firebaseConfig);
    const db  = getDatabase(app);

    const CURRENT_UID = "{{ session('firebase_uid') }}";

    const roleColors = {
        superadmin: 'background:#fee2e2;color:#991b1b',
        admin:      'background:#dbeafe;color:#1e40af',
        viewer:     'background:#f1f5f9;color:#475569',
    };
    const roleIcons = {
        superadmin: 'bi-shield-fill-check',
        admin:      'bi-person-gear',
        viewer:     'bi-eye-fill',
    };

    function formatDate(iso) {
        if (!iso) return '—';
        return new Date(iso).toLocaleDateString('id-ID', {
            day: '2-digit', month: 'short', year: 'numeric'
        });
    }

    async function loadUsers() {
        const tbody = document.getElementById('userTableBody');
        try {
            const snap = await get(ref(db, 'users'));
            if (!snap.exists()) {
                tbody.innerHTML = `<tr><td colspan="5">
                    <div class="empty-state"><i class="bi bi-inbox"></i>Belum ada user terdaftar.</div>
                </td></tr>`;
                return;
            }

            const users = snap.val();
            let rows = '';
            let i    = 1;

            for (const [uid, u] of Object.entries(users)) {
                const role   = u.role || 'viewer';
                const isSelf = uid === CURRENT_UID;

                rows += `
                <tr id="row-${uid}">
                    <td style="color:var(--text-muted);font-family:'DM Mono',monospace;font-size:.8rem">${i++}</td>
                    <td>
                        <div style="font-weight:700;font-size:.875rem">${u.display_name || '—'}</div>
                        <div style="font-size:.75rem;color:var(--text-muted);font-family:'DM Mono',monospace">${u.email || '—'}</div>
                        ${isSelf ? '<span style="background:#f0fdf4;color:#15803d;padding:.1rem .5rem;border-radius:20px;font-size:.65rem;font-weight:700;margin-top:.25rem;display:inline-block">Anda</span>' : ''}
                    </td>
                    <td>
                        <span style="padding:.25rem .7rem;border-radius:20px;font-size:.72rem;font-weight:700;${roleColors[role]}">
                            <i class="bi ${roleIcons[role]}"></i> ${role}
                        </span>
                    </td>
                    <td style="font-size:.8rem;color:var(--text-muted)">${formatDate(u.created_at)}</td>
                    <td style="text-align:center">
                        ${isSelf
                            ? '<span style="font-size:.75rem;color:var(--text-muted)">—</span>'
                            : `<div style="display:flex;gap:.4rem;justify-content:center;flex-wrap:wrap">
                                <button onclick="changeRole('${uid}','superadmin')" ${role === 'superadmin' ? 'disabled' : ''} class="btn-role" style="${role === 'superadmin' ? 'opacity:.4;cursor:default;' : ''}background:#fee2e2;color:#991b1b">
                                    <i class="bi bi-shield-fill-check"></i> superadmin
                                </button>
                                <button onclick="changeRole('${uid}','admin')" ${role === 'admin' ? 'disabled' : ''} class="btn-role" style="${role === 'admin' ? 'opacity:.4;cursor:default;' : ''}background:#dbeafe;color:#1e40af">
                                    <i class="bi bi-person-gear"></i> admin
                                </button>
                                <button onclick="changeRole('${uid}','viewer')" ${role === 'viewer' ? 'disabled' : ''} class="btn-role" style="${role === 'viewer' ? 'opacity:.4;cursor:default;' : ''}background:#f1f5f9;color:#475569">
                                    <i class="bi bi-eye-fill"></i> viewer
                                </button>
                               </div>`
                        }
                    </td>
                </tr>`;
            }

            tbody.innerHTML = rows;

        } catch (e) {
            tbody.innerHTML = `<tr><td colspan="5">
                <div class="alert-custom alert-danger-custom" style="margin:1rem">
                    <i class="bi bi-wifi-off"></i> Gagal memuat data user dari Firebase.
                </div>
            </td></tr>`;
            console.error(e);
        }
    }

    window.changeRole = async function(uid, newRole) {
        try {
            showLoading();
            await update(ref(db, `users/${uid}`), { role: newRole });
            hideLoading();
            showToast('success', 'Role diperbarui!', `User berhasil diubah menjadi ${newRole}.`);
            loadUsers();
        } catch (e) {
            hideLoading();
            showToast('danger', 'Gagal mengubah role', 'Periksa koneksi Firebase.');
        }
    };

    loadUsers();
</script>
@endpush
