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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Activity title
            $table->string('days'); // Activity daystitle
            $table->text('map_link')->nullable(); // Google Map link
            $table->string('slug')->unique(); // SEO-friendly URL slug
            $table->text('description')->nullable(); // Activity description
            $table->string('image')->nullable(); // Main activity image
            $table->string('banner_image')->nullable(); // Banner image for activity
            $table->string('page_bg_image')->nullable(); // Page Bg image for activity
            $table->decimal('price', 10, 2)->nullable()->comment('Price of the activity (if applicable)');
            $table->json('highlights')->nullable()->comment('Key highlights of the activity');
            $table->json('important_info')->nullable()->comment('Key importent info of the activity');
            $table->json('include_exclude')->nullable()->comment('include exclude');
            $table->json('gallery')->nullable()->comment('Image or video gallery for the activity');
            $table->integer('rating')->default(5); // Rating out of 5
            $table->text('meta_title')->nullable()->comment('SEO Meta Title');
            $table->text('meta_keywords')->nullable()->comment('SEO Keywords');
            $table->text('meta_description')->nullable()->comment('SEO Description');
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
