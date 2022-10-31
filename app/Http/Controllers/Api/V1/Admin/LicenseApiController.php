<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Subscription;
use App\Models\OrderLineItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;

class LicenseApiController extends Controller
{

    public function validatePlatformKey(Request $request){
        $inputs = $request->all();
        $header = $request->header('Token');
        if(isset($header) && !empty($header) && ($header == env('API_TOKEN'))){
            if(isset($inputs['platform_key']) && !empty($inputs['platform_key'])){
                if(isset($inputs['bot_count'])){
                    $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
                    $platform = Subscription::where(['licence_key' => $inputs['platform_key'] ,'product_id' => $platform_product_id->id])->first();
                    if(is_null($platform)){
                        return response()->json([
                            'result' => false,
                            'message' => ["Your Key is invalid"],
                            "data" => new \stdClass()
                        ]);
                    }
                    elseif($platform->cycle_end_at < date('Y-m-d H:i:s')){
                        return response()->json([
                            'result' => false,
                            'message' => ["Opps! your license key is expired"],
                            "data" => new \stdClass()
                        ]);
                    }
                    elseif($platform->is_used == 1){
                        return response()->json([
                            'result' => false,
                            'message' => ["This licence key is already in use."],
                            "data" => new \stdClass()
                        ]);
                    }
                    else{
                        $orders = Order::where(['user_id' => $platform->user_id])->get();
                        $order_ids = [];
                        if(!is_null($orders)){
                            foreach ($orders as $order){
                                array_push($order_ids,$order->id);
                            }
                            $order_line_item = OrderLineItem::where(['product_sku' => "NTTP1"])->whereIn('order_id' , $order_ids)->orderBy('id', 'DESC')->first();
                            if(!is_null($order_line_item->comment)){
                                $bot = preg_replace('/\D/', '', $order_line_item->comment);
//                                        $product_id = Product::where(['sku' => 'NTBOT'])->first();
//                                        $used_bot = Subscription::where(['product_id' => $product_id->id, 'is_used' => 1])->count();
//                                        $available_bot = $bot - $used_bot;
                                if(!is_null($bot) && ($bot > 0)){
                                    if($inputs['bot_count'] == 0){
                                        if(isset($inputs['is_used']) && ($inputs['is_used'] == 1)) {
                                            Subscription::where('subscription_id', $platform->subscription_id)->update(['is_used' => 1]);
                                        }
                                        return response()->json([
                                            'result' => true,
                                            'message' => ["Your key is valid"],
                                            "data" => [
                                                "remaining_bot" => $bot,
                                                "cycle_start_at" => $order_line_item->created_at,
                                                "cycle_end_at" => $order_line_item->cycle_ends_at
                                            ]
                                        ]);
                                    }
                                    else{
                                        $available_bot = $bot - $inputs['bot_count'];
                                        if($available_bot <= 0){
                                            return response()->json([
                                                'result' => false,
                                                'message' => ["Opps! you can't create new bot.Please upgrade your platform licence"],
                                                "data" => [
                                                    "remaining_bot" => 0
                                                ]
                                            ]);
                                        }
                                        else{
                                            return response()->json([
                                                'result' => true,
                                                'message' => ["your ".$available_bot." bot is remaining"],
                                                "data" => [
                                                    "remaining_bot" => $available_bot,
                                                    "cycle_start_at" => $order_line_item->created_at,
                                                    "cycle_end_at" => $order_line_item->cycle_ends_at
                                                ]
                                            ]);
                                        }
                                    }
                                }
                            }
                            else{
                                return response()->json([
                                    'result' => false,
                                    'message' => ["Your Key is invalid"],
                                    "data" => new \stdClass()
                                ]);
                            }

                        }
                        else{
                            return response()->json([
                                'result' => false,
                                'message' => ["Your Key is invalid"],
                                "data" => new \stdClass()
                            ]);
                        }

                    }

                }
                else{
                    return response()->json([
                        'result' => false,
                        'message' => ["Please give Bot Count"],
                        "data" => new \stdClass()
                    ]);
                }
            }
            else{
                return response()->json([
                    'result' => false,
                    'message' => ["Please give Platform Key"],
                    "data" => new \stdClass()
                ]);
            }
        }
        else{
            return response()->json([
                'result' => false,
                'message' => ["Please enter correct Token"],
                "data" => new \stdClass()
            ]);
        }
    }

//    public function validatePlatformKey(Request $request){
//        $inputs = $request->all();
//        $header = $request->header('Token');
//        if(isset($header) && !empty($header) && ($header == env('API_TOKEN'))){
//            if(isset($inputs['platform_key']) && !empty($inputs['platform_key'])){
//                if(isset($inputs['user_email']) && !empty($inputs['user_email'])){
//                    if(isset($inputs['bot_count'])){
//                        $user = User::where(['email' => $inputs['user_email']])->first();
//                        if(is_null($user)){
//                            return response()->json([
//                                'result' => false,
//                                'message' => ["Please give Correct Email"],
//                                "data" => new \stdClass()
//                            ]);
//                        }
//                        else{
//                            $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
//                            $platform = Subscription::where(['licence_key' => $inputs['platform_key'] , 'user_id' => $user->id,'product_id' => $platform_product_id->id])->first();
//                            if(is_null($platform)){
//                                return response()->json([
//                                    'result' => false,
//                                    'message' => ["Your Key is invalid"],
//                                    "data" => new \stdClass()
//                                ]);
//                            }
//                            elseif($platform->cycle_end_at < date('Y-m-d H:i:s')){
//                                return response()->json([
//                                    'result' => false,
//                                    'message' => ["Opps! your license key is expired"],
//                                    "data" => new \stdClass()
//                                ]);
//                            }
//                            else{
//                                $orders = Order::where(['user_id' => $user->id])->get();
//                                $order_ids = [];
//                                if(!is_null($orders)){
//                                    foreach ($orders as $order){
//                                        array_push($order_ids,$order->id);
//                                    }
//                                    $order_line_item = OrderLineItem::where(['product_sku' => "NTTP1"])->whereIn('order_id' , $order_ids)->orderBy('id', 'DESC')->first();
//                                    if(!is_null($order_line_item->comment)){
//                                        $bot = preg_replace('/\D/', '', $order_line_item->comment);
////                                        $product_id = Product::where(['sku' => 'NTBOT'])->first();
////                                        $used_bot = Subscription::where(['product_id' => $product_id->id, 'is_used' => 1])->count();
////                                        $available_bot = $bot - $used_bot;
//                                        if(!is_null($bot) && ($bot > 0)){
//                                            if($inputs['bot_count'] == 0){
//                                                return response()->json([
//                                                    'result' => true,
//                                                    'message' => ["Your key is valid"],
//                                                    "data" => [
//                                                        "remaining_bot" => $bot
//                                                    ]
//                                                ]);
//                                            }
//                                            else{
//                                                $available_bot = $bot - $inputs['bot_count'];
//                                                if($available_bot <= 0){
//                                                    return response()->json([
//                                                        'result' => false,
//                                                        'message' => ["Opps! you can't create new bot.Please upgrade your platform licence"],
//                                                        "data" => [
//                                                            "remaining_bot" => 0
//                                                        ]
//                                                    ]);
//                                                }
//                                                else{
//                                                    return response()->json([
//                                                        'result' => true,
//                                                        'message' => ["your ".$available_bot." bot is remaining"],
//                                                        "data" => [
//                                                            "remaining_bot" => $available_bot
//                                                        ]
//                                                    ]);
//                                                }
//                                            }
//                                        }
//                                    }
//                                    else{
//                                        return response()->json([
//                                            'result' => false,
//                                            'message' => ["Your Key is invalid"],
//                                            "data" => new \stdClass()
//                                        ]);
//                                    }
//
//                                }
//                                else{
//                                    return response()->json([
//                                        'result' => false,
//                                        'message' => ["Your Key is invalid"],
//                                        "data" => new \stdClass()
//                                    ]);
//                                }
//
//                            }
//
//                        }
//
//                    }
//                    else{
//                        return response()->json([
//                            'result' => false,
//                            'message' => ["Please give Bot Count"],
//                            "data" => new \stdClass()
//                        ]);
//                    }
//                }
//                else{
//                    return response()->json([
//                        'result' => false,
//                        'message' => ["Please give Email"],
//                        "data" => new \stdClass()
//                    ]);
//                }
//            }
//            else{
//                return response()->json([
//                    'result' => false,
//                    'message' => ["Please give Platform Key"],
//                    "data" => new \stdClass()
//                ]);
//            }
//        }
//        else{
//            return response()->json([
//                'result' => false,
//                'message' => ["Please enter correct Token"],
//                "data" => new \stdClass()
//            ]);
//        }
//    }

    public function validateBotKey(Request $request){
        $inputs = $request->all();
        $header = $request->header('Token');
        if(isset($header) && !empty($header) && ($header == env('API_TOKEN'))){
            if(isset($inputs['bot_key']) && !empty($inputs['bot_key'])){
                $bot_product_id = Product::where(['sku' => 'NTBOT'])->first();
                $bot = Subscription::where(['licence_key' => $inputs['bot_key'] ,'status' => 'active' ,'product_id' => $bot_product_id->id])->first();
                if(is_null($bot)){
                    return response()->json([
                        'result' => false,
                        'message' => ["Your Key is invalid"],
                        "data" => new \stdClass()
                    ]);
                }
                else{
                    if(isset($inputs['is_used'])){
                        if ($inputs['is_used'] == 0) {
                            if($bot->is_used == 0){
                                return response()->json([
                                    'result' => true,
                                    'message' => ["You can use this bot"],
                                    "data" => [
                                        "expire_date" => $bot->cycle_end_at
                                    ]
                                ]);
                            }
                            else{
                                return response()->json([
                                    'result' => false,
                                    'message' => ["This licence is already in use"],
                                    "data" => new \stdClass()
                                ]);
                            }

                        }
                        else{
                            Subscription::where('subscription_id',$bot->subscription_id)->update(['is_used' => 1]);
                            return response()->json([
                                'result' => true,
                                'message' => ["You successfully used this licence."],
                                "data" => [
                                    "expire_date" => $bot->cycle_end_at
                                ]
                            ]);
                        }
                    }
                    elseif (isset($inputs['is_deleted'])){
                        if ($inputs['is_deleted'] == 1) {
                            Subscription::where('subscription_id',$bot->subscription_id)->update(['is_used' => 0,]);
                            return response()->json([
                                'result' => true,
                                'message' => ["We removed bot from licence."],
                                "data" => new \stdClass()
                            ]);
                        }
                    }
                    else{
                        return response()->json([
                            'result' => false,
                            'message' => ["Please give Bot used flag"],
                            "data" => new \stdClass()
                        ]);
                    }
                }
            }
            else{
                return response()->json([
                    'result' => false,
                    'message' => ["Please give Bot Key"],
                    "data" => new \stdClass()
                ]);
            }
        }
        else{
            return response()->json([
                'result' => false,
                'message' => ["Please enter correct Token"],
                "data" => new \stdClass()
            ]);
        }
    }

    public function BotCount(Request $request){
        $inputs = $request->all();
        $header = $request->header('Token');
        if(isset($header) && !empty($header) && ($header == env('API_TOKEN'))){
            if(isset($inputs['platform_key']) && !empty($inputs['platform_key'])){
                if(isset($inputs['bot_count'])){
                    $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
                    $platform = Subscription::where(['licence_key' => $inputs['platform_key'] ,'product_id' => $platform_product_id->id])->first();
                    if(is_null($platform)){
                        return response()->json([
                            'result' => false,
                            'message' => ["Your Key is invalid"],
                            "data" => new \stdClass()
                        ]);
                    }
                    elseif($platform->cycle_end_at < date('Y-m-d H:i:s')){
                        return response()->json([
                            'result' => false,
                            'message' => ["Opps! your license key is expired"],
                            "data" => new \stdClass()
                        ]);
                    }
                    else{
                        $orders = Order::where(['user_id' => $platform->user_id])->get();
                        $order_ids = [];
                        if(!is_null($orders)){
                            foreach ($orders as $order){
                                array_push($order_ids,$order->id);
                            }
                            $order_line_item = OrderLineItem::where(['product_sku' => "NTTP1"])->whereIn('order_id' , $order_ids)->orderBy('id', 'DESC')->first();
                            if(!is_null($order_line_item->comment)){
                                $bot = preg_replace('/\D/', '', $order_line_item->comment);
//                                        $product_id = Product::where(['sku' => 'NTBOT'])->first();
//                                        $used_bot = Subscription::where(['product_id' => $product_id->id, 'is_used' => 1])->count();
//                                        $available_bot = $bot - $used_bot;
                                if(!is_null($bot) && ($bot > 0)){
                                    $available_bot = $bot - $inputs['bot_count'];
                                    if($available_bot <= 0){
                                        return response()->json([
                                            'result' => false,
                                            'message' => ["Opps! you can't create new bot.Please upgrade your platform licence"],
                                            "data" => [
                                                "remaining_bot" => 0,
                                                "current_bot_license" => (int)$bot
                                            ]
                                        ]);
                                    }
                                    else{
                                        return response()->json([
                                            'result' => true,
                                            'message' => ["your ".$available_bot." bot is remaining"],
                                            "data" => [
                                                "remaining_bot" => $available_bot,
                                                "current_bot_license" => (int)$bot
                                            ]
                                        ]);
                                    }
                                }
                            }
                            else{
                                return response()->json([
                                    'result' => false,
                                    'message' => ["Your Key is invalid"],
                                    "data" => new \stdClass()
                                ]);
                            }

                        }
                        else{
                            return response()->json([
                                'result' => false,
                                'message' => ["Your Key is invalid"],
                                "data" => new \stdClass()
                            ]);
                        }

                    }

                }
                else{
                    return response()->json([
                        'result' => false,
                        'message' => ["Please give Bot Count"],
                        "data" => new \stdClass()
                    ]);
                }
            }
            else{
                return response()->json([
                    'result' => false,
                    'message' => ["Please give Platform Key"],
                    "data" => new \stdClass()
                ]);
            }
        }
        else{
            return response()->json([
                'result' => false,
                'message' => ["Please enter correct Token"],
                "data" => new \stdClass()
            ]);
        }
    }

    public function platformUpgrade(Request $request){
        $inputs = $request->all();
        $header = $request->header('Token');
        if(isset($header) && !empty($header) && ($header == env('API_TOKEN'))){
            if(isset($inputs['platform_key']) && !empty($inputs['platform_key'])){
                if(isset($inputs['upgrade_subscription']) && !empty($inputs['upgrade_subscription'])){
                    $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
                    $subscription = Subscription::where(['licence_key' => $inputs['platform_key'] ,'product_id' => $platform_product_id->id])->first();
                    if(is_null($subscription)){
                        return response()->json([
                            'result' => false,
                            'message' => ["Your Key is invalid"],
                            "data" => new \stdClass()
                        ]);
                    }
                    elseif($subscription->cycle_end_at < date('Y-m-d H:i:s')){
                        return response()->json([
                            'result' => false,
                            'message' => ["Opps! your license key is expired"],
                            "data" => new \stdClass()
                        ]);
                    }
                    else{
                        $platform = explode('#', $inputs['upgrade_subscription']);
                        Cart::where(['user_id' => $subscription->user_id])->delete();
                        $cart = new Cart;
                        $cart->user_id = $subscription->user_id;
                        $cart->product_id = $platform_product_id->id;
                        $cart->product_qty = $platform[0];
                        $cart->product_price = round($platform[1] - ($platform[1] * 21)/121,2);
                        $cart->upgrade = 1;
                        $cart->created_at = now();
                        $cart->save();
                        return response()->json([
                            'result' => true,
                            'message' => ["Success"],
                            "data" => [
                                "URL" => env('SIO_URL').'/login?application='.env('APP_NAME').'&source=bt'
                            ]
                        ]);
                    }
                }
                else{
                    return response()->json([
                        'result' => false,
                        'message' => ["Please give Upgrade Plan detail"],
                        "data" => new \stdClass()
                    ]);
                }
            }
            else{
                return response()->json([
                    'result' => false,
                    'message' => ["Please give Platform Key"],
                    "data" => new \stdClass()
                ]);
            }

        }
        else{
            return response()->json([
                'result' => false,
                'message' => ["Please enter correct Token"],
                "data" => new \stdClass()
            ]);
        }
    }
}
