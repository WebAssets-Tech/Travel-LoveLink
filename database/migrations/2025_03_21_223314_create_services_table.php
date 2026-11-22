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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Service title
            $table->string('slug')->unique(); // SEO-friendly URL slug
            $table->text('description')->nullable(); // Service description
            $table->string('image')->nullable(); // Service image
            $table->string('page_bg_image')->nullable(); // Service image
            $table->string('banner_image')->nullable(); // Service image
            $table->string('banner_footer_image')->nullable(); // Service image
            $table->text('features')->default(json_encode([])); // List of features
            $table->decimal('price', 10, 2)->nullable(); // Price of service (if applicable)
            $table->text('highlights')->default(json_encode([]));
            $table->text('gallery')->default(json_encode([]));
            $table->text('meta_title')->nullable(); // SEO Meta Title
            $table->text('meta_keywords')->nullable(); // SEO Keywords
            $table->text('meta_description')->nullable(); // SEO Description
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
