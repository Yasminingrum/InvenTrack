# 🗃️ InvenTrack — Aplikasi Manajemen Inventaris dengan Firebase

Aplikasi **manajemen inventaris toko** berbasis **Laravel** yang menggunakan **Firebase Realtime Database** sebagai backend (BaaS). Dibuat untuk memenuhi tugas implementasi BaaS menggunakan Firebase.

---

## 📋 Fitur Aplikasi

| Fungsi | Deskripsi | Metode Firebase |
|--------|-----------|-----------------|
| **Create** | Tambah produk baru via form HTML | `POST /products.json` |
| **Read**   | Tampil daftar semua produk + statistik | `GET /products.json` |
| **Update** | Edit data produk yang sudah ada | `PATCH /products/{id}.json` |
| **Delete** | Hapus produk dengan konfirmasi modal | `DELETE /products/{id}.json` |

### Data yang Disimpan (6 Field)

| Field | Tipe | Deskripsi |
|-------|------|-----------|
| `nama_produk` | String | Nama produk |
| `kategori` | String | Kategori (Elektronik, Pakaian, dst.) |
| `harga` | Number | Harga dalam Rupiah |
| `stok` | Number | Jumlah stok tersedia |
| `supplier` | String | Nama pemasok/supplier |
| `keterangan` | String | Deskripsi tambahan produk |

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js (opsional, untuk asset)
- Akun Google & project Firebase

---

### Langkah 1 — Clone / Siapkan Project Laravel

```bash
# Buat project Laravel baru
composer create-project laravel/laravel inventrack
cd inventrack

# ATAU jika sudah ada folder ini, salin file-file ke project Laravel Anda
```

### Langkah 2 — Salin File-File Ini

Salin file berikut ke project Laravel Anda:
```
app/Http/Controllers/ProductController.php
resources/views/layouts/app.blade.php
resources/views/products/index.blade.php
resources/views/products/create.blade.php
resources/views/products/edit.blade.php
routes/web.php
```

### Langkah 3 — Konfigurasi Firebase

#### A. Buat Project Firebase
1. Buka [https://console.firebase.google.com](https://console.firebase.google.com)
2. Klik **"Add project"** → Masukkan nama project (misal: `inventrack-db`)
3. Disable Google Analytics jika tidak diperlukan → Klik **"Create project"**

#### B. Aktifkan Realtime Database
1. Di sidebar kiri, pilih **"Build" → "Realtime Database"**
2. Klik **"Create Database"**
3. Pilih lokasi server (pilih **Singapore** untuk latency rendah di Indonesia)
4. Pilih mode **"Start in test mode"** (untuk development)
5. Klik **"Enable"**

#### C. Salin Database URL
Setelah database aktif, URL akan muncul di bagian atas, formatnya:
```
https://inventrack-db-default-rtdb.asia-southeast1.firebasedatabase.app
```
**Salin URL ini!**

#### D. Set Rules (Test Mode)
Di tab **"Rules"**, pastikan rule seperti ini (untuk development):
```json
{
  "rules": {
    ".read": true,
    ".write": true
  }
}
```
> ⚠️ **Catatan Keamanan**: Rule ini hanya untuk pengembangan/demo. Untuk production, gunakan Firebase Authentication + rule yang lebih ketat.

### Langkah 4 — Konfigurasi `.env`

Buka file `.env` di root project Laravel, tambahkan/ubah baris berikut:

```env
FIREBASE_DATABASE_URL=https://YOUR-PROJECT-ID-default-rtdb.asia-southeast1.firebasedatabase.app
```

Ganti `YOUR-PROJECT-ID` dengan ID project Firebase Anda.

### Langkah 5 — Jalankan Aplikasi

```bash
# Generate app key (jika belum)
php artisan key:generate

# Jalankan server development
php artisan serve
```

Buka browser: [http://localhost:8000](http://localhost:8000)

---

## 🖥️ Tampilan Aplikasi

### Dashboard (Read)
- Statistik: Total produk, Total nilai inventaris, Stok menipis, Jumlah kategori
- Tabel produk lengkap dengan badge status stok berwarna
- Fitur pencarian real-time
- Tombol Edit & Hapus per baris

### Form Tambah Produk (Create)
- Form dengan 6 field: nama, kategori (dropdown), harga, stok, supplier, keterangan
- Validasi HTML5
- Feedback sukses/error setelah submit

### Form Edit Produk (Update)
- Auto-load data dari Firebase berdasarkan ID
- Form yang sama dengan tambah produk, data sudah terisi
- Update menggunakan metode PATCH

### Hapus Produk (Delete)
- Modal konfirmasi sebelum menghapus
- Data langsung dihapus dari Firebase

---

## 🏗️ Arsitektur Teknis

```
Browser (User)
     │
     ▼
Laravel (PHP)
  - Routing (web.php)
  - Controller (ProductController)
  - Blade Views (HTML template)
     │
     │  REST API (JavaScript fetch)
     ▼
Firebase Realtime Database
  /products
    /{auto-id}
      nama_produk: "..."
      kategori: "..."
      harga: 0
      stok: 0
      supplier: "..."
      keterangan: "..."
```

**Laravel** berperan sebagai layer presentasi (MVC — View & Controller), sedangkan **Firebase** sebagai database backend (BaaS). Operasi CRUD dilakukan langsung dari browser ke Firebase REST API menggunakan JavaScript `fetch()`.

---

## 📁 Struktur File

```
inventrack/
├── app/
│   └── Http/
│       └── Controllers/
│           └── ProductController.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php          ← Layout utama (sidebar + topbar)
│       └── products/
│           ├── index.blade.php        ← Halaman dashboard + tabel produk
│           ├── create.blade.php       ← Form tambah produk
│           └── edit.blade.php         ← Form edit produk
├── routes/
│   └── web.php                        ← Definisi rute
├── .env                               ← Konfigurasi (termasuk FIREBASE_DATABASE_URL)
└── README.md
```

---

## 🎨 Teknologi yang Digunakan

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| Laravel | 10.x | PHP Framework (Backend/Routing) |
| Bootstrap | 5.3 | CSS Framework (UI) |
| Bootstrap Icons | 1.11 | Icon library |
| Firebase RTDB | - | Database BaaS |
| JavaScript Fetch API | - | CRUD ke Firebase REST API |
| Google Fonts | - | Typography (Plus Jakarta Sans) |

