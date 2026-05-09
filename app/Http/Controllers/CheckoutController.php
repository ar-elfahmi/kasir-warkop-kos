<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cart
    ) {}

    public function checkout()
    {
        $cartItems = $this->cart->items();
        $cartTotal = $this->cart->total();

        if (empty($cartItems)) {
            return redirect('/pos');
        }

        return view('pos.checkout', compact('cartItems', 'cartTotal'));
    }

    public function process(Request $request)
    {
        $cartItems = $this->cart->items();
        if (empty($cartItems)) {
            return redirect('/pos');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:tunai,qris',
            'paid_amount' => 'required_if:payment_method,tunai|integer|min:0|nullable',
        ]);

        $paymentMethod = $validated['payment_method'];
        $cartTotal = $this->cart->total();

        if ($paymentMethod === 'qris') {
            $paidAmount = $cartTotal;
            $changeAmount = 0;
        } else {
            $paidAmount = (int) $validated['paid_amount'];

            if ($paidAmount < $cartTotal) {
                return redirect()->back()->withErrors([
                    'paid_amount' => 'Jumlah bayar tidak boleh kurang dari total tagihan'
                ]);
            }

            $changeAmount = $paidAmount - $cartTotal;
        }

        // Aggregate qty per menu_item_id
        $itemQtyMap = [];
        foreach ($cartItems as $item) {
            $variant = \App\Models\Variant::find($item['variant_id']);
            if (!$variant || !$variant->menuItem) {
                continue;
            }
            $menuItemId = $variant->menu_item_id;
            if (!isset($itemQtyMap[$menuItemId])) {
                $itemQtyMap[$menuItemId] = 0;
            }
            $itemQtyMap[$menuItemId] += $item['qty'];
        }

        try {
            $transaction = null;

            DB::transaction(function () use ($cartItems, $cartTotal, $paymentMethod, $paidAmount, $changeAmount, $itemQtyMap, &$transaction) {
                // Check stock with lockForUpdate
                foreach ($itemQtyMap as $menuItemId => $totalQty) {
                    $menuItem = MenuItem::where('id', $menuItemId)->lockForUpdate()->first();
                    if (!$menuItem || $menuItem->stock < $totalQty) {
                        $name = $menuItem?->name ?? 'Item';
                        $available = $menuItem?->stock ?? 0;
                        throw new \Exception("Stok {$name} tidak mencukupi. Tersedia: {$available}, diminta: {$totalQty}");
                    }
                }

                $transaction = Transaction::create([
                    'total' => $cartTotal,
                    'payment_method' => $paymentMethod,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount,
                ]);

                foreach ($cartItems as $item) {
                    $variant = \App\Models\Variant::find($item['variant_id']);
                    if (!$variant) {
                        continue;
                    }

                    $itemTotal = $variant->price * $item['qty'];

                    $transactionItem = TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'variant_id' => $variant->id,
                        'item_name' => $variant->menuItem?->name ?? 'Item',
                        'variant_label' => $variant->size ? ucfirst($variant->size) : 'Reguler',
                        'qty' => $item['qty'],
                        'unit_price' => $variant->price,
                        'total_price' => $itemTotal,
                    ]);

                    // Decrement menuItem.stock
                    $menuItem = $variant->menuItem;
                    if ($menuItem) {
                        $menuItem->decrement('stock', $item['qty']);
                    }
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'stock' => $e->getMessage(),
            ]);
        }

        $this->cart->clear();

        return redirect("/pos/receipt/{$transaction->id}");
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load('items');

        return view('pos.receipt', compact('transaction'));
    }
}
