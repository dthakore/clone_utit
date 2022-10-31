<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Country;
use App\Models\User;
use App\Models\Subscription;
use App\Models\OrderLineItem;
use App\Models\Order;
use App\Models\Product;
use App\Helpers\SIOHelper;
use App\Helpers\CurlHelper;

class ProfileController extends Controller
{
    public function index()
    {
        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $user = auth()->user();
        $country_name = "";
        if(!empty($user->country_id)){
            $country_name = Country::select('name')->where("id",auth()->user()->country_id)->first();
            $country_name = $country_name->name;
        }
        $sponsors = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $orders = Order::where('user_id',auth()->user()->id)->pluck('id')->toArray();
        $bot = 0;
        $platform = '';
        $price = [
            3 => 43.496,
            8 => 75.49,
            15 => 130,
            35 => 259
        ];
        $final_price = [];
        if(count($orders)>0){
            $orderlineitem = OrderLineItem::where(['product_sku' => 'NTTP1'])->whereIn('order_id',$orders)->orderBy('id', 'DESC')->first();
            if(!is_null($orderlineitem->comment)) {
                $bot = preg_replace('/\D/', '', $orderlineitem->comment);
            }
            $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
            $platform = Subscription::where(['user_id' => auth()->user()->id ,'product_id' => $platform_product_id->id])->first();
            if(($bot > 0) && isset($platform->cycle_end_at) && !empty($platform->cycle_end_at) && ($platform->cycle_end_at > date('Y-m-d H:i:s'))){
                $remaining_days = date_diff(date_create($platform->cycle_end_at),date_create(now()))->format('%a');
                foreach ($price as $key=>$value){
                    if($key == $bot){
                        $platform_price = $value;
                    }
                    if($key > $bot){
                        $final_price[$key] = round(($value - $platform_price) * $remaining_days / 365,2);
                    }
                }
            }
            else{
                $final_price = $price;
            }
        }
        return view('frontend.profile',compact('countries','user','sponsors','bot','platform','final_price','country_name'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $request->date_of_birth = date('d-m-Y', strtotime($request->date_of_birth));
        $inputs = $request->validated();

        $url = env('SIO_URL').'/api/updateUser';
        $inputs['application'] = env('APP_NAME');
        $inputs['token'] = $user->api_token;
        $inputs['first_name'] = $inputs['name'];
        $inputs['last_name'] = null;
        $inputs['country'] = $inputs['country_id'];
        $inputs['building_number'] = $inputs['building_num'];
        unset($inputs['name']);
        unset($inputs['country_id']);
        unset($inputs['building_num']);

        $sio_response = CurlHelper::apiCall("POST", $url, $inputs);
        if($sio_response['status'] == true){
            session(['audit_log' => "User {$user->id} updated profile", 'audit_log_category' => "Profile Update"]);

            $user->update($request->validated());
            $response = [
                'token' => 1,
                'message' =>  __('global.update_profile_success'),
            ];
        }else{
            $response = [
                'token' => 0,
                'message' =>  'Error while updating profile!! Please try again after some time or contact Support',
            ];
        }
        return response()->json($response);
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        $user = auth()->user();
        $inputs = $request->validated();

        $url = env('SIO_URL').'/api/updateUser';
        $inputs['application'] = env('APP_NAME');
        $inputs['token'] = $user->api_token;
        $inputs['email'] = $user->email;

        $sio_response = CurlHelper::apiCall("POST", $url, $inputs);
        if($sio_response['status'] == true){
            session(['audit_log' => "User {$user->id} changed password", 'audit_log_category' => "Change Password"]);

            $user->update($request->validated());
            $response = [
                'token' => 1,
                'message' =>  __('global.change_password_success'),
            ];
        }else{
            $response = [
                'token' => 0,
                'message' =>  'Error while changing password!! Please try again after some time or contact Support',
            ];
        }
        return response()->json($response);
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = auth()->user();

        if ($user->two_factor) {
            $message = __('global.two_factor.disabled');
        } else {
            $message = __('global.two_factor.enabled');
        }

        $user->two_factor = !$user->two_factor;

        $user->save();

        return redirect()->route('frontend.profile.index')->with('message', $message);
    }

    public function changePassword()
    {
        return view('frontend.password');
    }
}
