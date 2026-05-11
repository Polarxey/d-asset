# D-Asset

Sistem manajemen siklus hidup perangkat telekomunikasi untuk PLN ICON+ Bandung. Dibangun di atas Laravel 12 dengan antarmuka dark theme berbasis Bootstrap 5.

Sistem ini bukan sekadar daftar inventaris. D-Asset dirancang untuk mengontrol pergerakan perangkat secara penuh — dari barang masuk gudang, penerbitan dokumen RMA dan BSTP, hingga perangkat terpasang di lokasi pelanggan — dengan audit trail yang tercatat pada setiap langkahnya.

---

## Teknologi

| Layer | Stack |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Bootstrap 5, Blade Templating, Vanilla JavaScript |
| Database | MySQL 8.0 |
| PDF Generation | DomPDF (barryvdh/laravel-dompdf) |
| Local Server | XAMPP (Apache + MySQL) |
| Code Editor | Visual Studio Code |

---

## Fitur Utama

### Transaksi Masuk
Sistem membagi alur masuk barang menjadi dua jalur yang terpisah:

**Jalur Barang Retur** — untuk perangkat hasil dismantle, ex-proyek, atau barang rusak dari lapangan. Mewajibkan 6 data: ID PA, Tanggal Masuk, Lokasi Asal, Customer Name (CPE), Merk, dan Serial Number. Barang otomatis masuk ke status Standby Masuk.

**Jalur Barang Masuk Baru** — untuk perangkat baru dari pusat. Setelah disubmit, barang langsung berstatus Ready dan kolom lokasi otomatis terisi "Gudang".

### Master Asset
Halaman pusat informasi semua perangkat, tersegmentasi dalam 4 tab terpisah:
- **Standby Masuk** — menampilkan 6 kolom data retur secara lengkap
- **Ready (Gudang)** — stok tersedia, siap dikeluarkan
- **Standby Keluar** — perangkat yang sedang dalam proses keluar
- **Used (Terpasang)** — perangkat yang sudah berada di lokasi pelanggan

Kolom "Tipe" telah dihapus secara permanen dari seluruh sistem.

### Transaksi Keluar
**Individual** — mengeluarkan satu unit perangkat dari gudang untuk satu BSTP langsung.

**Paket** — mengeluarkan beberapa jenis perangkat sekaligus untuk satu proyek. Sistem memvalidasi stok secara otomatis; jika stok kurang dari qty yang diminta, sistem memberikan peringatan dan hanya memproses unit yang tersedia.

### Generate Dokumen
**Generate RMA** — memilih unit dari daftar Standby Masuk. Data terisi otomatis dari input retur awal. Setelah PDF diterbitkan, status perangkat otomatis berpindah dari Standby Masuk ke Ready (Gudang).

**Generate BSTP** — memilih transaksi keluar yang sudah dibuat dan mengunduh dokumen BSTP dalam format PDF standar perusahaan, sesuai format Berita Acara Serah Terima PLN ICON Plus.

### Log Activity
Setiap pergerakan data tercatat secara otomatis: siapa yang melakukan aksi, kapan waktunya, dan apa yang berubah. Tersedia tampilan sebelum dan sesudah perubahan (diff) untuk setiap event edit.

---

## Alur Sistem

```
Jalur Retur:
  Input Barang Retur  -->  [Standby Masuk]  -->  Generate RMA (PDF)  -->  [Ready / Gudang]

Jalur Barang Baru:
  Input Barang Baru  -->  [Ready / Gudang]  (langsung, tanpa proses RMA)

Jalur Keluar Individual:
  Pilih 1 unit dari Ready  -->  Isi detail BSTP  -->  [Used]  -->  Download BSTP (PDF)

Jalur Keluar Paket:
  Pilih beberapa jenis + qty dari Ready  -->  Isi detail BSTP  -->  [Used]  -->  Download BSTP (PDF)
```

---

## Instalasi

### Prasyarat
- PHP >= 8.2 dengan ekstensi: `pdo_mysql`, `mbstring`, `xml`, `gd`
- MySQL 8.0+
- Composer
- Node.js dan NPM
- XAMPP (atau web server lain dengan Apache dan MySQL)

### Langkah Instalasi

**1. Buat database**

Buka phpMyAdmin atau MySQL client, jalankan:
```sql
CREATE DATABASE db_d_asset CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**2. Clone repositori**
```bash
git clone https://github.com/Polarxey/d-asset.git
cd d-asset
```

**3. Install dependencies**
```bash
composer install
npm install
```

**4. Konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
APP_NAME="D-Asset"

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_d_asset
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

**5. Jalankan migration**
```bash
php artisan migrate
```

Untuk mengisi data contoh:
```bash
php artisan db:seed
```

**6. Build aset frontend**
```bash
npm run build
```

**7. Buat folder storage yang diperlukan**
```bash
mkdir storage\framework\views
mkdir storage\framework\cache
mkdir storage\framework\cache\data
mkdir storage\framework\sessions
mkdir storage\logs
```

Atau di Linux/macOS:
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### Akses Aplikasi

Jika menggunakan XAMPP, letakkan folder project di `htdocs` dan akses melalui:
```
http://localhost/d-asset/public
```

---

## Struktur Halaman

| Halaman | URL | Fungsi |
|---|---|---|
| Dashboard | `/` | Monitoring ringkasan stok dan aktivitas terbaru |
| Master Asset | `/assets` | Pusat informasi semua perangkat (4 tab) |
| Barang Retur | `/rma/create` | Input barang dari lapangan |
| Barang Masuk Baru | `/barang-masuk/create` | Input perangkat baru dari pusat |
| Keluar Individual | `/transaksi-keluar/individual` | Keluarkan satu unit perangkat |
| Keluar Paket | `/transaksi-keluar/paket` | Keluarkan beberapa perangkat sekaligus |
| Generate BSTP | `/generate/bstp` | Daftar dan unduh dokumen BSTP |
| Generate RMA | `/generate/rma` | Proses dan unduh dokumen RMA |
| Log Activity | `/log-activity` | Audit trail seluruh aktivitas sistem |

---

## Reset Database

Untuk menghapus semua data dan memulai dari awal:
```bash
php artisan migrate:fresh --seed
```

> Perintah ini akan menghapus seluruh isi database. Lakukan backup terlebih dahulu jika diperlukan.

---

## Struktur Proyek

```
d-asset/
├── app/
│   ├── Http/Controllers/
│   │   ├── AssetController.php
│   │   ├── RmaController.php
│   │   ├── BarangMasukController.php
│   │   ├── TransactionController.php
│   │   ├── BundleController.php
│   │   └── ActivityLogController.php
│   └── Models/
│       ├── Asset.php
│       ├── Bundle.php
│       ├── BundleItem.php
│       ├── Transaction.php
│       ├── TransactionDetail.php
│       ├── TransaksiRma.php
│       └── ActivityLog.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── assets/
│   ├── rma/
│   ├── barang_masuk/
│   ├── transaksi_keluar/
│   ├── generate/
│   ├── pdf/
│   ├── activity_log/
│   └── welcome.blade.php
└── routes/
    └── web.php
```

---

## Dikembangkan oleh

Dzaki MH — Program Magang  
PT PLN Icon Plus, Regional Jawa Barat, Bandung  
2026
