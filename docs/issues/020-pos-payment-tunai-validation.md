---
Labels: ready-for-agent
---

## Parent
None

## What to build
Validasi input pembayaran tunai: user tidak bisa input jumlah bayar kurang dari total tagihan. Tampil error jika jumlah bayar < total.

## Acceptance criteria
- [ ] Input jumlah bayar tunai wajib >= total tagihan
- [ ] Error message muncul jika jumlah bayar < total (bahasa Indonesia)
- [ ] Checkout block selama jumlah bayar belum valid
- [ ] UI menggunakan bahasa Indonesia
- [ ] Test validasi pembayaran tunai lulus

## Blocked by
#5 (POS - Checkout Transaction)
