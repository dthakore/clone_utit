<?php

namespace App\Console\Commands;

use App\Events\DatabaseBuild;
use Illuminate\Console\Command;
use App\Models\Puxeo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Pusher\Pusher;

class PuxeoMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'puxeo:migrate {tenant?} {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrating puxeo-child database';

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
            Log::channel('domain')->info("Migration started");
            $puxeo = Puxeo::where('id', $this->argument('tenant'))->first();
            Log::channel('domain')->info("Migrating {$puxeo->database}");
            $puxeo->configure()->use();
            /*config([
                'database.connections.tenant.database' => $puxeo->database,
            ]);

            DB::purge('tenant');

            DB::reconnect('tenant');

            Schema::connection('tenant')->getConnection()->reconnect();*/
            //Config::set('database.connections.mysql.database', 'other_database');
            //\Illuminate\Support\Facades\Config::set();

            $this->line("-------------------------------------------");
            $this->info('Migration started for --database='.$puxeo->database);
            $this->line("-------------------------------------------");

            $options = ['--force' => true];

            if($this->option('seed')){
                $options['--seed'] = true;
            }

            $this->call($this->option('fresh') ? 'migrate:fresh' : 'migrate', $options);

            $this->line("-------------------------------------------");
            $this->info('Migration completed');
            $this->line("-------------------------------------------");
            $data = [
                "db_created" => 1,
                "ended_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ];
            DB::connection('puxeo')->table('tenants')
                ->where('id','=',$this->argument('tenant'))
                ->update($data);
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                array('cluster' => env('PUSHER_APP_CLUSTER'))
            );
            $pusher->trigger('child-build', 'database-build', $data);
            Log::channel('domain')->info("Migration done");
        } catch (\Exception $e) {
            Log::channel('domain')->error("Failed to migrate, Error" .$e->getMessage());
            DB::connection('puxeo')->table('tenants')
                ->where('id','=',$this->argument('tenant'))
                ->update([
                    "db_created" => 0,
                    "db_error" => $e->getMessage(),
                    "ended_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
            $this->error($e->getMessage());
            $this->error($e->getLine());
            $this->error($e->getFile());
            $this->error($e->getTraceAsString());
        }
    }
}
