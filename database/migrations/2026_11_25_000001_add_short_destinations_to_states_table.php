<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('states', function (Blueprint $table) {
            if (!Schema::hasColumn('states', 'short_destinations')) {
                $table->text('short_destinations')->nullable()->after('code');
            }
        });

        $defaults = [
            'kashmir'          => 'Srinagar, Gulmarg, Pahalgam, Sonamarg',
            'kashmir-trekking' => 'Tarsar Marsar, Great Lakes, Sonamarg, Yousmarg',
            'ladakh'           => 'Leh, Pangong Lake, Nubra Valley, Khardung La',
            'shimla-manali'    => 'Shimla, Manali, Solang Valley, Kufri',
            'golden-triangle'  => 'Delhi, Agra, Jaipur, Fatehpur Sikri',
            'goa'              => 'North Goa, South Goa, Baga Beach, Old Goa',
            'darjeeling'       => 'Tiger Hill, Batasia Loop, Mirik, Kalimpong',
            'kerala'           => 'Munnar, Alleppey, Kochi, Thekkady',
            'vaishno-devi'     => 'Katra, Bhawan, Patnitop, Shiv Khori',
            'amarnath-yatra'   => 'Pahalgam, Baltal, Sonamarg, Holy Cave',
            'mussoorie'        => 'Kempty Falls, Mall Road, Dhanaulti, Landour',
            'ooty'             => 'Botanical Garden, Coonoor, Pykara, Doddabetta',
            'dubai'            => 'Burj Khalifa, Desert Safari, Palm Jumeirah, Dubai Marina',
            'thailand'         => 'Bangkok, Pattaya, Phuket, Krabi',
            'indonesia'        => 'Bali, Ubud, Nusa Penida, Kuta',
            'malaysia'         => 'Kuala Lumpur, Genting Highlands, Langkawi, Batu Caves',
            'maldives'         => 'Male, Maafushi, Water Villas, Coral Reefs',
            'vietnam'          => 'Hanoi, Ha Long Bay, Da Nang, Ho Chi Minh',
            'nepal'            => 'Kathmandu, Pokhara, Chitwan, Nagarkot',
            'bhutan'           => 'Thimphu, Paro, Punakha, Tigers Nest',
            'srilanka'         => 'Colombo, Kandy, Ella, Bentota',
        ];

        foreach ($defaults as $slug => $list) {
            DB::table('states')
                ->where('slug', $slug)
                ->whereNull('short_destinations')
                ->update(['short_destinations' => $list]);
        }
    }

    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            if (Schema::hasColumn('states', 'short_destinations')) {
                $table->dropColumn('short_destinations');
            }
        });
    }
};
