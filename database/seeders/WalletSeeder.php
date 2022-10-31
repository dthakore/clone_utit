<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Allwallettransaction;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $data = [
            [
                "id" => 1,
                "transaction_type" => 1,
                "reference_num" => 434357,
                "transaction_comment" => "Commission generated for Trade : 434357 for level 1",
                "transaction_status" => 3,
                "amount" => 1.76,
                "created_at" => now(),
                "user_id" => 1,
                "wallet_type_id" => 1,
                "reference_id" => 3,
                "denomination_id" => 1
            ]
        ];
        Allwallettransaction::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
