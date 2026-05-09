# D-Asset — Sistem Manajemen Aset PLN ICON+ Bandung

Sistem manajemen siklus hidup perangkat telekomunikasi. Dibangun dengan Laravel 12 + Bootstrap 5.

---

## ⚡ Cara Install (Fresh Install)

### 1. Prasyarat
- PHP >= 8.2 dengan ekstensi: `pdo_mysql`, `mbstring`, `xml`, `gd`
- MySQL 8.0+
- Composer
- Node.js + NPM

### 2. Setup Database
```sql
CREATE DATABASE db_d_asset CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Clone & Install
```bash
# Install dependencies PHP
composer install

# Copy env
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 4. Konfigurasi `.env`
Edit file `.env` sesuai environment kamu:
```
APP_NAME="D-Asset"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_d_asset
DB_USERNAME=root
DB_PASSWORD=your_password

SESSION_DRIVER=file
```

### 5. Migrate & Seed
```bash
# Buat semua tabel (fresh install)
php artisan migrate

# Isi dengan data contoh (opsional)
php artisan db:seed
```

### 6. Install Frontend & Build
```bash
npm install
npm run build
```

### 7. Jalankan
```bash
# Development (semua sekaligus)
composer run dev

# Atau manual
php artisan serve
npm run dev
```

Akses di: **http://localhost:8000**

---

## 🔄 Update dari Versi Sebelumnya

Jika kamu sudah punya database lama dan ingin **RESET BERSIH**:
```bash
php artisan migrate:fresh --seed
```

> ⚠️ Perintah ini akan **menghapus semua data**. Backup dulu jika perlu.

---

## 📁 Struktur Fitur

| Menu | URL | Fungsi |
|---|---|---|
| Dashboard | `/` | Monitoring summary + recent activity |
| Master Asset(s) | `/assets` | 4 tab: Standby Masuk, Ready, Standby Keluar, Used |
| Barang Retur | `/rma/create` | Input retur dari lapangan → Standby Masuk |
| Barang Masuk Baru | `/barang-masuk/create` | Input perangkat baru → langsung Ready |
| Buat Paket | `/bundle/create` | Pilih perangkat Ready → buat paket keluar |
| Daftar Paket | `/bundle` | Kelola semua paket |
| Generate BSTP | `/transactions/create` | Buat dokumen BSTP dari paket → PDF |
| Riwayat BSTP | `/transactions` | Semua BSTP + download PDF |
| Log Activity | `/log-activity` | Audit trail semua perubahan data |

---

## 🔁 Alur Sistem

```
Jalur Retur:
  Input Form Retur → [Standby Masuk] → Generate RMA (PDF) → [Ready / Gudang]

Jalur Barang Baru:
  Input Form Baru → [Ready / Gudang] (langsung)

Jalur Keluar:
  [Ready] → Buat Paket → [Standby Keluar] → Generate BSTP (PDF) → [Used]
```

---

Built with ❤️ by Dzaki MH — PLN ICON+ Bandung, 2026
