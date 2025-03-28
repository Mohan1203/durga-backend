<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_portfolios', function (Blueprint $table) {
            $table->integer('sequence')->default(0)->after('id');    
        });

        $portfolios = DB::table('product_portfolios')->get();

        foreach ($portfolios as $index => $portfolio) {
            DB::table('product_portfolios')->where('id', $portfolio->id)->update(['sequence' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_portfolios', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
};