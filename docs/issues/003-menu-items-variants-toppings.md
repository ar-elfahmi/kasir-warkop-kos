---
Labels: ready-for-agent
---

## Parent
None

## What to build
CRUD menu item, variant (ukuran harga beda), topping, dan relasi menu item - topping. Unifikasi semua item punya variant.

## Acceptance criteria
- [ ] Tabel menu_items (id, category_id, name, description) terbuat
- [ ] Tabel variants (id, menu_item_id, size, price, stock) terbuat
- [ ] Tabel toppings (id, name, price) terbuat
- [ ] Tabel pivot menu_item_topping terbuat
- [ ] Fitur CRUD menu item lengkap
- [ ] Fitur CRUD variant per menu item (minuman: besar/kecil, makanan/rokok: single variant size=null)
- [ ] Fitur CRUD topping lengkap
- [ ] Fitur assign topping ke menu item (hanya makanan)
- [ ] UI menggunakan bahasa Indonesia
- [ ] Validasi relasi dan data

## Blocked by
#2 (Category CRUD)
