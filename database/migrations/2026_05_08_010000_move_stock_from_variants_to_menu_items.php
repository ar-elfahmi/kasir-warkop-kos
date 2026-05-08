<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add stock column to menu_items
        Schema::table('menu_items', function (Blueprint $table) {
            $table->integer('stock')->default(0);
        });

        // 2. Migrate existing variant stock to menu_items (sum if multi-variant)
        $menuItems = DB::table('menu_items')->get();
        foreach ($menuItems as $menuItem) {
            $totalStock = DB::table('variants')
                ->where('menu_item_id', $menuItem->id)
                ->sum('stock');
            DB::table('menu_items')
                ->where('id', $menuItem->id)
                ->update(['stock' => $totalStock ?? 0]);
        }

        // 3. Drop stock column from variants
        Schema::table('variants', function (Blueprint $table) {
            $table->dropColumn('stock');
        });

        // 4. Add menu_item_id to stock_entries
        Schema::table('stock_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_item_id')->nullable();
        });

        // 5. Migrate existing stock_entries data: lookup menu_item_id from variant_id
        $stockEntries = DB::table('stock_entries')->get();
        foreach ($stockEntries as $entry) {
            $variant = DB::table('variants')->where('id', $entry->variant_id)->first();
            if ($variant) {
                DB::table('stock_entries')
                    ->where('id', $entry->id)
                    ->update(['menu_item_id' => $variant->menu_item_id]);
            }
        }

        // 6. Make menu_item_id not nullable and add foreign key
        Schema::table('stock_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_item_id')->nullable(false)->change();
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
        });

        // 7. Drop variant_id from stock_entries
        Schema::table('stock_entries', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }

    public function down(): void
    {
        // Rollback: reverse order

        // 7. Add variant_id back to stock_entries
        Schema::table('stock_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });

        // 6. Migrate stock_entries menu_item_id back to variant_id
        $stockEntries = DB::table('stock_entries')->get();
        foreach ($stockEntries as $entry) {
            // Find a variant for this menu_item (use first variant)
            $variant = DB::table('variants')->where('menu_item_id', $entry->menu_item_id)->first();
            if ($variant) {
                DB::table('stock_entries')
                    ->where('id', $entry->id)
                    ->update(['variant_id' => $variant->id]);
            }
        }

        // Drop menu_item_id
        Schema::table('stock_entries', function (Blueprint $table) {
            $table->dropForeign(['menu_item_id']);
            $table->dropColumn('menu_item_id');
        });

        // Add stock back to variants
        Schema::table('variants', function (Blueprint $table) {
            $table->integer('stock')->default(0);
        });

        // Migrate menu_items.stock back to variants (distribute evenly or put all in first variant)
        $menuItems = DB::table('menu_items')->get();
        foreach ($menuItems as $menuItem) {
            $firstVariant = DB::table('variants')->where('menu_item_id', $menuItem->id)->first();
            if ($firstVariant) {
                DB::table('variants')
                    ->where('id', $firstVariant->id)
                    ->update(['stock' => $menuItem->stock]);
            }
        }

        // Drop stock from menu_items
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
