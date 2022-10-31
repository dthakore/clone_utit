<?php

namespace App\Http\Controllers\sio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Country;
use App\Helpers\SIOHelper;
use App\Helpers\CurlHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SIOActivationEmail;

class RegisterController extends Controller
{
    public function showVerifyEmailForm(Request $request)
    {
        $user = User::where('id','=', $request->id)->first();
        if($user) {
            session(['sponsor_id' => $request->id]);
            return view('sio.verify-email');
        } else {
            return abort(404);
        }
    }

    public function verifyEmail(Request $request)
    {
        $response = [];
        if($request->input('email')){
            $response = SIOHelper::verifyEmail($request->input('email'));
            session(['email' => $request->input('email')]);
        }
        return response()->json($response);
    }

    public function register(Request $request){
        $sioData = 0;
        $user = new User;
        if($request->input('token')){
            //Verify portal token with SSO
            $url = env('SIO_URL').'/api/verifyPortalToken';
            $data = [
                'portal_token' => $request->input('token')
            ];

            $sio_response = CurlHelper::apiCall("POST", $url, $data);
            if($sio_response['status'] == true){
                $sio_success_response = $sio_response['data'];
                if($sio_success_response['status'] == 1){
                    $sioData = 1;
                    session(['user_present_in_sso' => $request->input('token')]);
                    $user->fill(SIOHelper::modifyPostData($sio_success_response['data']['user_info']));
                    $user->sponsor_id = session()->get('sponsor_id');
                    $user->is_active = 1;
                    $user->auth = $this->randomString(20);
                    $user->created_at = now();
                    $user->save();
                    $message = 'Email verified successfully. You can proceed with login.';
                }else{
                    $message = 'Email verification failed. Please try again.';
                }
            }else{
                $message = 'Something went wrong. Please try again.';
            }
            return view('auth.signInSSO')->withMessages($message);
        } else {
            if(session()->has('email')){
                $user->email = session()->get('email');
            }
            if(session()->has('old_name') || session()->has('old_country_id')){
                $user->name = session()->get('old_name');
                $user->country_id = session()->get('old_country_id');
                session()->forget(['old_name', 'old_country_id']);
            }
            $countries = Country::pluck('name', 'id')->prepend('Country', '');

            return view('sio.register', compact('user', 'sioData', 'countries'));
        }
    }

    public function registerUser(Request $request){
        try{
            $inputs = $request->all();
            unset($inputs['_token']);
            if($request->has('password')){
                $validated = Validator::make($inputs, [
                    'name'       => ['required', 'regex:/^[a-zA-Z0-9\s]+$/', 'max:255'],
                    'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password'   => ['required', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[#?!@$%^&*()-+=]).{8,}$/'],
                    'country_id' => ['required'],
                ]);
            }else{
                $validated = Validator::make($inputs, [
                    'name'       => ['required', 'regex:/^[a-zA-Z0-9\s]+$/', 'max:255'],
                    'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'country_id' => ['required'],
                ]);
            }
            if ($validated->fails()) {
                foreach($validated->errors()->toArray() as $key => $error){
                    $message = implode("\n", $error);
                    if($key == 'email'){
                        session(['email_address' => $message]);
                    }else{
                        session([$key => $message]);    
                    }
                }
                foreach($inputs as $field => $input){
                    if(!in_array($field, ['password', 'password_confirmation'])){
                        session(['old_'.$field => $input]);    
                    }
                }
                return response()->json(['status' => false]);
            } else {
                $sioData = 0;
                $apiToken = null;
                $user = new User;

                if(session()->has('verified_email')){
                    $user->email = session()->get('verified_email');
                    session()->forget('verified_email');
                }

                if(session()->has('user_present_in_sso')){
                    $url = env('SIO_URL').'/api/verifyPortalToken';
                    $data = [
                        'portal_token' => session()->get('user_present_in_sso')
                    ];
                    $sio_response = CurlHelper::apiCall("POST", $url, $data);
                    if($sio_response['status'] == true){
                        $sio_success_response = $sio_response['data'];
                        if($sio_success_response['status'] == 1){
                            $user->fill(SIOHelper::modifyPostData($sio_success_response['data']['user_info']));
                            $apiToken = $sio_success_response['data']['user_info']['api_token'];
                            $sioData = 1;
                        }
                    }
                }

                if (!empty($inputs)) {
                    $modified_data = SIOHelper::modifyUserData($inputs);
                    if(session()->has('sponsor_id')){
                        $id = session()->get('sponsor_id');
                        $modified_data['sponsor_id'] = $id;
                        $modified_data['application'] = env('APP_NAME');
                        $url = env('SIO_URL');
                        if($sioData == 0){
                            //create user
                            $user_response = CurlHelper::apiCall("POST", $url."/api/createUser", $modified_data);
                        } else {
                            //update user
                            $modified_data['token'] = $apiToken;
                            $user_response = CurlHelper::apiCall("POST", $url."/api/updateUser", $modified_data);
                        }
                        if($user_response['status'] == true && $user_response['data']['status'] == 1){
                            $user->fill(SIOHelper::modifyPostData($user_response['data']['data']));
                            $user->sponsor_id = $id;
                            $user->name = $modified_data['full_name'];
                            $user->password = isset($modified_data['password']) ? Hash::make($modified_data['password']) : null;
                            $user->auth = $this->randomString(20);
                            $user->created_at = now();
                            $user->save();

                            $data = [
                                'name' => $user->name,
                                'url' => url('sio/activation?key='.$user->auth),
                            ];
                            Mail::to($user->email)->send(new SIOActivationEmail($data));

                            $response['status'] = true;
                            $response['message'] = "We have sent a email verification link to your email address";
                        } else {
                            $response['status'] = false;
                            $response['message'] = "Some issue while registration at SIO. Kindly contact support";
                        }
                    }  else {
                        $response['status'] = false;
                        $response['message'] = "Sponsor Id not set";
                    }
                    session()->forget('user_present_in_sso');
                }else {
                    $response['status'] = false;
                    $response['message'] = "User data not found";
                }
                return response()->json($response);
            }
        }catch(Exception $error){
            Log::channel('sio')->info("registerUser: {$error->getLine()} {$error->getMessage()}");
            $response['status'] = false;
            $response['message'] = $error->getMessage();
            return response()->json($response);
        }
    }

    public function randomString($length = 6)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    public function accountActivation(Request $request)
    {
        $user = User::where('auth', $request->input('key'))->first();
        if (isset($user->id)) {
            $user->is_active = 1;
            $user->save();

            $url = env('SIO_URL').'/api/activateUser';
            $data['application'] = env('APP_NAME');;
            $data['email'] = $user->email;
            $data['is_active'] = 1;
            
            $sio_response = CurlHelper::apiCall("POST", $url, $data);
            if($sio_response['status'] == true){
                $sio_success_response = $sio_response['data'];
                if($sio_success_response['status'] == 1){
                    $message = 'Your account is active now. You can proceed with login.';
                }else{
                    $message = $sio_success_response['message'];
                }
            }else{
                $message = $sio_response['error'];
            }
        } else {
            $message = 'Your activation key is invalid. Please try again.';
        }
        return view('auth.signInSSO')->withMessages($message);
    }
}
