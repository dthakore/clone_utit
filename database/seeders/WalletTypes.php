<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WalletType;

class WalletTypes extends Seeder
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
                'wallet_type'    => 'User',
                'wallet_slug'    => 'user',
                'created_at' => now()
            ],
            [
                'wallet_type'    => 'System',
                'wallet_slug'    => 'system',
                'created_at' => now()
            ]
        ];

        WalletType::insert($steps);
    }
}
