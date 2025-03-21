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
        Schema::create('product_portfolios', function (Blueprint $table) {
            $table->id();
            $table->string("heading");
            $table->string("sub_heading");
            $table->string("name");
            $table->text("description");
            $table->string("slug")->unique();
            $table->string("image")->nullable();
            $table->string("grade_title");
            $table->string("key_feature_title");
            $table->text("key_feature_description");
            $table->string("indutry_title");
            $table->timestamps();
        });

        Schema::create('feature_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_portfolio_id")->nullable()->onDelete("cascade");
            $table->string("title");
            $table->text("description");
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_portfolio_id")->nullable()->onDelete("cascade");
            $table->string("parent_category");
            $table->text("child_category");
            $table->timestamps();
        }); 

        Schema::create('key_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_portfolio_id")->nullable()->onDelete("cascade");
            $table->string("name");
            $table->text("description");
            $table->string("image")->nullable();
            $table->timestamps();
        });

        Schema::create('industry', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_portfolio_id")->nullable()->onDelete("cascade");
            $table->string("name");
            $table->string("image")->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry');
        Schema::dropIfExists('key_features');   
        Schema::dropIfExists('grades');
        Schema::dropIfExists('feature_sections');
        Schema::dropIfExists('product_portfolios');
    }
};
