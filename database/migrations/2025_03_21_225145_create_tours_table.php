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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable(); 
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('duration')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('page_bg_image')->nullable();
            $table->text('highlights_content')->nullable();
            $table->json('highlights')->nullable();
            $table->text('basic_content')->nullable();
            $table->json('basic')->nullable();
            $table->text('include_exclude_content')->nullable();
            $table->json('include_exclude')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('gallery')->nullable();
            $table->json('footer_gallery')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('type')->default(1);
            $table->date('venue_date')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_tour_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('tour_id')->references('id')->on('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id')->references('id')->on('tour_category')->cascadeOnDelete()->cascadeOnUpdate();
        });
        

        // Pivot table for tours & destinations (Many-to-Many)
        Schema::create('tour_destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('tour_id')->references('id')->on('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('destination_id')->references('id')->on('destinations')->cascadeOnDelete()->cascadeOnUpdate();
        });

        // Pivot table for tours & activities (Many-to-Many)
        Schema::create('tour_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('activity_id');
            $table->foreign('tour_id')->references('id')->on('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('activity_id')->references('id')->on('activities')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_activities');
        Schema::dropIfExists('tour_destinations'); // Fixed table name
        Schema::dropIfExists('tour_tour_category');
        Schema::dropIfExists('tours');
    }
};
