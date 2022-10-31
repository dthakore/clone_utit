<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $steps = [
            [
                'name'          => 'Promoter',
                'description'   => 'Promoter',
                'abbreviation'  => 'Promoter',
                'created_at'    => now()
            ],
            [
                'name'          => 'Team Promoter',
                'description'   => 'Team Promoter',
                'abbreviation'  => 'TeamPromoter',
                'created_at'    => now()
            ],
            [
                'name'          => 'Star Promoter',
                'description'   => 'Star Promoter',
                'abbreviation'  => 'StarPromoter',
                'created_at'    => now()
            ],
            [
                'name'          => 'Elite',
                'description'   => 'Elite',
                'abbreviation'  => 'Elite',
                'created_at'    => now()
            ],
            [
                'name'          => 'Premier',
                'description'   => 'Premier',
                'abbreviation'  => 'Premier',
                'created_at'    => now()
            ],
            [
                'name'          => 'Ambassador',
                'description'   => 'Ambassador',
                'abbreviation'  => 'Ambassador',
                'created_at'    => now()
            ],
            [
                'name'          => 'Leader',
                'description'   => 'Leader',
                'abbreviation'  => 'Leader',
                'created_at'    => now()
            ],
            [
                'name'          => 'Silver Leader',
                'description'   => 'Silver Leader',
                'abbreviation'  => 'SilverLeader',
                'created_at'    => now()
            ],
            [
                'name'          => 'Gold Leader',
                'description'   => 'Gold Leader',
                'abbreviation'  => 'GoldLeader',
                'created_at'    => now()
            ]
        ];

        Rank::insert($steps);
    }
}
