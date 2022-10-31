<?php

namespace Database\Seeders;

use App\Models\Exchange;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExchangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Exchange::truncate();
        $data = [
            [
                "id" => 1,
                "name" => "Binance",
                "slug" => "BINANCE",
                "status" => 1,
                "is_visible" => 1,
                "tags" => "Spot, Options",
                "is_production" => 0,
                "api_url" => "https://testnet.binance.vision",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null
            ]
        ];
        Exchange::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
