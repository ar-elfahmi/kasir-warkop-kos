---
Labels: ready-for-agent
---

## Parent
None

## What to build
Halaman koreksi stok (adjustment) yang memungkinkan kasir menambah atau mengurangi stok menu item dengan mencatat alasan, sehingga stok sistem sesuai dengan kondisi fisik.

## Acceptance criteria
- [ ] Tambah kolom `type` (enum: restock, adjustment_increase, adjustment_decrease) pada tabel stock_entries
- [ ] Halaman stock adjustment menampilkan form input variant, qty (positif), note, dan jenis adjustment (tambah/kurangi)
- [ ] Simpan adjustment otomatis menambah atau mengurangi stok variant sesuai jenis dan qty
- [ ] Riwayat adjustment tampil di halaman stok bersama riwayat restock (diferensiate oleh kolom type)
- [ ] UI menggunakan bahasa Indonesia
- [ ] Test modul Stock Manager (adjustment) lulus

## Blocked by
#6 (Stock restock)
