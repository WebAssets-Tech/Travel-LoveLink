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
        Schema::create('tourist_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('email2')->nullable();
            $table->string('address')->nullable();
            $table->string('language'); // Languages the guide speaks
            $table->string('experience'); // Years of experience
            $table->text('details_counter')->default(json_encode([])); // Years of experience
            $table->string('image')->nullable();
            $table->string('page_bg_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->text('social_link')->default(json_encode([])); 
            $table->boolean('status')->default(1); // Active or Inactive
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_guides');
    }
};
