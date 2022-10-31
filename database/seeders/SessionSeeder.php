<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Session::truncate();
        $data = [
            [
                "id" => 3,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 11:41:23",
                "updated_at" => "2021-12-16 11:42:49",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 4,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 11:42:49",
                "updated_at" => "2021-12-16 11:44:25",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 6,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 11:56:29",
                "updated_at" => "2021-12-16 11:58:58",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 7,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 11:58:58",
                "updated_at" => "2021-12-16 12:00:40",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 8,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 12:00:40",
                "updated_at" => "2021-12-16 12:01:52",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 9,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 12:01:52",
                "updated_at" => "2021-12-16 12:04:19",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 10,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 12:04:19",
                "updated_at" => "2021-12-16 12:05:38",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 11,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 12:05:38",
                "updated_at" => "2021-12-16 12:06:41",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 12,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 12:06:41",
                "updated_at" => "2021-12-16 12:07:12",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ], [
                "id" => 13,
                "status" => "CLOSE",
                "lowest" => null,
                "highest" => null,
                "last_buy" => null,
                "average_buy" => null,
                "total_buy" => null,
                "cover" => null,
                "created_at" => "2021-12-16 12:07:12",
                "updated_at" => "2021-12-16 12:09:16",
                "deleted_at" => null,
                "bot_id" => 1,
                "user_id" => 2
            ]
        ];
        Session::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
