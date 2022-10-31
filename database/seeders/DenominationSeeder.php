<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
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
                'denomination_type'   => 'USDT',
                'sub_type'            => 'USDT',
                'label'               => 'USDT',
                'currency'            => 'USD',
                'created_at'          => now()
            ],
            [
                'denomination_type'   => 'USD($)',
                'sub_type'            => 'USD($)',
                'label'               => 'USD($)',
                'currency'            => 'USD',
                'created_at'          => now()
            ],
        ];

        Denomination::insert($steps);
    }
}
