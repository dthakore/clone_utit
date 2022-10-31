<?php

namespace Database\Seeders;

use App\Models\ExchangeLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExchangeLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ExchangeLog::truncate();
        $data = [
              [
                  "id" => 1,
                  "code" => "Test Code",
                  "error" => "Testing error",
                  "log" => "Error while Test Exchange create",
                  "order_id" => 1,
                  "exchange" => "Binance",
                  "request" => "Create",
                  "created_at" => date("Y-m-d H:i:s"),
                  "updated_at" => null,
              ]
        ];
        ExchangeLog::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
