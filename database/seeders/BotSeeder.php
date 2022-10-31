<?php

namespace Database\Seeders;

use App\Models\Bot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Bot::truncate();
        $data = [
            [
                "id" => 1,
                "title" => "Coin Example 1",
                "balance" => 1000.00,
                "is_cycle" => 0,
                "init_immediate" => 1,
                "init_amount" => 20.00,
                "init_buy_at" => -1.50,
                "init_pullback" => 0.50,
                "take_profit_average_percentage" => 1.50,
                "take_profit_average_retracement" => -0.50,
                "take_profit_independent_cover" => 3,
                "take_profit_independent_percentage" => 1.00,
                "take_profit_independent_retracement" => -0.50,
                "status" => 0,
                "active_session_id" => null,
                "is_simulated" => 0,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "user_id" => 2,
                "user_exchange_id" => 1,
                "symbol_id" => 1
            ], [
                "id" => 2,
                "title" => "Coin Example 2",
                "balance" => 950.00,
                "is_cycle" => 1,
                "init_immediate" => 1,
                "init_amount" => 20.00,
                "init_buy_at" => -1.50,
                "init_pullback" => 0.50,
                "take_profit_average_percentage" => 1.50,
                "take_profit_average_retracement" => -0.50,
                "take_profit_independent_cover" => 0,
                "take_profit_independent_percentage" => 1.00,
                "take_profit_independent_retracement" => -0.50,
                "status" => 0,
                "active_session_id" => null,
                "is_simulated" => 0,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "user_id" => 2,
                "user_exchange_id" => 1,
                "symbol_id" => 2
            ], [
                "id" => 3,
                "title" => "Coin Example 3",
                "balance" => 800.00,
                "is_cycle" => 1,
                "init_immediate" => 1,
                "init_amount" => 20.00,
                "init_buy_at" => -1.50,
                "init_pullback" => 0.50,
                "take_profit_average_percentage" => 1.50,
                "take_profit_average_retracement" => -0.50,
                "take_profit_independent_cover" => 0,
                "take_profit_independent_percentage" => 1.00,
                "take_profit_independent_retracement" => -0.50,
                "status" => 0,
                "active_session_id" => null,
                "is_simulated" => 0,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "user_id" => 2,
                "user_exchange_id" => 1,
                "symbol_id" => 4
            ], [
                "id" => 4,
                "title" => "Coin Example 4",
                "balance" => 550.00,
                "is_cycle" => 1,
                "init_immediate" => 1,
                "init_amount" => 20.00,
                "init_buy_at" => -1.50,
                "init_pullback" => 0.50,
                "take_profit_average_percentage" => 1.50,
                "take_profit_average_retracement" => -0.50,
                "take_profit_independent_cover" => 0,
                "take_profit_independent_percentage" => 1.00,
                "take_profit_independent_retracement" => -0.50,
                "status" => 0,
                "active_session_id" => null,
                "is_simulated" => 0,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "user_id" => 2,
                "user_exchange_id" => 1,
                "symbol_id" => 8
            ]
        ];
        Bot::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
