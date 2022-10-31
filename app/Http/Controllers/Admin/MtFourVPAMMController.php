<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MtFourBroker;
use App\Models\CbmMtFourAccount;
use App\Models\MtFourTrade;
use Illuminate\Support\Facades\Log;
use App\Helpers\CronHelper;
use Http;
use App\Http\Controllers\Traits\CsvImportTrait;


class MtFourVPAMMController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        $mtFourBrokers = MtFourBroker::get();
        return view('admin.vpamm.index',compact('mtFourBrokers'));
    }

    public function importApidata(Request $request)
    {
        try{
            ini_set('memory_limit', '-1');
            set_time_limit(0);

            $id         = $request->input('mtFourBroker');
            $startDate  = $request->input('StartDate');
            $endDate    = $request->input('EndDate');
            $mtFourBrokers = MtFourBroker::where('id', $id)->first();

            $channel = 'mtfourTrades';
            $event = 'accounts';

            $response = Http::withHeaders([
            ])->post('https://metamanager.utradeitrade.com/Mt4manager/Accounts/GetAccountsWithHistory', [
                "ServerLogin"     => $mtFourBrokers->server_login,
                "ServerPassword"  => $mtFourBrokers->server_password,
                "ServerAddress"   => $mtFourBrokers->server_address,
                "ServerPort"      => $mtFourBrokers->server_port,
                "StartDate"       => $startDate,
                "EndDate"         => $endDate
            ]);
            $response = json_decode($response->body());
            // dd($response)
            // $result;
            if(isset($response->error)){
                $result = [
                    'result' => false,
                    $logs = $response->error,
                    CronHelper::pusherLogs($logs,$channel,$event)
                ];
            }else{
                $logs = "Fetching all data from ".$startDate." to ".$endDate;
                CronHelper::pusherLogs($logs,$channel,$event);
                
                if(isset($response) && count($response) > 0){
                    $tradesArray = [];
                    $ticketArray = [];
                    $accountArray = [];
                    $loginIds = [];
                    $logs = "";
                    $tradelogs = "";
                    $tradeIndex = 0;
                    foreach($response as $account){
                        //set trades
                        if(isset($account->Login)){
                            $subTrades = $account->Trades;
                            
                            if(count($subTrades) > 0){
                                // $logs = "Fetching Trades for Login ID: ".$account->Login." Total Trades ".count($subTrades);
                                // CronHelper::pusherLogs($logs, $channel, $event);
                                $tradelogs.= "Fetching Trades for Login ID: ".$account->Login." Total Trades ".count($subTrades)."</br>";
                                $tradeIndex++;
                                foreach($subTrades as $k => $trd){
                                    if(isset($trd->Ticket)){
                                        $ticketArray[] =  $trd->Ticket;
                                        $tradesArray[] = [
                                            'login' => $account->Login,
                                            // 'agent_number' ,
                                            'ticket' => $trd->Ticket,
                                            'symbol' => isset($trd->Ticket) ? $trd->Symbol : '',
                                            // 'ccy' => $trd->,
                                            'type' => isset($trd->Type) ? $trd->Type : '',
                                            'lots' => isset($trd->Lots) ? $trd->Lots : '',
                                            'open_price' => isset($trd->OpenPrice) ? $trd->OpenPrice : 0,
                                            'open_time' => isset($trd->OpenTime) ? $trd->OpenTime : 0,
                                            'close_price' => isset($trd->ClosePrice) ? $trd->ClosePrice : 0,
                                            'close_time' => isset($trd->CloseTime) ? $trd->CloseTime : 0,
                                            'profit' => isset($trd->Profit) ? $trd->Profit : 0,
                                            'commission' => isset($trd->Commission) ? $trd->Commission : 0 ,
                                            'agent_commission' => isset($trd->AgentCommission) ? $trd->AgentCommission : 0,
                                            'comment' => isset($trd->Comment) ? $trd->Comment : '',
                                            'magic_number' => isset($trd->MagicNumber) ? $trd->MagicNumber : 0 ,
                                            'stop_loss' => isset($trd->StopLoss) ? $trd->StopLoss : '',
                                            'take_profit' => isset($trd->TakeProfit) ? $trd->TakeProfit : '',
                                            'swap' => isset($trd->Swap) ? $trd->Swap : '',
                                            'reason' => isset($trd->Reason) ? $trd->Reason : '',
                                            // 'is_accounted_for' => $trd->,
                                            // 'created_at' => $trd->,
                                            // 'updated_at' => $trd->,
                                            // 'deleted_at' => $trd->,
                                        ];
                                    }
                                }
                                // var_dump($tradelogs);
                                if($tradelogs != ''){
                                    if($tradeIndex % 10 == 0){
                                        CronHelper::pusherLogs($tradelogs, $channel, $event);
                                        $tradelogs = "";
                                    }elseif($tradeIndex == max(array_keys($subTrades))){
                                        CronHelper::pusherLogs($tradelogs, $channel, $event);
                                        $tradelogs = "";
                                    }
                                }
                            }
                            // set accounts
                            $loginIds[] = $account->Login;
                            $accountArray[] = [
                                'broker_id'     => $id,
                                'login'         => $account->Login,
                                'name'          => isset($account->Name) ? $account->Name : '',
                                'currency'      => isset($account->Currency) ? $account->Currency : '',
                                'balance'       => isset($account->Balance) ? $account->Balance : 0,
                                'equity'        => isset($account->Equity) ? $account->Equity : 0,
                                'email_address'    => isset($account->EmailAddress) ? $account->EmailAddress : '',
                                'group'         => isset($account->Group) ? $account->Group : '',
                                'agent'         => isset($account->Agent) ? $account->Agent : '',
                                'registration_date'     => isset($account->RegistrationDate) ? $account->RegistrationDate : date('Y-m-d H:i:s'),
                                'leverage'      => isset($account->Leverage) ? $account->Leverage : 0,
                                'address'       => isset($account->Address) ? $account->Address : '',
                                'agent'         => isset($account->Agent) ? $account->Agent : '',
                                'city'          => isset($account->City) ? $account->City : '',
                                'state'         => isset($account->State) ? $account->State : '',
                                'country'       => isset($account->Country) ? $account->Country : '',
                                'postcode'      => isset($account->PostCode) ? $account->PostCode : '',
                                'phone_number'  => isset($account->PhoneNumber) ? $account->PhoneNumber : '',
                                
                                // "Enable": true,
                                // "ReadOnly": true,
                                // "MetaquotesID": 0,
                                // "Status": "",
                                // "TaxRate": 0.0,
                                // "IDNumber": "",
                                // "AllowPasswordChange": true,
                                // "SendReports": false,
                            ];
                        }
                    }
                    $existingItems = CbmMtFourAccount::whereIn('login', $loginIds)->get()->toArray();
                    $existingItems = collect($existingItems);
                    
                    $finalArray = [];
                    $newAccounts = 0;
                    $existingAccounts = 0;
                    // $i =0;
                    $info = "Fetching Account data!";  
                    CronHelper::pusherLogs($info, $channel, $event);
                    foreach($accountArray as $i => $ar){
                        // $i++;
                        // if($i == 10) break;
                        
                        $login = $ar['login'];
                        $desired_object = $existingItems->where('login', $login);
                        // var_dump($desired_object->count());
                        if((is_countable($desired_object)) && $desired_object->count() >= 1){
                            if(isset($desired_object)){
                                $existingAccounts++;
                                $newItem = $desired_object->slice(0,1)->toArray();
                                $keyName = array_keys($newItem);
                                $index = $keyName[0];
                                // $newItem[0] = $ar;
                                // var_dump($keyName);
                                $newItem[$index]['balance'] = $ar['balance'];
                                $newItem[$index]['equity']  = $ar['equity'];
                                $finalArray[] = $newItem[$index];
                                $logs .= "updated account data for Login ID: ".$newItem[$index]['login']."</br>";
                                // CronHelper::pusherLogs($logs, $channel, $event);
                            }
                            
                        }else{
                            $newAccounts++;
                            $logs .= "Inserting account data for Login ID: ".$ar['login']."</br>";
                            // CronHelper::pusherLogs($logs, $channel, $event);
                            $finalArray[] = $ar;
                        }
                        if($logs != ''){
                            if($i % 50 == 0){
                                CronHelper::pusherLogs($logs, $channel, $event);
                                $logs = "";
                            }elseif($i == max(array_keys($accountArray))){
                                CronHelper::pusherLogs($logs, $channel, $event);
                                $logs = "";
                            }
                        }
                    }

                    $chunk_array = array_chunk($finalArray, 500);
                    CbmMtFourAccount::whereIn('login', $loginIds)->delete();

                    // $logs = "Deleted Accounts Login ID: ".implode(',',$loginIds);
                    // CronHelper::pusherLogs($logs, $channel, $event);
                    foreach($chunk_array as $data){
                        CbmMtFourAccount::insert($data);
                    }

                    // insert trades
                    $chunk_array = array_chunk($tradesArray, 500);
                    MtFourTrade::whereIn('ticket', $ticketArray)->delete();

                    // $logs = "Deleted Trades Ticket: ".$ticketArray;
                    // CronHelper::pusherLogs($logs, $channel, $event);
                    foreach($chunk_array as $data){
                        MtFourTrade::insert($data);
                    }
                    $logs = 'Total Accounts '.$newAccounts.' Inserted';
                    CronHelper::pusherLogs($logs,$channel,$event);
                    $logs = 'Total Accounts '.$existingAccounts.' Updated';
                    CronHelper::pusherLogs($logs,$channel,$event);
                    $logs = 'Total Trades '.count($tradesArray).' Inserted';
                    CronHelper::pusherLogs($logs,$channel,$event);
                    $result = [
                        'result' => true,
                        $logs = 'Data imported Successfully',
                        CronHelper::pusherLogs($logs,$channel,$event)
                    ];
                }else if(isset($response) && count($response) === 0){
                    $result = [
                        'result' => true,
                        $logs = 'No Data found to import',
                        CronHelper::pusherLogs($logs,$channel,$event)
                    ]; 
                }
                else{
                    $result = [
                        'result' => false,
                        $logs = 'Data  not imported ',
                        CronHelper::pusherLogs($logs,$channel,$event)
                    ];  
                }   
            }
            return json_encode($result);
        }catch (Exception $e) {
            echo $e->getMessage();
            Log::channel('commission')->info("All Data error: ".$e->getMessage());
            echo "<div align='center'><h3 style='color: red; margin-bottom: 0'>Execution failed!!</h3></div>";
        }
    }
}
