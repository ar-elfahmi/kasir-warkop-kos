---
Labels: ready-for-agent
---

## Parent
None

## What to build
Fix waktu transaksi tidak sesuai zona waktu Indonesia WIB (UTC+7). Semua pencatatan dan tampilan waktu transaksi harus menggunakan WIB.

## Acceptance criteria
- [ ] Waktu transaksi tersimpan dalam WIB (UTC+7)
- [ ] Kolom `created_at` di tabel transactions menggunakan WIB
- [ ] Tampilan waktu di halaman laporan dan riwayat transaksi menggunakan WIB
- [ ] Filter tanggal di laporan bekerja dengan benar setelah fix timezone

## Blocked by
None - can start immediately
