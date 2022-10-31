<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserPositionAccount;
use App\Models\MatrixMetaTable;
use App\Models\CbmLogs;
use App\Models\MatrixFibo;

class MatrixHelper {

    /**
     * Derive a new cluster id
     * @return array
     */
    public static function getNewClusterId($login){

        $cbm_user_account = DB::select('select max(cluster) as cluster_id from user_position_accounts where login = :lg', ['lg' => $login]);
        if(is_null($cbm_user_account[0]->cluster_id)){
            $clusterId = 1;
        } else {
            $clusterId = $cbm_user_account[0]->cluster_id + 1;
        }
        return $clusterId;
    }

    /**
     * Return a parent node number
     * @return array
     */
    public static function getMatrixSponsor($userAccountNum, $matrixId){
        $systemUser = User::find(config('global.SystemUserId'));
        $userAccount = UserPositionAccount::where('user_account_num', '=', $userAccountNum)
                                        ->where('matrix', '=', $matrixId)
                                        ->where('email_address', '!=', $systemUser->email)
                                        ->first();
        $user = User::where('email', $userAccount->email_address)->first();
        $parentAccountNum = 0;
        if (isset($user->id)) {
            $parentNode = UserPositionAccount::where('email_address', $userAccount->email_address)
                                        ->whereNull('matrix_node_num')
                                        ->orderBy('matrix_node_num', 'asc')
                                        ->first();
            if (isset($parentNode->user_account_num)) {
                $parentAccountNum = $parentNode->user_account_num;
            } else {
                if ($user->sponsor_id != 1) {
                    $sponsor = User::find($user->sponsor_id);
                    $sponsorAccountNum = UserPositionAccount::where('email_address', $sponsor->email)
                                        ->whereNotNull('matrix_node_num')
                                        ->orderBy('matrix_node_num', 'asc')
                                        ->first();
                    if (isset($sponsorAccountNum->user_account_num)) {
                        $parentAccountNum = $sponsorAccountNum->user_account_num;
                    }
                } else {
                    $parentAccountNum = 'C001';
                }
            }
        }
        return $parentAccountNum;
    }

    /**
     * Add node to matrix table
     * @return array
     */
    public static function addToMatrix($accountNum, $parentAccountNum){
        //To check that the node is not a system node
        $systemUser = User::find(config('global.SystemUserId'));
        $tempAccount = UserPositionAccount::where('user_account_num', '=', $accountNum)
                                        ->where('email_address', '!=', $systemUser->email)
                                        ->first();
        $account = UserPositionAccount::where(['user_account_num' => $accountNum, 'email_address' => $tempAccount->email_address])->first();
        $matrix = MatrixMetaTable::find($account->matrix);
        $user = User::where('email', $account->email_address)->first();

        $isParentPresent = DB::table($matrix->table_name)
                            ->where('cbm_account_num', '=', $parentAccountNum)
                            ->first();
        if(!isset($isParentPresent->user_id)) {
            $logs = new CbmLogs;
            $logs->status = 1;
            $logs->created_at = now();
            $logs->total_accounts = 0;
            $logs->log = "Parent not present for account number ".$accountNum;
            $logs->save();
            return false;
        } else {
            $tmp = array();
            array_push($tmp, $user->id);
            $url = url('/fibo/api.php');
            $data = [
                "action" => "add",
                "parent" => $parentAccountNum,
                "count" => 1,
                "accounts" => $tmp,
                "cluster" => false,
                "email" => $user->email,
                "table_name" => $matrix->table_name
            ];
            $response = CronHelper::executeCronJob($url, json_encode($data), 'POST');
            $fibo_response = $response['success_response'];
            if($fibo_response['result'] == 1){
                //Update parent id in the matrix table
                $res = DB::table($matrix->table_name)
                        ->where('id', $fibo_response['data'][0])
                        ->update(['parent' => $isParentPresent->user_id, 'cbm_account_num' => $accountNum]);

                //Get ID from matrix table as node number
                $res = DB::table($matrix->table_name)
                        ->where('user_id', '=', $user->id)
                        ->where('id', '=', $fibo_response['data'][0])
                        ->first();

                $account->matrix_node_num = $res->id;
                $account->added_to_matrix_at = now();
                $account->save();

                return "User has been successfully added to Matrix";
            } else {
                return false;
            }
        }
        //return "Due to some technical reasons, we were not able to add Node to Matrix. Please contact development team";
    }

    /* for the Name hide after some words*/
    public static function hideStringGenealogy($id)
    {
        $userDetail = User::find($id);
        $end = str_repeat('*', strlen(substr($userDetail->name, 3)));
        $begin = substr($userDetail->name, 0, 3);
        return $begin . $end;
    }

    /* for the Email hide after some words*/
    public static function hideEmailGenealogy($id)
    {
        $userDetail = User::find($id);
        $mail_segments = explode("@", $userDetail->email);
        $mail_segments[0] = str_repeat("*", strlen($mail_segments[0]));
        return implode("@", $mail_segments);
    }

    /*
     * Get Max nodes that can be filled at fibo
     * */
    public static function getMatrixNodesArray(){
        $arr = [];
        $arr[1] = 1;
        $arr[2] = 1;
        $arr[3] = 2;
        $arr[4] = 3;
        $arr[5] = 5;
        $arr[6] = 8;
        $arr[7] = 13;
        $arr[8] = 21;
        $arr[9] = 34;
        $arr[10] = 55;
        $arr[11] = 89;
        $arr[12] = 144;

        return $arr;
    }

    /*
     * Get Matrix percentage
     * */
    public static function getMatrixPercentageArray(){
        $matrixScheme = DB::table('matrix_commission_scheme')->get();
        $arr = [];
        foreach ($matrixScheme as $value){
            $arr[$value->level] = $value->percentage;
        }
        return $arr;
    }

    public static function nodeCalc($nodeId, $level, $nodeLevelCounter){
	    if($level < 13){
            $node = MatrixFibo::find($nodeId);
            if(!is_null($node->lchild)){
                if($level < 12){
                    $nodeLevelCounter[$level + 1]++;
                    $nodeLevelCounter = self::nodeCalc($node->lchild, $level+1, $nodeLevelCounter);
                }
            }
            if(!is_null($node->rchild)){
                if($level < 11){
                    $nodeLevelCounter[$level+2]++;
                    $nodeLevelCounter = self::nodeCalc($node->rchild, $level+2, $nodeLevelCounter);
                }
            }
        }
        return $nodeLevelCounter;
    }
}
?>