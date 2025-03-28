<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the position column doesn't already exist
        if (!Schema::hasColumn('product_portfolios', 'position')) {
            Schema::table('product_portfolios', function (Blueprint $table) {
                $table->integer('position')->default(0)->after('id');
            });

            // Get all existing products
            $products = DB::table('product_portfolios')->orderBy('id')->get();

            // Set position numbers for existing products
            foreach ($products as $index => $product) {
                DB::table('product_portfolios')
                    ->where('id', $product->id)
                    ->update(['position' => $index + 1]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_portfolios', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};