<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Rank;
use App\Models\Product;
use App\Models\CbmMtFourAccount;
use App\Models\UserAlert;
use App\Models\OrderLineItem;
use App\Models\Order;
use Http;
use Illuminate\Support\Facades\Auth;

use App\Models\Allwallettransaction;

class HomeController
{
    public function index()
    {
        $orderids = Order::where('user_id',auth()->user()->id)->pluck('id')->toArray();
        $total_cashback = OrderLineItem::where(['product_sku' => 'cbm_cashback'])->whereIn('order_id',$orderids)->sum('item_qty');
        $balance = CbmMtFourAccount::where('email_address',auth()->user()->email)->first();
        $products = Product::with(['category', 'media'])->where([ 'is_featured' => 1])->get();
        $alerts = \Auth::user()->userUserAlerts()
                    ->where([ 'show_hide' => 1])
                    ->whereRaw("find_in_set('1',type)")
                    ->get();
        
        $user_email = auth()->user()->email;
        $response = Http::withHeaders([
            'Token' => 'ab40db25fc6bde0eb707f68b8184d57c'
            //'Token' => env('BINANCE_TOKEN')
        ])->get('https://bottrader.perpetualmarkets.com/api/getBinanceBalance', [
            'email' => $user_email
        ]);
        $response = json_decode($response->body());
        
        return view('frontend.home',compact('products','balance','alerts','response', 'total_cashback'));
    }

    public function logout() {
        Auth::logout();
        return \redirect('sio/login');
    }
    public function indexCashback($id)
    {   
        $url_user_id = $id;
        return view('frontend.home_cashback',compact('url_user_id'));
    }
    
    public function geneologyCashBack($id)
    {   
        $url_user_id = $id;
        return view('frontend.geneology_cashback',compact('url_user_id'));
    }

    public function affiliate()
    {
        $affiliate = auth()->user();
        $rank_name = "";
        if(!empty($affiliate['rank_id'])){
            $rank = Rank::where(['id' => $affiliate['rank_id']])->first();
            $rank_name = $rank['name'];
        }
        $wallet = Allwallettransaction::where(['user_id' => $affiliate['id'],'transaction_type' => 1,"transaction_status"=>3,'reference_id'=>14])->sum('amount');
        $no_of_child = User::where(['sponsor_id' => $affiliate['id']])->count();
        return view('frontend.affiliate',compact('affiliate','no_of_child','rank_name','wallet'));
    }
}
