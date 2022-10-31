<?php

namespace App\Console\Commands;

use App\Models\Puxeo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class PermissionSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:seed {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $user_id = $this->option('id');
            $this->info("Permission seeder for user {$user_id}");
            $puxeo_user = DB::connection('puxeo')->table('users')->find($user_id);
            $user_modules = DB::connection('puxeo')->table('module_user')->where('user_id', $puxeo_user->id)->get();

            //use requested sub domain database
            Puxeo::Where('user_id', $puxeo_user->id)->first()->configure()->use();

            //$existUser = User::where('email', $puxeo_user->email)->first();

            /*if(!$existUser){
                $user = User::create([
                    'name'          => $puxeo_user->name,
                    'first_name'    => $puxeo_user->name,
                    'email'         => $puxeo_user->email,
                    'password'      => $puxeo_user->password,
                    'verified'      => $puxeo_user->verified,
                    'verified_at'   => $puxeo_user->verified_at,
                    'verification_token'   => null,
                    'created_at'    => now()
                ]);

                $user->roles()->sync(1);
            }*/


            $admin_permissions = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,101,102,103,104,105,106,107,167,195,196];
            $default_permission = [];
            foreach($user_modules as $module){
                $puxeo_module = DB::connection('puxeo')->table('modules')->find($module->module_id);

                if($puxeo_module->name == "Commission Plans"){
                    $permission = [90,91,92,93,94,95,96,97,98,99,100,200];
                }elseif($puxeo_module->name == "Contact Management"){
                    $permission = [119,120,121,122,123,124,125,126,127,128,129];
                }elseif($puxeo_module->name == "Countries"){
                    $permission = [67];
                }elseif($puxeo_module->name == "Course Management"){
                    $permission = [130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,
                        148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165];
                }elseif($puxeo_module->name == "E-Commerce"){
                    $permission = [17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,58,59,60,61,62,68,69,70,71,72,73,74,75,76,201,202,203,204,205];
                }elseif($puxeo_module->name == "FAQ Management"){
                    $permission = [108,109,110,111,112,113,114,115,116,117,118];
                }elseif($puxeo_module->name == "MT4 Manager"){
                    $permission = [63,64,65,66,77,78,79,80,81,84,85,86,87,87,89];
                }elseif($puxeo_module->name == "User Alerts"){
                    $permission = [33,34,35,36];
                }elseif($puxeo_module->name == "Wallet Management"){
                    $permission = [37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57];
                }elseif($puxeo_module->name == "Bot Management"){
                    $permission = [168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,197,198,199];
                } elseif($puxeo_module->name == "System Accounts"){
                    $permission = [166,83];
                }
                foreach($permission as $value){
                    array_push($default_permission, $value);
                }
            }

            Role::findOrFail(2)->permissions()->sync($default_permission);

            $sync = Role::findOrFail(1)->permissions()->sync(array_merge($admin_permissions, $default_permission));
            if($sync){
                $response['status'] = true;
                $response['message'] = "Permission added";
            }else{
                $response['status'] = false;
                $response['message'] = "Failed to add Permission";
            }
            $this->info("Permissions applied");
            $data = [
                "permission_created" => 1,
                "ended_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ];
            DB::connection('puxeo')->table('tenants')
                ->where('user_id','=',$user_id)
                ->update($data);
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                array('cluster' => env('PUSHER_APP_CLUSTER'))
            );
            $pusher->trigger('child-build', 'permission-build', $data);
            Log::channel('domain')->info("Permissions applied");
            return Command::SUCCESS;
        } catch(\Exception $error){
            DB::connection('puxeo')->table('tenants')
                ->where('user_id','=',$user_id)
                ->update([
                    "permission_created" => 0,
                    "permission_error" => $error->getMessage(),
                    "ended_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
            Log::channel('permission')->error($error->getMessage());
            $this->error("Line ".$error->getLine());
            $this->error($error->getMessage());
            return Command::FAILURE;
        }
    }
}
