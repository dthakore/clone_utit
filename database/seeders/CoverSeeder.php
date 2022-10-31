<?php

namespace Database\Seeders;

use App\Models\Cover;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Cover::truncate();
        $data = [
            [
                "id" => 1,
                "index" => 1,
                "cover_percentage" => -2.00,
                "buy_x_times" => 2,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 1
            ], [
                "id" => 2,
                "index" => 2,
                "cover_percentage" => -3.00,
                "buy_x_times" => 4,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 1
            ], [
                "id" => 3,
                "index" => 3,
                "cover_percentage" => -4.00,
                "buy_x_times" => 8,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 1
            ], [
                "id" => 4,
                "index" => 4,
                "cover_percentage" => -1.00,
                "buy_x_times" => 1,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 1
            ], [
                "id" => 5,
                "index" => 5,
                "cover_percentage" => -1.00,
                "buy_x_times" => 1,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 1
            ], [
                "id" => 6,
                "index" => 6,
                "cover_percentage" => -1.00,
                "buy_x_times" => 1,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 1
            ], [
                "id" => 7,
                "index" => 1,
                "cover_percentage" => -2.00,
                "buy_x_times" => 2,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 2
            ], [
                "id" => 8,
                "index" => 2,
                "cover_percentage" => -4.00,
                "buy_x_times" => 4,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 2
            ], [
                "id" => 9,
                "index" => 3,
                "cover_percentage" => -6.00,
                "buy_x_times" => 8,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 2
            ], [
                "id" => 10,
                "index" => 4,
                "cover_percentage" => -8.00,
                "buy_x_times" => 16,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 2
            ], [
                "id" => 11,
                "index" => 5,
                "cover_percentage" => -10.00,
                "buy_x_times" => 32,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 2
            ], [
                "id" => 12,
                "index" => 6,
                "cover_percentage" => -12.00,
                "buy_x_times" => 64,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 2
            ], [
                "id" => 13,
                "index" => 1,
                "cover_percentage" => -2.00,
                "buy_x_times" => 2,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 3
            ], [
                "id" => 14,
                "index" => 2,
                "cover_percentage" => -4.00,
                "buy_x_times" => 4,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 3
            ], [
                "id" => 15,
                "index" => 3,
                "cover_percentage" => -6.00,
                "buy_x_times" => 8,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 3
            ], [
                "id" => 16,
                "index" => 4,
                "cover_percentage" => -8.00,
                "buy_x_times" => 16,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 3
            ], [
                "id" => 17,
                "index" => 5,
                "cover_percentage" => -10.00,
                "buy_x_times" => 32,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 3
            ], [
                "id" => 18,
                "index" => 6,
                "cover_percentage" => -12.00,
                "buy_x_times" => 64,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 3
            ], [
                "id" => 19,
                "index" => 1,
                "cover_percentage" => -2.00,
                "buy_x_times" => 2,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 4
            ], [
                "id" => 20,
                "index" => 2,
                "cover_percentage" => -4.00,
                "buy_x_times" => 4,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 4
            ], [
                "id" => 21,
                "index" => 3,
                "cover_percentage" => -6.00,
                "buy_x_times" => 8,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 4
            ], [
                "id" => 22,
                "index" => 4,
                "cover_percentage" => -8.00,
                "buy_x_times" => 16,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 4
            ], [
                "id" => 23,
                "index" => 5,
                "cover_percentage" => -10.00,
                "buy_x_times" => 32,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 4
            ], [
                "id" => 24,
                "index" => 6,
                "cover_percentage" => -12.00,
                "buy_x_times" => 64,
                "cover_pullback" => 0.50,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
                "deleted_at" => null,
                "bot_id" => 4
            ]
        ];
        Cover::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
