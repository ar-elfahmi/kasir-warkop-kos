---
Labels: ready-for-agent
---

## Parent
None

## What to build
Pindah tracking stok dari level variant ke level menu item. Variant minuman (jumbo/small) hanya beda gelas, takaran bahan sama, sehingga stok harus shared. Saat ini `variants.stock` per-variant, harus dipindah ke `menu_items.stock` supaya semua variant item sama-sama berkurang saat ada transaksi.

## Acceptance criteria
- [ ] Tambah kolom `stock` di tabel `menu_items`
- [ ] Hapus kolom `stock` dari tabel `variants`
- [ ] `CheckoutController::process()` kurangi `menu_items.stock` (bukan `variants.stock`)
- [ ] Restock (stock_entries) update `menu_items.stock`
- [ ] Stok cukup/block order cek `menu_items.stock`
- [ ] UI stok di halaman menu/stock tampilkan stok item (bukan per variant)
- [ ] Migration: migrate existing variant stock ke menu item (sum jika multi-variant)
- [ ] Test: beli variant jumbo → stok item berkurang, variant small stok berubah (shared)
- [ ] Test: beli variant small → stok item berkurang, variant jumbo stok berubah (shared)

## Blocked by
None - can start immediately
