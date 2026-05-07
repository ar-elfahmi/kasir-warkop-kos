# 🏪 Kasir Warkop Kos

Sistem POS kasir untuk **Warkop Kos** — warung kop sederhana. Mobile-first web app dibangun dengan Laravel + Blade + Tailwind CSS.

## Fitur

| Fitur | Keterangan |
|-------|------------|
| **Auth** | Login username/password, ganti password (Laravel Breeze) |
| **POS Kasir** | Grid menu, filter kategori, pilih variant/ukuran, tambah topping, hitung total otomatis |
| **Checkout** | Bayar Tunai/QRIS, validasi stok, kurangi stok otomatis, cetak struk di layar |
| **Manajemen Menu** | CRUD item, variant (small/jumbo), assign topping ke item |
| **Manajemen Stok** | Lihat stok per variant, restok dengan catatan audit |
| **Laporan** | Filter tanggal, rekap per kategori + item terjual, riwayat transaksi |
| **Dashboard** | Ringkasan penjualan hari ini (total, jumlah transaksi, item terjual) |
| **Responsive** | Bottom nav mobile (5 tab), desktop sidebar |

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.3)
- **Frontend:** Blade + Tailwind CSS + Alpine.js
- **Database:** PostgreSQL (production), SQLite (development/test)
- **Auth:** Laravel Breeze (session-based, username + password)
- **Build:** Vite

## Persyaratan

- PHP 8.3+
- Composer
- Node.js 20+
- SQLite (local) / PostgreSQL (production)

## Instalasi Lokal

```bash
# Clone
git clone https://github.com/ar-elfahmi/kasir-warkop-kos.git
cd kasir-warkop-kos

# Backend
composer install
cp .env.example .env
php artisan key:generate

# Database (SQLite)
touch database/database.sqlite
php artisan migrate --seed

# Frontend
npm install
npm run build

# Jalankan
php artisan serve
```

Buka `http://localhost:8000`.

## Akun Default

| Username | Password |
|----------|----------|
| `kasir` | `kasir123` |

## Menjalankan Test

```bash
php artisan test
# 62 tests, 165 assertions, all green
```

## Deployment ke Railway

1. Push ke GitHub
2. Buka [Railway](https://railway.app) → New Project → Deploy from GitHub
3. Add **PostgreSQL** plugin
4. Set environment variables:
   - `APP_KEY` — hasil dari `php artisan key:generate`
   - `APP_NAME` → `Warkop Kos`
   - `APP_ENV` → `production`
   - `APP_DEBUG` → `false`
   - `DB_CONNECTION` → `pgsql`
5. Railway auto-build + migrate (`php artisan migrate --force`) setiap deploy

## Struktur Database

```
categories → menu_items → variants (size/price/stock)
                         → toppings (many-to-many via menu_item_topping)
transactions → transaction_items → transaction_item_toppings
stock_entries (audit trail restok)
```

## Lisensi

MIT
