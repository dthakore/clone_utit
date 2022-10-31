<?php

namespace App\Http\Controllers\sio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CronHelper;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view('auth.signInSSO');
    }

    public function sioLogin(Request $request)
    {
        if(isset($request->token)){
            $user = User::where(['email' => $request->email])->first();
            if(isset($user->id)){
                $user->api_token = $request->token;
                $user->update();

                Auth::login($user);

                if(isset($request->source) && $request->source == 'bt'){
                    return redirect('checkout');
                }else{
                    return redirect('home');
                }
            }else{
                CronHelper::pusherLogs($request->token, 'sioLogout', 'sioLogout');

                return view('auth.signInSSO')->withMessages('You are not registered in UTIT. Please get a referral link or contact us for further information.');
            }
        }
    }

    public function sioLogout(Request $request)
    {
        $user = User::find(auth()->id());
        $user->api_token = null;
        $user->update();

        session()->forget('id');
        Auth::logout();
        $sio_url = env('SIO_URL').'/logout?application='.env('APP_NAME');
        return redirect($sio_url);
    }
}
