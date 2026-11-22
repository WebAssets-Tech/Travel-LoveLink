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
        // 1. Tours views counter for fast popularity sorting
        Schema::table('tours', function (Blueprint $table) {
            if (!Schema::hasColumn('tours', 'views')) {
                $table->unsignedInteger('views')->default(0)->index('idx_tours_views')->after('status');
            }
        });

        // 2. Destinations performance index for location filtering & group-by
        Schema::table('destinations', function (Blueprint $table) {
            $table->index(['status', 'location'], 'idx_destinations_status_location');
        });

        // 3. Blogs latest active posts index
        Schema::table('blogs', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'idx_blogs_status_created_at');
        });

        // 4. Activities latest active items index
        Schema::table('activities', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'idx_activities_status_created_at');
        });

        // 5. Pivot tables reverse lookup indexes
        Schema::table('tour_destinations', function (Blueprint $table) {
            $table->index(['destination_id', 'tour_id'], 'idx_tour_dest_reverse');
        });

        Schema::table('tour_tour_category', function (Blueprint $table) {
            $table->index(['category_id', 'tour_id'], 'idx_tour_cat_reverse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'views')) {
                $table->dropIndex('idx_tours_views');
                $table->dropColumn('views');
            }
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropIndex('idx_destinations_status_location');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex('idx_blogs_status_created_at');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex('idx_activities_status_created_at');
        });

        Schema::table('tour_destinations', function (Blueprint $table) {
            $table->dropIndex('idx_tour_dest_reverse');
        });

        Schema::table('tour_tour_category', function (Blueprint $table) {
            $table->dropIndex('idx_tour_cat_reverse');
        });
    }
};
