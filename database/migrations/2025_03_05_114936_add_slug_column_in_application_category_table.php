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
        Schema::table('application-categories', function (Blueprint $table) {
            $table->string('name')->change(); 
            $table->string('slug')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application-categories', function (Blueprint $table) {
            $table->dropColumn('slug'); 
            $table->text('name')->change();
        });
    }
};
