<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'pos_cart';

    public function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function addItem(int $variantId, int $qty, array $toppings): string
    {
        $items = $this->items();
        $key = $this->generateKey($variantId, $toppings);

        if (isset($items[$key])) {
            $items[$key]['qty'] += $qty;
        } else {
            $items[$key] = [
                'variant_id' => $variantId,
                'qty' => $qty,
                'toppings' => $toppings,
            ];
        }

        Session::put(self::SESSION_KEY, $items);

        return $key;
    }

    public function removeItem(string $key): void
    {
        $items = $this->items();
        unset($items[$key]);
        Session::put(self::SESSION_KEY, $items);
    }

    public function total(): int
    {
        $total = 0;
        foreach ($this->items() as $item) {
            $variant = \App\Models\Variant::find($item['variant_id']);
            if (!$variant) continue;
            $total += $variant->price * $item['qty'];
            foreach ($item['toppings'] as $topping) {
                $total += $topping['price'] * $item['qty'];
            }
        }

        return $total;
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    private function generateKey(int $variantId, array $toppings): string
    {
        $toppingIds = array_map(fn($t) => $t['id'] ?? '', $toppings);
        sort($toppingIds);

        return $variantId . '_' . implode('_', $toppingIds);
    }
}
