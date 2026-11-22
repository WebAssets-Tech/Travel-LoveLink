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
        Schema::table('tours', function (Blueprint $table) {
            if (!Schema::hasColumn('tours', 'rating')) {
                $table->decimal('rating', 3, 1)->default(4.8)->nullable()->after('price');
            }
            if (Schema::hasColumn('tours', 'venue_date')) {
                $table->date('venue_date')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'rating')) {
                $table->dropColumn('rating');
            }
        });
    }
};

