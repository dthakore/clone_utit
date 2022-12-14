<?php

namespace Database\Seeders;

use App\Models\Trade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Trade::truncate();
        $data = [
            [
                "id" => 6,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "59558",
                "exchange_trade_ref" => "34841",
                "requested_price" => 49343.530000,
                "requested_quantity" => 0.000405,
                "executed_price" => 49343.530000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000405,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 11:42:49",
                "created_at" => "2021-12-16 11:41:23",
                "updated_at" => "2021-12-16 11:42:49",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 3,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 7,
                "requested_amount" => 20.412000,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "6",
                "exchange_order_ref" => "83288",
                "exchange_trade_ref" => "95512",
                "requested_price" => 50400.000000,
                "requested_quantity" => 0.000405,
                "executed_price" => 50400.000000,
                "executed_amount" => 20.412000,
                "executed_quantity" => 0.000405,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 11:42:49",
                "created_at" => "2021-12-16 11:42:49",
                "updated_at" => "2021-12-16 11:42:49",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 3,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 8,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "18749",
                "exchange_trade_ref" => "65942",
                "requested_price" => 50400.000000,
                "requested_quantity" => 0.000397,
                "executed_price" => 50400.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000397,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 11:44:25",
                "created_at" => "2021-12-16 11:42:49",
                "updated_at" => "2021-12-16 11:44:25",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 4,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 9,
                "requested_amount" => 20.485200,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "8",
                "exchange_order_ref" => "84812",
                "exchange_trade_ref" => "95084",
                "requested_price" => 51600.000000,
                "requested_quantity" => 0.000397,
                "executed_price" => 51600.000000,
                "executed_amount" => 20.485200,
                "executed_quantity" => 0.000397,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 11:44:25",
                "created_at" => "2021-12-16 11:44:25",
                "updated_at" => "2021-12-16 11:44:25",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 4,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 16,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "90542",
                "exchange_trade_ref" => "30282",
                "requested_price" => 50400.000000,
                "requested_quantity" => 0.000397,
                "executed_price" => 50400.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000397,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 11:58:58",
                "created_at" => "2021-12-16 11:56:29",
                "updated_at" => "2021-12-16 11:58:58",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 6,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 17,
                "requested_amount" => 40.000000,
                "side" => "BUY",
                "comment" => "Cover triggered -2% and bought 2 times",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "17759",
                "exchange_trade_ref" => "34529",
                "requested_price" => 49600.000000,
                "requested_quantity" => 0.000806,
                "executed_price" => 49600.000000,
                "executed_amount" => 40.000000,
                "executed_quantity" => 0.000806,
                "status" => 1,
                "trade_type" => "COVER-BUY",
                "closed_at" => "2021-12-16 11:58:58",
                "created_at" => "2021-12-16 11:57:00",
                "updated_at" => "2021-12-16 11:58:58",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 6,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => 1
            ], [
                "id" => 18,
                "requested_amount" => 80.000000,
                "side" => "BUY",
                "comment" => "Cover triggered -3% and bought 4 times",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "81391",
                "exchange_trade_ref" => "33685",
                "requested_price" => 48600.000000,
                "requested_quantity" => 0.001646,
                "executed_price" => 48600.000000,
                "executed_amount" => 80.000000,
                "executed_quantity" => 0.001646,
                "status" => 1,
                "trade_type" => "COVER-BUY",
                "closed_at" => "2021-12-16 11:58:58",
                "created_at" => "2021-12-16 11:57:41",
                "updated_at" => "2021-12-16 11:58:58",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 6,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => 2
            ], [
                "id" => 19,
                "requested_amount" => 142.734900,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "16,17,18",
                "exchange_order_ref" => "2514",
                "exchange_trade_ref" => "14139",
                "requested_price" => 50100.000000,
                "requested_quantity" => 0.002849,
                "executed_price" => 50100.000000,
                "executed_amount" => 142.734900,
                "executed_quantity" => 0.002849,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 11:58:57",
                "created_at" => "2021-12-16 11:58:57",
                "updated_at" => "2021-12-16 11:58:58",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 6,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 20,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "53934",
                "exchange_trade_ref" => "44095",
                "requested_price" => 50100.000000,
                "requested_quantity" => 0.000399,
                "executed_price" => 50100.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000399,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:00:40",
                "created_at" => "2021-12-16 11:58:58",
                "updated_at" => "2021-12-16 12:00:40",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 7,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 21,
                "requested_amount" => 20.349000,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "20",
                "exchange_order_ref" => "34083",
                "exchange_trade_ref" => "35543",
                "requested_price" => 51000.000000,
                "requested_quantity" => 0.000399,
                "executed_price" => 51000.000000,
                "executed_amount" => 20.349000,
                "executed_quantity" => 0.000399,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:00:40",
                "created_at" => "2021-12-16 12:00:40",
                "updated_at" => "2021-12-16 12:00:40",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 7,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 22,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "21923",
                "exchange_trade_ref" => "23678",
                "requested_price" => 51000.000000,
                "requested_quantity" => 0.000392,
                "executed_price" => 51000.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000392,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:01:52",
                "created_at" => "2021-12-16 12:00:40",
                "updated_at" => "2021-12-16 12:01:52",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 8,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 23,
                "requested_amount" => 20.384000,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "22",
                "exchange_order_ref" => "19492",
                "exchange_trade_ref" => "3455",
                "requested_price" => 52000.000000,
                "requested_quantity" => 0.000392,
                "executed_price" => 52000.000000,
                "executed_amount" => 20.384000,
                "executed_quantity" => 0.000392,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:01:52",
                "created_at" => "2021-12-16 12:01:52",
                "updated_at" => "2021-12-16 12:01:52",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 8,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 24,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "53818",
                "exchange_trade_ref" => "10657",
                "requested_price" => 52000.000000,
                "requested_quantity" => 0.000385,
                "executed_price" => 52000.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000385,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:04:19",
                "created_at" => "2021-12-16 12:01:52",
                "updated_at" => "2021-12-16 12:04:19",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 9,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 25,
                "requested_amount" => 20.366500,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "24",
                "exchange_order_ref" => "48626",
                "exchange_trade_ref" => "63575",
                "requested_price" => 52900.000000,
                "requested_quantity" => 0.000385,
                "executed_price" => 52900.000000,
                "executed_amount" => 20.366500,
                "executed_quantity" => 0.000385,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:04:18",
                "created_at" => "2021-12-16 12:04:18",
                "updated_at" => "2021-12-16 12:04:19",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 9,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 26,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "83981",
                "exchange_trade_ref" => "33294",
                "requested_price" => 52900.000000,
                "requested_quantity" => 0.000378,
                "executed_price" => 52900.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000378,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:05:38",
                "created_at" => "2021-12-16 12:04:19",
                "updated_at" => "2021-12-16 12:05:38",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 10,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 27,
                "requested_amount" => 40.000000,
                "side" => "BUY",
                "comment" => "Cover triggered -2% and bought 2 times",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "29712",
                "exchange_trade_ref" => "27158",
                "requested_price" => 51500.000000,
                "requested_quantity" => 0.000777,
                "executed_price" => 51500.000000,
                "executed_amount" => 40.000000,
                "executed_quantity" => 0.000777,
                "status" => 1,
                "trade_type" => "COVER-BUY",
                "closed_at" => "2021-12-16 12:05:38",
                "created_at" => "2021-12-16 12:04:56",
                "updated_at" => "2021-12-16 12:05:38",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 10,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => 1
            ], [
                "id" => 28,
                "requested_amount" => 60.984000,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "26,27",
                "exchange_order_ref" => "62278",
                "exchange_trade_ref" => "44521",
                "requested_price" => 52800.000000,
                "requested_quantity" => 0.001155,
                "executed_price" => 52800.000000,
                "executed_amount" => 60.984000,
                "executed_quantity" => 0.001155,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:05:33",
                "created_at" => "2021-12-16 12:05:33",
                "updated_at" => "2021-12-16 12:05:38",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 10,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 29,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "12848",
                "exchange_trade_ref" => "42245",
                "requested_price" => 52800.000000,
                "requested_quantity" => 0.000379,
                "executed_price" => 52800.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000379,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:06:41",
                "created_at" => "2021-12-16 12:05:38",
                "updated_at" => "2021-12-16 12:06:41",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 11,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 30,
                "requested_amount" => 20.314400,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "29",
                "exchange_order_ref" => "10138",
                "exchange_trade_ref" => "20017",
                "requested_price" => 53600.000000,
                "requested_quantity" => 0.000379,
                "executed_price" => 53600.000000,
                "executed_amount" => 20.314400,
                "executed_quantity" => 0.000379,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:06:40",
                "created_at" => "2021-12-16 12:06:40",
                "updated_at" => "2021-12-16 12:06:41",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 11,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 31,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "8506",
                "exchange_trade_ref" => "43199",
                "requested_price" => 53600.000000,
                "requested_quantity" => 0.000373,
                "executed_price" => 53600.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000373,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:07:12",
                "created_at" => "2021-12-16 12:06:41",
                "updated_at" => "2021-12-16 12:07:12",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 12,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 32,
                "requested_amount" => 20.328500,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "31",
                "exchange_order_ref" => "50558",
                "exchange_trade_ref" => "71701",
                "requested_price" => 54500.000000,
                "requested_quantity" => 0.000373,
                "executed_price" => 54500.000000,
                "executed_amount" => 20.328500,
                "executed_quantity" => 0.000373,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:07:12",
                "created_at" => "2021-12-16 12:07:12",
                "updated_at" => "2021-12-16 12:07:12",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 12,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 33,
                "requested_amount" => 20.000000,
                "side" => "BUY",
                "comment" => "Initial buy",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => null,
                "exchange_order_ref" => "71384",
                "exchange_trade_ref" => "70668",
                "requested_price" => 54500.000000,
                "requested_quantity" => 0.000367,
                "executed_price" => 54500.000000,
                "executed_amount" => 20.000000,
                "executed_quantity" => 0.000367,
                "status" => 1,
                "trade_type" => "INITIAL-BUY",
                "closed_at" => "2021-12-16 12:09:16",
                "created_at" => "2021-12-16 12:07:13",
                "updated_at" => "2021-12-16 12:09:16",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 13,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ], [
                "id" => 34,
                "requested_amount" => 20.331800,
                "side" => "SELL",
                "comment" => "Sell all",
                "failure_reason" => null,
                "exchange_order_status" => "SUCCESS",
                "original_orders" => "33",
                "exchange_order_ref" => "72169",
                "exchange_trade_ref" => "82170",
                "requested_price" => 55400.000000,
                "requested_quantity" => 0.000367,
                "executed_price" => 55400.000000,
                "executed_amount" => 20.331800,
                "executed_quantity" => 0.000367,
                "status" => 1,
                "trade_type" => "SELL-ALL",
                "closed_at" => "2021-12-16 12:09:15",
                "created_at" => "2021-12-16 12:09:15",
                "updated_at" => "2021-12-16 12:09:16",
                "deleted_at" => null,
                "bot_id" => 1,
                "session_id" => 13,
                "symbol_id" => 1,
                "user_id" => 2,
                "cover_id" => null
            ]
        ];
        Trade::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
