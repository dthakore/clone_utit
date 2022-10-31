<?php

namespace App\Helpers;
use App\Models\Puxeo;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class CronHelper {

    public static function executeCronJob($url, $data, $actionType):array {
        $result = [];
        $curl_action = curl_init();

        curl_setopt_array($curl_action, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $actionType,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl_action);
        $error = curl_error($curl_action);
        curl_close($curl_action);

        $result['success_response'] = json_decode($response, true);
        $result['error_response'] = json_decode($error, true);

        return $result;
    }

    /**
     * Use requested database
     * @return boolean
     */
    public static function useDatabase($db){
        $used = Puxeo::Where('database', $db)->first()->configure()->use();
        if(isset($used)){
            $response = true;
        }else {
            $response = false;
        }
        return $response;
    }
    public static function useDatabaseWithId($id){
        //dd(Puxeo::Where('id', $id)->first());
        $used = Puxeo::Where('id', $id)->first()->configure()->use();
        //dd($used);
        if(isset($used)){
            $response = true;
        }else {
            $response = false;
        }
        return $response;
    }

    /**
     * @param $log
     */
    public static function pusherLogs($logs, $channel, $event){
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            array('cluster' => env('PUSHER_APP_CLUSTER'))
        );

        $data['log'] = $logs;
        $pusher->trigger($channel, $event, $data);
    }
}

?>