<?php

namespace Database\Seeders;

use App\Models\Symbol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SymbolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Symbol::truncate();
        $data = [
            [
                "id" => 1,
                "title" => "Bitcoin",
                "name" => "BTCUSDT",
                "code" => "BTC",
                "created_at" => "2021-12-10 19:12:06",
                "updated_at" => "2021-12-10 19:12:11",
                "deleted_at" => null,
                "pair" => "BTC/USDT"
            ], [
                "id" => 2,
                "title" => "BNB",
                "name" => "BNBUSDT",
                "code" => "BNB",
                "created_at" => "2021-12-10 19:12:06",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "BNB/USDT"
            ], [
                "id" => 4,
                "title" => "Ethereum",
                "name" => "ETHUSDT",
                "code" => "ETH",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "ETH/USDT"
            ], [
                "id" => 6,
                "title" => "Solana",
                "name" => "SOLUSDT",
                "code" => "SOL",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "SOL/USDT"
            ], [
                "id" => 7,
                "title" => "Aave",
                "name" => "AAVEUSDT",
                "code" => "AAVE",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "AAVE/USDT"
            ], [
                "id" => 8,
                "title" => "Tron",
                "name" => "TRXUSDT",
                "code" => "TRX",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "TRX/USDT"
            ], [
                "id" => 9,
                "title" => "Ripple",
                "name" => "XRPUSDT",
                "code" => "XRP",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "XRP/USDT"
            ], [
                "id" => 10,
                "title" => "Cardano",
                "name" => "ADAUSDT",
                "code" => "ADA",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "ADA/USDT"
            ], [
                "id" => 11,
                "title" => "Polkadot",
                "name" => "DOTUSDT",
                "code" => "DOT",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "DOT/USDT"
            ], [
                "id" => 12,
                "title" => "Dogecoin",
                "name" => "DOGEUSDT",
                "code" => "DOGE",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "DOGE/USDT"
            ], [
                "id" => 13,
                "title" => "Litecoin",
                "name" => "LTCUSDT",
                "code" => "LTC",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "LTC/USDT"
            ], [
                "id" => 14,
                "title" => "Uniswap",
                "name" => "UNIUSDT",
                "code" => "UNI",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "UNI/USDT"
            ], [
                "id" => 15,
                "title" => "Terra",
                "name" => "LUNAUSDT",
                "code" => "LUNA",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "LUNA/USDT"
            ], [
                "id" => 16,
                "title" => "Bitcoin Cash",
                "name" => "BCHUSDT",
                "code" => "BCH",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "BCH/USDT"
            ], [
                "id" => 17,
                "title" => "Ethereum Classic",
                "name" => "ETCUSDT",
                "code" => "ETC",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "ETC/USDT"
            ], [
                "id" => 18,
                "title" => "ChainLink",
                "name" => "LINKUSDT",
                "code" => "LINK",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "LINK/USDT"
            ], [
                "id" => 19,
                "title" => "Polygon",
                "name" => "MATICUSDT",
                "code" => "MATIC",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "MATIC/USDT"
            ], [
                "id" => 20,
                "title" => "Stellar Lumens",
                "name" => "XLMUSDT",
                "code" => "XLM",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "XLM/USDT"
            ], [
                "id" => 21,
                "title" => "Monero",
                "name" => "XMRUSDT",
                "code" => "XMR",
                "created_at" => "2021-12-12 19:17:04",
                "updated_at" => null,
                "deleted_at" => null,
                "pair" => "XMR/USDT"
            ]
        ];
        Symbol::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
