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
        Schema::table('settings', function (Blueprint $table) {
            // Check if the columns don't exist before adding them
            if (!Schema::hasColumn('settings', 'phone')) {
                $table->string('phone')->nullable();
            }
            
            if (!Schema::hasColumn('settings', 'email')) {
                $table->string('email')->nullable();
            }
            
            if (!Schema::hasColumn('settings', 'address')) {
                $table->string('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('settings', 'phone')) {
                $table->dropColumn('phone');
            }
            
            if (Schema::hasColumn('settings', 'email')) {
                $table->dropColumn('email');
            }
            
            if (Schema::hasColumn('settings', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};