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
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('email1')->nullable();
            $table->string('phone')->unique();
            $table->string('phone1')->nullable();
            $table->string('address');
            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('footer_about')->nullable();
            $table->string('header_script')->nullable();
            $table->string('footer_script')->nullable();
            $table->string('youtube_vid_link')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('footer_copyright')->nullable();
            $table->string('favicon')->nullable();
            $table->string('app_url');
            $table->text('map_link')->nullable();
            $table->json('social_link')->nullable();  
            $table->json('about_images')->nullable();  
            $table->json('page_bg_image')->nullable();  
            $table->string('about_subtitle')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_content')->nullable();  
            $table->json('about_ot_content')->nullable();  
            $table->json('home_counter')->nullable();  
            $table->boolean('preloader')->default(0); 
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('status')->default(1);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
