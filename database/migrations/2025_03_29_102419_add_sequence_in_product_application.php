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
        Schema::table('application_products', function (Blueprint $table) {
            $table->integer('sequence')->default(0)->after('id');
        });
        $products = DB::table('application_products')->get();

        foreach ($products as $index => $product) {
            DB::table('application_products')->where('id', $product->id)->update(['sequence' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_products', function (Blueprint $table) {
            $table->dropColumn('sequence'); 
        });
    }
};