<?php

namespace Database\Seeders;

use App\Models\UserExchange;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserExchangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UserExchange::truncate();
        $data = [
              [
                  "id" => 1,
                  "name" => "Test Connection",
                  "key" => "t5yo6O5A0a1d6iMWjrqzlKzecbdbYCpapluh9acp0r1V5STMwTYponos1axiGumD",
                  "secret" => "cv9xPOIU9CnXU14KKiKvxPWKu6F3oXuGeqhSirpcxG7UGMT7HMCE5GDjuqxyeDvt",
                  "is_deleted" => 0,
                  "created_at" => date("Y-m-d H:i:s"),
                  "updated_at" => date("Y-m-d H:i:s"),
                  "deleted_at" => null,
                  "user_id" => 2,
                  "exchange_id" => 1
              ]
        ];
        UserExchange::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
