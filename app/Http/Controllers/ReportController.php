<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $paymentMethod = $request->input('payment_method');

        $transactions = Transaction::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->when($paymentMethod, function ($query, $method) {
                return $query->where('payment_method', $method);
            })
            ->latest()
            ->get();

        $categorySummary = Category::all()->map(function ($cat) use ($dateFrom, $dateTo, $paymentMethod) {
            $totalQty = TransactionItem::whereHas('variant.menuItem', function ($q) use ($cat) {
                    $q->where('category_id', $cat->id);
                })
                ->whereHas('transaction', function ($q) use ($dateFrom, $dateTo, $paymentMethod) {
                    $q->whereDate('created_at', '>=', $dateFrom)
                      ->whereDate('created_at', '<=', $dateTo)
                      ->when($paymentMethod, function ($q, $method) {
                          return $q->where('payment_method', $method);
                      });
                })
                ->sum('qty');

            $totalSales = TransactionItem::whereHas('variant.menuItem', function ($q) use ($cat) {
                    $q->where('category_id', $cat->id);
                })
                ->whereHas('transaction', function ($q) use ($dateFrom, $dateTo, $paymentMethod) {
                    $q->whereDate('created_at', '>=', $dateFrom)
                      ->whereDate('created_at', '<=', $dateTo)
                      ->when($paymentMethod, function ($q, $method) {
                          return $q->where('payment_method', $method);
                      });
                })
                ->sum('total_price');

            return (object) [
                'name' => $cat->name,
                'total_qty' => $totalQty,
                'total_sales' => $totalSales,
            ];
        });

        $itemSummary = TransactionItem::whereHas('transaction', function ($q) use ($dateFrom, $dateTo, $paymentMethod) {
            $q->whereDate('created_at', '>=', $dateFrom)
              ->whereDate('created_at', '<=', $dateTo)
              ->when($paymentMethod, function ($q, $method) {
                  return $q->where('payment_method', $method);
              });
        })
            ->select('item_name',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(total_price) as total_sales'))
            ->groupBy('item_name')
            ->orderByDesc('total_sales')
            ->get();

        $grandTotal = $transactions->sum('total');

        return view('laporan.index', compact(
            'transactions', 'categorySummary', 'itemSummary',
            'dateFrom', 'dateTo', 'paymentMethod', 'grandTotal'
        ));
    }

    public function detail(Transaction $transaction)
    {
        $transaction->load('items');

        return view('laporan.detail', compact('transaction'));
    }
}
