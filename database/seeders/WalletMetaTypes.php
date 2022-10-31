<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WalletMetaType;

class WalletMetaTypes extends Seeder
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
                'reference_key'    => 'service-fee',
                'reference_desc'    => 'Service fee deduction based on the subscription plan',
                'reference_data' => 'crypto_trades.id',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Profit from Trade',
                'reference_desc'    => 'Profit amount generated from a crypto trade',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Deducted for Commission Distribution',
                'reference_desc'    => 'Amount deducted from wallet for commission distribution',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Commission from Level 1',
                'reference_desc'    => 'Commission from Level 1',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Commission from Level 2',
                'reference_desc'    => 'Commission from Level 2',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Commission from Level 3',
                'reference_desc'    => 'Commission from Level 3',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Commission from Level 4',
                'reference_desc'    => 'Commission from Level 4',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Commission from Level 5',
                'reference_desc'    => 'Commission from Level 5',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
            [
                'reference_key'    => 'Commission from Level 6',
                'reference_desc'    => 'Commission from Level 6',
                'reference_data' => 'Trade ID',
                'created_at' => now()
            ],
        ];

        WalletMetaType::insert($steps);
    }
}
