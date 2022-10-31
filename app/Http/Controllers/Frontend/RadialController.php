<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CbmUserLicenses;
use App\Models\UserPositionAccount;
use App\Models\MatrixFibo;
use App\Helpers\MatrixHelper;

class RadialController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $nodeLevelCounter = [];
        // $finalDataArr = $userInfoArray = $CbmUserLicensesArray = $levelTwo = []; 
        // $firstTierClients = $firstTierLicenses = $secondTierClients = $secondTierLicenses = $levelOneClientCount = 0;

        /*$userInfo = User::all();
	    foreach ($userInfo as $ui) {
            $userInfoArray[$ui->sponsor_id][] = $ui;
        }

        $CbmUserLicenses = CbmUserLicenses::all();
	    foreach ($CbmUserLicenses as $ul) {
            $CbmUserLicensesArray[$ul->email] = $ul;
        }

        if(isset($userInfoArray[$user->id])) {
            $levelOneChilds = $userInfoArray[$user->id];
        } else {
            $levelOneChilds = [];
        }

        foreach ($levelOneChilds as $levelOneChild){
            $firstTierClients++;
            $temp = [];
            if($levelOneChild->privacy_disclosure == 0){
                $temp['name'] = $levelOneChild->name;
                $temp['email'] = $levelOneChild->email;
            } else {
                $temp['name'] = MatrixHelper::hideStringGenealogy($levelOneChild->id);
                $temp['email'] = MatrixHelper::hideEmailGenealogy($levelOneChild->id);
            }

            if(isset($CbmUserLicensesArray[$levelOneChild->email])){
                $levelOneUserLicenses = $CbmUserLicensesArray[$levelOneChild->email];
                $temp['license_count'] = $levelOneUserLicenses->total_licenses;
                $temp['active_license_count'] = $levelOneUserLicenses->total_licenses - $levelOneUserLicenses->available_licenses;
            } else {
                $temp['license_count'] = 0;
                $temp['active_license_count'] = 0;
            }
            $firstTierLicenses += $temp['license_count'];

            $levelTwoChilds = [];
            if(isset($userInfoArray[$levelOneChild->id])) {
                $levelTwoChilds = $userInfoArray[$levelOneChild->id];
            }

            foreach ($levelTwoChilds as $levelTwoChild){
                $secondTierClients++;
                $temp2 = [];
                $levelOneClientCount++;
                $temp2['name'] = MatrixHelper::hideStringGenealogy($levelTwoChild->id);
                if(isset($CbmUserLicensesArray[$levelTwoChild->email])) {
                    $levelTwoUserLicenses = $CbmUserLicensesArray[$levelTwoChild->email];
                    $temp2['license_count'] = $levelTwoUserLicenses->total_licenses;
                } else {
                    $temp2['license_count'] = 0;
                }
                $secondTierLicenses += $temp2['license_count'];
                $temp2['client_count'] = User::where('sponsor_id', $levelTwoChild->id)->count();
                array_push($levelTwo, $temp2);
            }
            $temp['inner_level'] = $levelTwo;
            $temp['client_count'] = $levelOneClientCount;
            array_push($finalDataArr, $temp);
        }*/

        //Radial Tree development
        $accountNum = UserPositionAccount::select('user_account_num')
                ->where('email_address', $user->email)
                ->whereNotNull('matrix_node_num')
                ->orderBy('added_to_matrix_at')
                ->orderBy('matrix_node_num')
                ->first();
        $radialTreeAccountNum = isset($accountNum->user_account_num) ? $accountNum->user_account_num : null;

        $levels = 12;
        for($i=1; $i<=$levels; $i++){
            $nodeLevelCounter[$i] = 0;
        }
        //By default, for level 1, counter is 1
        $nodeLevelCounter[1] = 1;
        $matrixSchemeArray = MatrixHelper::getMatrixNodesArray();
        $matrixPercentageArray = MatrixHelper::getMatrixPercentageArray();

        if(!is_null($radialTreeAccountNum)){
            $presentNode = MatrixFibo::where('accountNum', $radialTreeAccountNum)->first();
            $nodeLevelCounter = MatrixHelper::nodeCalc($presentNode->id, 1, $nodeLevelCounter);
        } else {
            $nodeLevelCounter[1] = 0;
        }

        return view('frontend.radial.index', compact('nodeLevelCounter', 'matrixSchemeArray', 'matrixPercentageArray'));
    }

    public function matrixData(Request $request){
        try {
            $user = auth()->user();

            //Radial Tree development
            if(isset($request->accountNum) && $request->accountNum != null){
                $radialTreeAccountNum = $request->accountNum;
                $checkValidity = UserPositionAccount::select('user_account_num')
                        ->where('email_address', $user->email)
                        ->orWhere('beneficiary', $user->email)
                        ->where('user_account_num', $radialTreeAccountNum)
                        ->first();
                if(!isset($checkValidity->user_account_num)){
                    $radialTreeAccountNum = null;
                }
            } else {
                $accountNum = UserPositionAccount::select('user_account_num')
                        ->where('email_address', $user->email)
                        ->orWhere('beneficiary', $user->email)
                        ->whereNotNull('matrix_node_num')
                        ->orderBy('added_to_matrix_at')
                        ->orderBy('matrix_node_num')
                        ->first();
                $radialTreeAccountNum = isset($accountNum->user_account_num) ? $accountNum->user_account_num : null;
            }

            $nodeLevelCounter = [];
            $levels = 12;
            for($i=1; $i<=$levels; $i++){
                $nodeLevelCounter[$i] = 0;
            }
            //By default, for level 1, counter is 1
            $nodeLevelCounter[1] = 1;
            $matrixSchemeArray = MatrixHelper::getMatrixNodesArray();
            $matrixPercentageArray = MatrixHelper::getMatrixPercentageArray();

            if(!is_null($radialTreeAccountNum)){
                $presentNode = MatrixFibo::where('accountNum', $radialTreeAccountNum)->first();
                $matrixData = MatrixFibo::where('id', '>=', $presentNode->id)->orderBy('id')->orderBy('created_at')->get();
                $nodeLevelCounter = MatrixHelper::nodeCalc($presentNode->id, 1, $nodeLevelCounter);
            } else {
                $matrixData = [];
                $nodeLevelCounter[1] = 0;
            }

            $response['status'] = 1;
            $response['data'] = $matrixData;
            $response['nodeLevelCounter'] = $nodeLevelCounter;
            $response['matrixSchemeArray'] = $matrixSchemeArray;
            $response['matrixPercentageArray'] = $matrixPercentageArray;
        } catch (Exception $e){
	        $response['status'] = 0;
	        $response['message'] = $e->getMessage();
        }
        ob_start('ob_gzhandler');
        return response()->json($response);
    }

    /* fetch node by type */
    public function allNode(Request $request){
        try {
	        if(isset($request->type) && !empty($request->type)){
                $user = auth()->user();
                if($request->type == "All"){
                    $allNodes = UserPositionAccount::where('beneficiary', $user->email)
                            ->whereNotNull('matrix_node_num')
                            ->orderBy('added_to_matrix_at')
                            ->orderBy('matrix_node_num')
                            ->pluck('user_account_num')->toArray();
                }else{
                    $allNodes = UserPositionAccount::where('type', $request->type)
                            ->where('beneficiary', $user->email)
                            ->whereNotNull('matrix_node_num')
                            ->orderBy('added_to_matrix_at')
                            ->orderBy('matrix_node_num')
                            ->pluck('user_account_num')->toArray();
                }
                $response['status'] = 1;
                $response['data'] = $allNodes;
            } else {
                $response['status'] = 0;
                $response['message'] = "Node type not found";
            }
        } catch (Exception $e){
	        $response['status'] = 0;
	        $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    /* find parent node */
    public function goToParent(Request $request){
        try {
	        if(isset($request->nodeNum) && !empty($request->nodeNum)){
                $node = MatrixFibo::where('accountNum', $request->nodeNum)->first();
                if(!is_null($node->id)){
                    $parentNode = MatrixFibo::select('accountNum')
                                ->where('lchild', $node->id)
                                ->orWhere('rchild', $node->id)
                                ->first();
                }

                if(isset($parentNode->accountNum)){
                    $response['status'] = 1;
                    $response['data'] = $parentNode->accountNum;
                }else{
                    $response['status'] = 0;
                    $response['message'] = "Parent node not found";    
                }
            } else {
                $response['status'] = 0;
                $response['message'] = "Node not found";
            }
        } catch (Exception $e){
	        $response['status'] = 0;
	        $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function calculateNodeChild(Request $request){
	    $response = [];
	    try {
	        if(isset($request->nodeId)){
                $node = MatrixFibo::find($request->nodeId);
                $nodeLevelCounter = [];
                $levels = 12;
                for($i=1; $i<=$levels; $i++){
                    $nodeLevelCounter[$i] = 0;
                }
                //By default, for level 1, counter is 1
                $nodeLevelCounter[1] = 1;
                $nodeLevelCounter = MatrixHelper::nodeCalc($node->id, 1, $nodeLevelCounter);
                $response['status'] = 1;
                $response['data'] = $nodeLevelCounter;
            } else {
                $response['status'] = 0;
                $response['message'] = "NodeId is required";
            }
        } catch (Exception $e){
	        $response['status'] = 0;
	        $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
}
