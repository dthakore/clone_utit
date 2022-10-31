<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Allwallettransaction;
use App\Models\Denomination;
use App\Models\User;
use App\Models\WalletMetaType;
use App\Models\WalletType;
use App\Models\CommissionRule;
use App\Models\Trade;
use App\Models\Plan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Helpers\BinaryTreeHelper;
use App\Helpers\CronHelper;

class CommissionDistribution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribute:commission {--start_date=} {--end_date=} {--db=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute commission amount based on the commission rule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $response = [];
            $allTransaction = [];
            $start_date = $this->option('start_date');
            $end_date = $this->option('end_date');
            $db = $this->option('db');
            if(isset($db)){
                $connection = CronHelper::useDatabase($db);
            }

            $channel = 'commissions';
            $event = 'wallet-distribution';
            $logs = "Commission Distribution started from {$start_date} to {$end_date}"."\n";
            $this->info($logs);
            Log::channel('commission')->info($logs);
            CronHelper::pusherLogs($logs, $channel, $event);

            //Find all trades
            //$trades_collection = Self::tradeProfit($start_date, $end_date);
            $trades = Trade::select('id', 'user_id', 'profit_loss')
                            ->whereBetween("created_at", [$start_date . " 00:00:00", $end_date . " 23:59:59"])
                            ->where('profit_loss', '>', 0)
                            ->get()
                            ->toArray();
            if(!empty($trades)){
                foreach($trades as $value){
                    $logs = "Starting computing for User: ".$value['user_id'];
                    $this->info($logs);
                    Log::channel('commission')->info($logs);
                    CronHelper::pusherLogs($logs, $channel, $event);

                    //Find user hierarchy tree till parent
                    $userParents = BinaryTreeHelper::GetParentTrace($value['user_id'], 20);
                    $commission_plan = Plan::where('name', 'Default')->where('is_active', 1)->first();
                    $commission_rules = CommissionRule::where('commission_plan_id', $commission_plan->id)->get();

                    foreach($commission_rules as $key => $c_rule){
                        if(isset($userParents[$key]['userId'])){
                            //Compute commission amount based on the commission rule
                            $wallet_ref = WalletMetaType::where('reference_desc', 'Commission from Level '.$userParents[$key]['level'])->first();
                            if($c_rule['amount_type'] == 1){
                                $commission = $value['profit_loss'] * $c_rule['amount'] / 100;
                            }else{
                                $commission = $c_rule['amount'];
                            }
    
                            $logs = "Commission amount ".$commission." generated for Trade: ".$value['id']." for Level ".$userParents[$key]['level'];
                            $this->info($logs);
                            Log::channel('commission')->info($logs);
                            CronHelper::pusherLogs($logs, $channel, $event);
    
                            $temp['transaction_type'] = 1;
                            $temp['reference_num'] = $value['id'];
                            $temp['transaction_comment'] = "Commission generated for Trade: ".$value['id']." for Level ".$userParents[$key]['level'];
                            $temp['transaction_status'] = 3;
                            $temp['amount'] = $commission;
                            $temp['created_at'] = now();
                            $temp['user_id'] = $userParents[$key]['userId'];
                            $temp['wallet_type_id'] = 1;
                            $temp['reference_id'] = $wallet_ref->id;
                            $temp['denomination_id'] = 1;
                            array_push($allTransaction, $temp);
                            unset($temp);
                        }
                    }
                }
                //echo '<pre>';\print_r($allTransaction);exit;
                //Insert into all_wallet_transactions
                $chunk_array = array_chunk($allTransaction, 1000);
                foreach($chunk_array as $data){
                    Allwallettransaction::insert($data);
                }
    
                $logs = "Commission Distribution completed | ".count($allTransaction)." records inserted";
                $this->info($logs);
                Log::channel('commission')->info($logs);
                CronHelper::pusherLogs($logs, $channel, $event);
                return Command::SUCCESS;
            }else{
                $logs = "No trade found";
                $this->info($logs);
                Log::channel('commission')->info($logs);
                CronHelper::pusherLogs($logs, $channel, $event);
                return Command::SUCCESS;
            }
        } catch(\Exception $error){
            Log::channel('commission')->error($error->getMessage());
            $this->error("Line ".$error->getLine());
            $this->error($error->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * @return void
     */
    static function tradeProfit($start_date, $end_date):array {
        try {
            $trades = Trade::where('side','=','SELL')
                ->where('status','=',1)
                ->whereBetween("created_at", [$start_date . " 00:00:00", $end_date . " 23:59:59"])
                ->get();
            $trades_collection = [];
            foreach ($trades as $trade) {
                $buy_amount = DB::selectOne(DB::raw("SELECT sum(executed_amount) AS total_buy FROM crypto_trades WHERE id IN ({$trade->original_orders})"));
                if($trade->executed_amount > $buy_amount->total_buy) {
                    $trades_collection[] = [
                        "trade_id" => $trade->id,
                        "user_id" => $trade->user_id,
                        "trade_amount" => $trade->executed_amount,
                        "profit_generated" => $trade->executed_amount - $buy_amount->total_buy,
                        "date" => $trade->created_at
                    ];
                }
            }
            return [
                "result" => true,
                "data" => $trades_collection
            ];
        } catch (\Exception $exception) {
            return [
                "result" => false,
                "data" => [],
                "error" => $exception->getMessage()
            ];
        }
    }
}
