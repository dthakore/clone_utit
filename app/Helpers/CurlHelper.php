<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class CurlHelper {

    public static function apiCall($type, $url, $data){
        try{
            $client = new Client();
            $response = $client->request($type, $url,[
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            $result['status'] = true;
            $result['message'] = "Success";
            $result['data'] = $body;
            return $result;
        }catch(Exception $error){
            $result['status'] = false;
            $result['error'] = $error->getMessage();
            return $result;
        }
    }

}
?>