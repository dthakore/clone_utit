<?php

namespace App\Helpers;

use App\Models\Allwallettransaction;
use App\Models\Bot;
use App\Models\SubscriptionPlanMeta;
use App\Models\Symbol;
use App\Models\User;
use App\Models\UserExchange;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class Helper
{
    /**
     * @param $key
     * @param $user_id
     * @return int
     */
    public static function productMeta($key, $user_id = null) {
        try {
            if($user_id == null) {
                $product_id = Auth::user()->product_id;
            } else {
                $product_id = User::where('id','=',$user_id)->select('product_id')->first();
            }
            return SubscriptionPlanMeta::where('plan_id','=',$product_id)->where('key','=', $key)->select('value')->first()->value;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return 0;
        }
    }

    /**
     * @param $user_id
     * @return int
     */
    public static function walletBalance($user_id = null) {
        try {
            if($user_id == null) {
                $user_id = Auth::id();
            }
            $balance = Allwallettransaction::selectRaw("SUM(COALESCE(CASE WHEN transaction_type = 1 THEN amount END,0)) - SUM(COALESCE(CASE WHEN transaction_type = 2 THEN amount END,0)) as balance")
                ->where('user_id','=', $user_id)
                ->where('transaction_status','=',3)
                ->first()->balance;
            if(!$balance) {
                $balance = 0;
            }
            return $balance;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return 0;
        }
    }

    /**
     * @param $bot_id
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function userBalance($exchange_id, $symbol_id)
    {
        try {
            $symbol = Symbol::where('id','=',$symbol_id)->first();
            $exchange = UserExchange::with('exchange')
                ->where('id','=', $exchange_id)
                ->where('user_id','=', Auth::id())
                ->first();
            $symbol = explode("/", $symbol->pair, 2)[1];
            $data = self::binanceCall($exchange, 'account');
            foreach ($data->balances as $balance) {
                if($symbol == $balance->asset) {
                    return $balance->free;
                }
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return 0;
        }
    }

    public static function botReserved() {
        try {
            $bots = Bot::with('symbol')
                ->where('user_id','=', Auth::id())
                ->get();
            $data = [];
            foreach ($bots as $bot) {
                $symbol = explode("/", $bot->symbol->pair, 2)[1];
                if(!isset($data[$symbol])) {
                    $data[$symbol] = 0;
                }
                $data[$symbol] = $data[$symbol] + $bot->balance;
            }
            return json_encode($data);
        } catch (\Exception $e) {
            return json_encode([]);
        }
    }

    /**
     * @param $bot
     * @param $end_point
     * @param string $type
     * @param array $params
     * @return false|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function binanceCall($user_exchange, $end_point, $type = 'GET', $params = []) {
        try {
            $timestamp = time()*1000;
            $client = new Client();
            $data = [
                "timestamp" => $timestamp,
            ];
            $data = array_merge($data, $params);
            $data['signature'] = hash_hmac("sha256", http_build_query($data), $user_exchange->secret);
            $response = $client->request($type, "{$user_exchange->exchange->api_url}/api/v3/{$end_point}", [
                'headers' => [
                    'Accept'     => 'application/json',
                    'X-MBX-APIKEY'=> $user_exchange->key
                ],
                "query" => $data,
                "debug" => false
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return 0;
        }
    }
}
