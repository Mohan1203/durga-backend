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
        Schema::table('application-categories', function (Blueprint $table) {
            $table->integer('sequence')->default(0)->after('id');
        });

        // Get all existing categories
        $categories = DB::table('application-categories')->get();

        // Set sequence numbers for existing categories
        foreach ($categories as $index => $category) {
            DB::table('application-categories')
                ->where('id', $category->id)
                ->update(['sequence' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application-categories', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
}; 