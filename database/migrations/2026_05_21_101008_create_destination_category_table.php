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
        Schema::create('destination_category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('page_bg_image')->nullable();
            $table->text('banner_image')->nullable();
            $table->text('banner_footer_image')->nullable();
            $table->json('gallery')->nullable();  
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable(); 
            $table->unsignedBigInteger('parent_id')->nullable(); // For subcategories
            $table->foreign('parent_id')->references('id')->on('destination_category')->onDelete('cascade');
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->integer('odby')->default(0);
            $table->timestamps();
        });
        
        Schema::create('destination_destination_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('destination_id')->references('id')->on('destinations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id')->references('id')->on('destination_category')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_category');
        Schema::dropIfExists('destination_destination_category');
    }
};
