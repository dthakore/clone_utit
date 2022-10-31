<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MtfourDailyBalance;
use Illuminate\Support\Facades\Log;
use Http;
use GuzzleHttp\Client;
use App\Helpers\CronHelper;

class DailyBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailybalance:import {--db=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'importing daily-balance database';

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
        try {
            $db = $this->option('db');
            if(isset($db)){
                $connection = CronHelper::useDatabaseWithId($db);
            }
        
            $this->info("fetching account data");
            $client = new Client(['verify' => false ]);
            $response = $client->request('POST', 'https://metamanager.utradeitrade.com/Mt4manager/Accounts/GetAccountsWithHistory',[
                
                'json' => [
                    "ServerLogin"     => 58,
                    "ServerPassword"  => 'bsjI5dhwQ4myHw',
                    "ServerAddress"   => 'live01dcln.eurotrader.eu:1980',
                    "ServerPort"      => 443,
                ],
            ]);
            
            
            $response = json_decode($response->getBody()->getContents(), true);
            //dd($response);
            $accountArray = [];
            if(isset($response) && count($response) > 0){

                foreach($response as $account){
                    // dd($account);
                    $accountArray[] = [
                        // 'broker_id'     => $id,
                        'account'       => $account['Login'],
                        'email'         => isset($account['EmailAddress']) ? $account['EmailAddress'] : '',
                        'agent'         => isset($account['Agent']) ? $account['Agent'] : '',
                        'group'         => isset($account['Group']) ? $account['Group'] : '',
                        'balance'       => isset($account['Balance']) ? $account['Balance'] : 0,
                        'equity'        => isset($account['Equity']) ? $account['Equity'] : 0,
                        'created_at'    => date("Y-m-d H:i:s"),
                        'updated_at'    => date("Y-m-d H:i:s"),
                    ];
                }

                $finalArray = [];
                foreach($accountArray as $i => $ar){
                    $finalArray[] = $ar;
                }

                $chunk_array = array_chunk($finalArray, 500);
                
                foreach($chunk_array as $data){
                    MtfourDailyBalance::insert($data);
                }
                $logs = count($finalArray)." records inserted successfully";
                $this->info($logs);
                Log::channel('dailybalance')->info($logs);
                // $this->info("Inserted successfully!");
            }else{
                $result = [
                    'result' => false,
                    $logs = 'Data  not imported ',
                    $this->info($logs),
                    Log::channel('dailybalance')->info($logs)
                ];  
            }
        }catch(\Exception $error){
            Log::channel('dailybalance')->error($error->getMessage());
            $this->error("Line ".$error->getLine());
            $this->error($error->getMessage());
            return Command::FAILURE;
        }
    }
}
