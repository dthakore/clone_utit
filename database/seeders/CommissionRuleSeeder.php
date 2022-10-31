<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CommissionRule;

class CommissionRuleSeeder extends Seeder
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
                "commission_plan_id" => 1,
                "user_level" => "Level 1",
                "rank_id" => 1,
                "amount_type" => 1,
                "amount" => 8,
                "wallet_type_id" => 1,
                "wallet_reference_id" => 1,
                "denomination_id" => 1,
                "wallet_status" => 1,
                "created_at" => now()
            ],
            [
                "commission_plan_id" => 1,
                "user_level" => "Level 2",
                "rank_id" => 1,
                "amount_type" => 1,
                "amount" => 8,
                "wallet_type_id" => 1,
                "wallet_reference_id" => 2,
                "denomination_id" => 1,
                "wallet_status" => 1,
                "created_at" => now()
            ],
            [
                "commission_plan_id" => 1,
                "user_level" => "Level 3",
                "rank_id" => 1,
                "amount_type" => 1,
                "amount" => 8,
                "wallet_type_id" => 1,
                "wallet_reference_id" => 3,
                "denomination_id" => 1,
                "wallet_status" => 1,
                "created_at" => now()
            ],
            [
                "commission_plan_id" => 1,
                "user_level" => "Level 4",
                "rank_id" => 1,
                "amount_type" => 1,
                "amount" => 3,
                "wallet_type_id" => 1,
                "wallet_reference_id" => 4,
                "denomination_id" => 1,
                "wallet_status" => 1,
                "created_at" => now()
            ],
            [
                "commission_plan_id" => 1,
                "user_level" => "Level 5",
                "rank_id" => 1,
                "amount_type" => 1,
                "amount" => 3,
                "wallet_type_id" => 1,
                "wallet_reference_id" => 5,
                "denomination_id" => 1,
                "wallet_status" => 1,
                "created_at" => now()
            ],
        ];
        CommissionRule::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
