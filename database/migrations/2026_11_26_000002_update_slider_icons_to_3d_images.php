<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('slider_icons')) {
            $map = [
                'packages'   => 'slider_icons/3d_packages.png',
                'hotel'      => 'slider_icons/3d_hotels.png',
                'cab'        => 'slider_icons/3d_cabs.png',
                'train'      => 'slider_icons/3d_trains.png',
                'flight'     => 'slider_icons/3d_flights.png',
                'adventure'  => 'slider_icons/3d_adventure.png',
                'gandola'    => 'slider_icons/3d_gandola.png',
                'helicopter' => 'slider_icons/3d_helicopter.png',
            ];

            foreach ($map as $keyword => $imagePath) {
                DB::table('slider_icons')
                    ->whereRaw('LOWER(TRIM(title)) LIKE ?', ['%' . $keyword . '%'])
                    ->update(['image' => $imagePath]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse icon upgrades
    }
};
