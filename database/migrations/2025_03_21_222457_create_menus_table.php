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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Menu item title 
            $table->string('link')->nullable(); // URL link
            $table->unsignedBigInteger('parent_id')->nullable(); // For submenus
            $table->integer('order')->default(0); // Ordering of menu items
            $table->boolean('type')->default(0); // 1 = footer, 0 = header
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();

            // Foreign key reference for parent menus
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
