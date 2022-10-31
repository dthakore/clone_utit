<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Trade;
use App\Helpers\CronHelper;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.commission.index');
    }

    public function distributeCommission(Request $request)
    {
        try{
            ini_set('memory_limit', '-1');
            set_time_limit(0);

            $inputs = $request->all();
            $db = app('currentTenant')->database;
            if(isset($inputs)){
                //$myDateTime = \DateTime::createFromFormat('F, Y', $inputs['start_date']);
                $start_date = $inputs['start_date'];
                $end_date = $inputs['end_date'];
            } else {
                $start_date = date('y-m-d');
                $end_date = date('Y-m-d');
            }
            $base_path = base_path();
            $command = "php {$base_path}/artisan distribute:commission --start_date={$start_date} --end_date={$end_date} --db={$db}";
            $command .= " > /dev/null &";
            $output=null;
            $returnVal=null;

            exec($command, $output, $returnVal);
            Log::channel('commission')->info(json_encode($output)." | $returnVal");

            echo "<p style='color:green;'>Job started in background</p>";
        }catch (Exception $e) {
            echo $e->getMessage();
            echo "<div align='center'><h3 style='color: red; margin-bottom: 0'>Execution failed!!</h3></div>";
        }
    }

    public function allTrades(Request $request)
    {
        try{
            ini_set('memory_limit', '-1');
            set_time_limit(0);

            $inputs = $request->all();
            if(isset($inputs)){
                $start_date = $inputs['start_date'];
                $end_date = $inputs['end_date'];
            } else {
                $start_date = date('y-m-d');
                $end_date = date('Y-m-d');
            }
            $channel = 'commissions';
            $event = 'all-trades';

            $logs = "Fetching all trades from ".$start_date." to ".$end_date;
            CronHelper::pusherLogs($logs, $channel, $event);

            $trades = Trade::select('id', 'user_id', 'profit_loss', 'created_at')
                            ->whereBetween("created_at", [$start_date . " 00:00:00", $end_date . " 23:59:59"])
                            ->where('profit_loss', '>', 0)
                            ->get()
                            ->toArray();
            if(!empty($trades)){
                foreach($trades as $value){
                    $date = date('Y-m-d', strtotime($value['created_at']));
                    $logs = "User: ".$value['user_id'].", Profit/Loss: ".$value['profit_loss']." for Trade ID: ".$value['id']." for Date: ".$date;
                    CronHelper::pusherLogs($logs, $channel, $event);
                }
            }else{
                $logs = "No trade found";
                CronHelper::pusherLogs($logs, $channel, $event);
            }
            $logs = "Execution completed!";
            CronHelper::pusherLogs($logs, $channel, $event);
        }catch (Exception $e) {
            echo $e->getMessage();
            Log::channel('commission')->info("All trades error: ".$e->getMessage());
            echo "<div align='center'><h3 style='color: red; margin-bottom: 0'>Execution failed!!</h3></div>";
        }
    }
}
