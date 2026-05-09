# Kasir Warkop Kos - Context

## Domain Language

| Term | Definition |
|------|------------|
| Warkop Kos | Nama warung kopi (bukan kosan, hanya nama warung) |
| Kasir | User tunggal yang menjalankan sistem (pemilik warung) |
| Kategori | Pengelompokan menu: Minuman, Makanan, Rokok |
| Menu Item | Satu produk (kopi, mie, rokok, dll) |
| Variant | Varian item: ukuran untuk minuman (besar/kecil), single untuk makanan/rokok. Stok di level menu item (shared antar variant) |
| Topping | Tambahan untuk makanan, menambah harga, bisa multiple |
| Transaksi | Pencatatan penjualan: pilih menu → qty → topping → bayar |
| Stok | Jumlah barang jadi (finished goods), otomatis berkurang saat transaksi |
| Restock | Input manual penambahan stok (stok masuk) |
| Adjustment | Koreksi stok manual (tambah atau kurangi) dengan catatan alasan |
| Laporan | Rekap penjualan harian per kategori dan item |

## Tech Stack

- **Framework**: Laravel 13.7 (PHP 8.3)
- **Frontend**: Blade + Tailwind CSS
- **Database**: PostgreSQL (deploy Railway)
- **UI Language**: Indonesia
- **Mobile**: Responsive web, bottom navigation mobile
- **Auth**: Laravel Breeze (username + password, session)

## Key Decisions

### Scope
Sistem kasir untuk Warkop Kos (warung kopi). Fitur: POS, manajemen menu, transaksi, stok, laporan.

### Menu Structure
- 3 kategori: Minuman, Makanan, Rokok
- Item punya variants (minuman: besar/kecil dengan harga beda, makanan/rokok: single variant)
- Makanan bisa tambah toppings (multiple, harga tambah)
- Tanpa foto menu

### Transaksi
- Metode bayar: Tunai atau QRIS (satu metode per transaksi)
- QRIS offline (tidak integrasi sistem QRIS, hanya catat)
- Transaksi final (tidak bisa edit/batal)
- Block order kalau stok kurang

### Stok
- Level menu item (bukan per variant). Variant minuman (besar/kecil) share stok.
- Otomatis berkurang saat transaksi
- Manual restock via tabel `stock_entries` (audit trail), update `menu_items.stock`
- Track barang jadi (bukan bahan baku)

### Laporan
- Filter tanggal (default hari ini)
- Rekap per kategori + item terjual
- Tampilan web saja (tanpa export PDF/Excel)

### User & Auth
- Single user (kasir/pemilik)
- Username + password (tanpa email)
- Laravel Breeze, session login
- Bisa ganti password
- Tanpa fitur lupa password

### Mobile UI
- Bottom navigation: POS, Menu, Laporan, Stok, Pengaturan
- POS display: grid card (mudah tap di layar kecil)

### Excluded Features
- Diskon / pajak
- Printer thermal (tampil di layar saja)
- Export laporan
- Multi-user / role
- Foto menu
- Lupa password
