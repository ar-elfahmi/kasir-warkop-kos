# PRD - Kasir Warkop Kos

## Problem Statement

Pemilik Warkop Kos butuh sistem kasir sederhana untuk mencatat transaksi penjualan harian (minuman, makanan, rokok), mengelola menu dengan varian dan topping, melacak stok barang jadi, dan melihat laporan penjualan. Sistem harus bisa diakses dari mobile dan desktop.

## Solution

Web app kasir responsif dengan fitur: POS (pilih menu → variant → topping → bayar), manajemen menu (kategori, item, variant, topping), pencatatan stok (otomatis transaksi + manual restock), laporan penjualan harian. Single user (kasir/pemilik) dengan auth sederhana.

## User Stories

1. Sebagai kasir, saya ingin login dengan username dan password, agar sistem aman dan bisa ganti password.

2. Sebagai kasir, saya ingin melihat halaman utama berisi quick POS dan ringkasan penjualan hari ini, agar langsung bisa bertransaksi.

3. Sebagai kasir, saya ingin melihat menu dalam bentuk grid card (mobile-friendly), agar mudah tap saat order.

4. Sebagai kasir, saya ingin memilih kategori (Minuman/Makanan/Rokok) saat order, agar cepat cari menu.

5. Sebagai kasir, saya ingin memilih variant ukuran (besar/kecil) untuk minuman, agar harga sesuai.

6. Sebagai kasir, saya ingin menambah topping ke makanan dengan harga tambahan (bisa multiple), agar order sesuai keinginan pelanggan.

7. Sebagai kasir, saya ingin menginput quantity per item, agar order akurat.

8. Sebagai kasir, saya ingin melihat order summary sebelum bayar, agar bisa cek total.

9. Sebagai kasir, saya ingin memilih metode bayar (Tunai atau QRIS), agar pencatatan akurat.

10. Sebagai kasir, saya ingin menyelesaikan transaksi dan melihat struk di layar, agar ada bukti penjualan.

11. Sebagai kasir, saya ingin transaksi otomatis mengurangi stok variant, agar stok selalu update.

12. Sebagai kasir, saya ingin sistem block order kalau stok kurang, agar tidak over-sell.

13. Sebagai kasir, saya ingin mengelola kategori menu (tambah/edit/hapus), agar menu terorganisir.

14. Sebagai kasir, saya ingin mengelola menu item (nama, deskripsi, kategori), agar data menu lengkap.

15. Sebagai kasir, saya ingin mengelola variant per item (ukuran + harga + stok), agar item punya pilihan harga.

16. Sebagai kasir, saya ingin mengelola toppings (nama + harga), agar makanan bisa ditambah topping.

17. Sebagai kasir, saya ingin mengatur relasi topping ke menu item, agar topping muncul saat order makanan.

18. Sebagai kasir, saya ingin melakukan restock (stok masuk) dengan catatan, agar audit trail jelas.

19. Sebagai kasir, saya ingin melihat riwayat transaksi, agar bisa cek kembali order lalu.

20. Sebagai kasir, saya ingin melihat laporan penjualan dengan filter tanggal, agar bisa cek performa harian/periode.

21. Sebagai kasir, saya ingin laporan menampilkan rekap per kategori (Minuman/Makanan/Rokok), agar tahu kategori terlaris.

22. Sebagai kasir, saya ingin laporan menampilkan item terlaris, agar tahu menu populer.

23. Sebagai kasir, saya ingin navigasi bottom (mobile) atau sidebar (desktop) untuk akses cepat: POS, Menu, Laporan, Stok, Pengaturan.

24. Sebagai kasir, saya ingin mengganti password sendiri di halaman Pengaturan, agar keamanan terjaga.

25. Sebagai kasir, saya ingin semua teks interface dalam Bahasa Indonesia, agar mudah digunakan.

## Implementation Decisions

### Modules to Build

1. **Auth Module** (Laravel Breeze)
   - Username + password (tanpa email)
   - Session-based login
   - Ganti password fitur
   - Skip: lupa password, email verification

2. **Category Module**
   - CRUD kategori (Minuman, Makanan, Rokok)
   - Field: nama kategori

3. **Menu Item Module**
   - CRUD menu item
   - Field: nama, deskripsi, category_id
   - Relasi ke category

4. **Variant Module**
   - Field: menu_item_id, size (nullable), price, stock
   - Minuman: multiple variants (besar/kecil)
   - Makanan/Rokok: single variant (size=null)
   - Unifikasi: semua item punya variant (bukan harga langsung di item)

5. **Topping Module**
   - CRUD topping
   - Field: nama, harga
   - Pivot table ke menu item (many-to-many)
   - Hanya makanan yang punya topping

6. **Transaction Module (POS)**
   - Create transaksi: pilih variant → qty → topping → bayar
   - Field transaksi: tanggal, total, payment_method (tunai/qris)
   - Field transaction_items: transaction_id, variant_id, qty, subtotal
   - Field transaction_item_toppings: transaction_item_id, topping_id
   - Transaksi final (tidak bisa edit/batal)

7. **Stock Module**
   - Auto decrement variant.stock saat transaksi selesai
   - Restock: tabel stock_entries (variant_id, qty, note, tanggal)
   - Auto increment variant.stock saat restock
   - Block order kalau stok < qty order

8. **Report Module**
   - Filter tanggal (default hari ini)
   - Rekap per kategori: total penjualan, qty terjual
   - Rekap per item: total penjualan, qty terjual
   - Tampilan web saja (tanpa export)

9. **UI/Navigation Module**
   - Blade + Tailwind CSS
   - Responsive (mobile + desktop)
   - Mobile: bottom navigation (POS, Menu, Laporan, Stok, Pengaturan)
   - Desktop: sidebar
   - POS display: grid card menu items
   - Language: Indonesia

### Database Schema

**users**: id, username, password, name
**categories**: id, name
**menu_items**: id, category_id, name, description
**variants**: id, menu_item_id, size, price, stock
**toppings**: id, name, price
**menu_item_topping**: menu_item_id, topping_id (pivot)
**transactions**: id, transaction_date, total_amount, payment_method
**transaction_items**: id, transaction_id, variant_id, quantity, subtotal
**transaction_item_toppings**: id, transaction_item_id, topping_id
**stock_entries**: id, variant_id, quantity, note, created_at

### Technical Decisions

- Laravel 13.7, PHP 8.3
- PostgreSQL (deploy Railway)
- Blade + Tailwind (no Vue/React)
- Indonesian UI
- Single user (one kasir)
- QRIS offline (hanya catat, tidak integrasi payment gateway)
- No diskon/pajak
- No foto menu
- No printer thermal (tampil di layar)
- No export laporan

## Testing Decisions

### What Makes Good Test

- Test external behavior (input transaksi → stok berkurang, output laporan sesuai filter)
- Tidak test implementasi detail (tidak test private method, tidak test Blade rendering detail)
- Test happy path + edge cases (stok habis, topping multiple, dll)

### Modules to Test

1. **Variant Pricing Calculator** (deep module)
   - Input: variant price + selected toppings
   - Output: total price per item
   - Test: single variant, variant + multiple toppings, no topping

2. **Stock Manager** (deep module)
   - Input: transaction completion, restock entry
   - Output: variant stock updated correctly
   - Test: decrement on transaction, increment on restock, block when insufficient stock

3. **Report Aggregator** (deep module)
   - Input: date range, transactions data
   - Output: grouped by category, grouped by item
   - Test: filter by date, grouping accuracy, empty period

4. **Transaction State** (POS flow)
   - Input: add items to current order, select payment
   - Output: order summary before checkout
   - Test: add multiple items, calculate total with toppings, clear order

### Prior Art

Tidak ada tests di codebase (fresh Laravel). Menggunakan PHPUnit (sudah terkonfigurasi di composer.json).

## Out of Scope

- Diskon / promo / pajak
- Printer thermal (hardware integration)
- Export laporan (PDF/Excel)
- Multi-user / role management
- Foto menu
- Lupa password
- Email notification
- Bahan baku tracking (hanya barang jadi)
- QRIS online integration
- Edit/batal transaksi
- Mobile app native (web app responsif saja)

## Further Notes

- Mobile-first approach: bottom navigation, grid card POS
- PostgreSQL dipilih karena Railway default (SQLite tidak cocok Railway karena ephemeral filesystem)
- Auth sederhana karena sistem pribadi (single kasir)
- Unifikasi variant: semua item punya variant (bukan harga langsung di menu_items) untuk konsistensi data
- Transaksi final untuk menjaga integritas data penjualan
