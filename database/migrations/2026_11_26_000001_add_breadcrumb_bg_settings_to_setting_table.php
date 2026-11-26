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
        Schema::table('setting', function (Blueprint $table) {
            $table->string('breadcrumb_bg_type', 20)->default('image')->after('page_bg_image');
            $table->string('breadcrumb_bg_color', 500)
                ->nullable()
                ->default('linear-gradient(135deg, #072355 0%, #0B3D91 60%, #0e46a3 100%)')
                ->after('breadcrumb_bg_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->dropColumn(['breadcrumb_bg_type', 'breadcrumb_bg_color']);
        });
    }
};
