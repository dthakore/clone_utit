<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SIOEmailVerify;

class SIOHelper {

    /**
     * Verify email with System and SIO
     * @return array
     */
    public static function verifyEmail($email){
        try{
            $user = User::where('email', $email)->first();
            if(isset($user->id)){
                //Email exists in EazyBot itself. Kindly login
                $response['status'] = 3;
                $response['message'] = "Email exists in EazyBot itself. Kindly login";
            } else {
                //Verify with SIO
                $url = env('SIO_URL').'/api/verifyEmail';
                $data = [
                    'email' => $email,
                    'application' => env('APP_NAME')
                ];

                $sio_response = CurlHelper::apiCall("POST", $url, $data);
                if($sio_response['status'] == true){
                    $sio_success_response = $sio_response['data'];
                    if($sio_success_response['status'] == 1){
                        //Registration can begin
                        $response['status'] = 1;
                        $response['message'] = $sio_success_response['message'];
                        session(['verified_email' => $email]);
                    } elseif ($sio_success_response['status'] == 2){
                        //User is already registered at SIO. Please proceed registration with some necessary data.
                        $response['status'] = 2;
                        $response['message'] = "We see that you are already registered with Sign In Once.Please verify your email for proceeding with registration with your SIO account.";
                        $portalToken = $sio_success_response['data']['portal_token'];

                        $activationUrl = url('sio/register').'?token='.$portalToken;
                        $response['verification_url'] = $activationUrl;
                        Mail::to($sio_success_response['data']['email'])->send(new SIOEmailVerify($activationUrl));
                    } else {
                        $response['status'] = 0;
                        $response['message'] = $sio_success_response['message'];
                    }
                } else {
                    $response['status'] = 0;
                    $response['message'] = $sio_response['error'];
                }
            }
            return $response;
        }catch(Exception $error){
            Log::channel('sio')->info("verifyEmail: {$error->getLine()} {$error->getMessage()}");
            $response['status'] = 0;
            $response['message'] = $error->getMessage();
            return $response;
        }
    }

    public static function modifyPostData($data){
        self::setUnsetData($data, 'full_name', 'name');
        // self::setUnsetData($data, 'building_number', 'building_num');
        self::setUnsetData($data, 'country', 'country_id');
        // self::setUnsetData($data, 'business_building_number', 'bus_address_building_num');
        // self::setUnsetData($data, 'business_street', 'bus_address_street');
        // self::setUnsetData($data, 'business_region', 'bus_address_region');
        // self::setUnsetData($data, 'business_city', 'bus_address_city');
        // self::setUnsetData($data, 'business_postcode', 'bus_address_postcode');
        // self::setUnsetData($data, 'business_country', 'bus_address_country_id');
        return $data;
    }

    public static function modifyUserData($data){
        $name = self::split_name($data['name']);
        $data['first_name'] = $name['first_name'];
        $data['last_name'] = $name['last_name'];
        self::setUnsetData($data, 'name', 'full_name');
        self::setUnsetData($data, 'country_id', 'country');
        return $data;
    }

    public static function setUnsetData(&$data, $columnName, $newColumnName){
        $data[$newColumnName] = $data[$columnName];
        unset($data[$columnName]);
    }

    public static function split_name($name) {
        $parts = explode(" ", trim($name));
        $num = count($parts);
        if($num > 1){
            $lastname['last_name'] = array_pop($parts);
        }else{
            $lastname['last_name'] = '';
        }
        $firstname['first_name'] = implode(" ", $parts);
        return array_merge($firstname, $lastname);
    }
}
?>