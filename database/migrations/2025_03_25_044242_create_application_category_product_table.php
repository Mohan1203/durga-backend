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
        // Only create if the table doesn't exist
        if (!Schema::hasTable('application_category_product')) {
            Schema::create('application_category_product', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_category_id');
                $table->unsignedBigInteger('application_product_id');
                $table->timestamps();
                
                $table->foreign('application_category_id')
                      ->references('id')
                      ->on('application-categories')
                      ->onDelete('cascade');
                      
                $table->foreign('application_product_id')
                      ->references('id')
                      ->on('application_products')
                      ->onDelete('cascade');
                      
                $table->unique(['application_category_id', 'application_product_id']);
            });
        } else {
            // The table exists but might need updating
            // Check if it has the correct columns and update if needed
            Schema::table('application_category_product', function (Blueprint $table) {
                // Rename columns if the old ones exist and the new ones don't
                if (Schema::hasColumn('application_category_product', 'category_id') && 
                    !Schema::hasColumn('application_category_product', 'application_category_id')) {
                    
                    $table->renameColumn('category_id', 'application_category_id');
                }
                
                if (Schema::hasColumn('application_category_product', 'product_id') && 
                    !Schema::hasColumn('application_category_product', 'application_product_id')) {
                    
                    $table->renameColumn('product_id', 'application_product_id');
                }
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_category_product');
    }
};