---
Labels: ready-for-agent
---

## Parent
None

## What to build
Checkout transaksi: pilih metode bayar (tunai/QRIS), simpan transaksi, auto decrement stok, block kalau stok kurang, tampil struk. Termasuk test modul Variant Pricing dan Stock Manager.

## Acceptance criteria
- [ ] Pilih metode bayar (Tunai/QRIS) berfungsi
- [ ] Checkout menyimpan transaksi ke tabel transactions + transaction_items
- [ ] Topping yang dipilih tersimpan di transaction_item_toppings
- [ ] Stok variant otomatis berkurang sesuai qty transaksi
- [ ] Transaksi block kalau stok variant < qty order
- [ ] Struk penjualan tampil di layar setelah checkout
- [ ] Transaksi bersifat final (tidak bisa edit/batal)
- [ ] UI menggunakan bahasa Indonesia
- [ ] Test modul Variant Pricing (variant + multiple toppings → total) lulus
- [ ] Test modul Stock Manager (decrement on transaction, block insufficient stock) lulus

## Blocked by
#4 (POS - Display & Cart)
