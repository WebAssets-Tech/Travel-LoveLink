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
        // 1. Tours Performance Indexes
        Schema::table('tours', function (Blueprint $table) {
            $table->index('state_id', 'idx_tours_state_id');
            $table->index('type', 'idx_tours_type');
            $table->index('status', 'idx_tours_status');
            $table->index('created_at', 'idx_tours_created_at');
        });

        // 2. Hotels Performance Indexes
        Schema::table('hotels', function (Blueprint $table) {
            $table->index('status', 'idx_hotels_status');
            $table->index('created_at', 'idx_hotels_created_at');
        });

        // 3. Cabs Performance Indexes
        Schema::table('cabs', function (Blueprint $table) {
            $table->index(['status', 'order'], 'idx_cabs_status_order');
        });

        // 4. Sliders Performance Indexes
        Schema::table('sliders', function (Blueprint $table) {
            $table->index(['spiti_is_colder', 'domestic_trip'], 'idx_sliders_filters');
        });

        // 5. Tour Category Performance Indexes
        Schema::table('tour_category', function (Blueprint $table) {
            $table->index('parent_id', 'idx_tour_cat_parent_id');
            $table->index('status', 'idx_tour_cat_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropIndex('idx_tours_state_id');
            $table->dropIndex('idx_tours_type');
            $table->dropIndex('idx_tours_status');
            $table->dropIndex('idx_tours_created_at');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropIndex('idx_hotels_status');
            $table->dropIndex('idx_hotels_created_at');
        });

        Schema::table('cabs', function (Blueprint $table) {
            $table->dropIndex('idx_cabs_status_order');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex('idx_sliders_filters');
        });

        Schema::table('tour_category', function (Blueprint $table) {
            $table->dropIndex('idx_tour_cat_parent_id');
            $table->dropIndex('idx_tour_cat_status');
        });
    }
};
