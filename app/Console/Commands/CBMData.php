<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\CronHelper;
// use App\Models\OrderLineItem;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderLineItem;

class CBMData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cbmdata:import {--db=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'importing cbm-data database';

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
        //try {

            $db = $this->option('db');
            if(isset($db)){
                $connection = CronHelper::useDatabaseWithId($db);
                // dd($connection);
            }
            
            $cbm_order_info = DB::table('cbm_order_info')->where('order_status', 1)->get();
            
            $cbm_user_data =DB::table('cbm_user_info')->get();
            $cbm_order_line_item = DB::table('cbm_order_line_item')->get();
            $cbm_order_payment = DB::table('cbm_order_payment')->get();
            //dd($cbm_user_data);
            Order::where('cbm', 1)->delete();
            User::where('cbm', 1)->delete();
            OrderLineItem::where('cbm', 1)->delete();
            OrderPayment::where('cbm', 1)->delete();
            $utit_user_data = User::get();

            $orderArray = [];
            // $ = [];
            $line_item_products = [];
            $payment_data = [];
            $temp = 0;
            foreach($cbm_order_info as $cbm_order)
            {
                // $temp++;
                // if($temp > 10) break;
                $use_id_insert = 0;
                $cbm_user_id = $cbm_order->user_id;
                $cbm_user = $cbm_user_data->where('user_id', $cbm_user_id)->first();
                $utit_user = DB::table('users')->where('email', $cbm_user->email)->first();
                // var_dump($utit_user);
                if($utit_user === null){
                    $this->info("user not found" );
                    $userToinsert = [
                        'name'                      => $cbm_user->full_name,
                        'email'                     => $cbm_user->email,
                        'first_name'                => $cbm_user->first_name,
                        'middle_name'               => $cbm_user->middle_name,
                        'last_name'                 => $cbm_user->last_name,
                        'password'                  => '',
                        'api_token'                 => $cbm_user->api_token,
                        'date_of_birth'             => $cbm_user->date_of_birth,
                        'gender'                    => $cbm_user->gender,
                        'is_enabled'                => $cbm_user->is_enabled,
                        'is_active'                 => $cbm_user->is_active,
                        'building_num'              => $cbm_user->building_num,
                        'street'                    => $cbm_user->street,
                        'region'                    => $cbm_user->region,
                        'postcode'                  => $cbm_user->postcode,
                        'city'                      => $cbm_user->city,
                        'phone'                     => $cbm_user->phone,
                        'business_name'             => $cbm_user->business_name,
                        'vat_number'                => $cbm_user->vat_number,
                        'bus_address_building_num'  => $cbm_user->busAddress_building_num,
                        'bus_address_street'        => $cbm_user->busAddress_street,
                        'bus_address_region'        => $cbm_user->busAddress_region,
                        'bus_address_city'          => $cbm_user->busAddress_city,
                        'bus_address_postcode'      => $cbm_user->busAddress_postcode,
                        'business_phone'            => $cbm_user->business_phone,
                        'is_delete'                 => $cbm_user->is_delete,
                        'image'                     => $cbm_user->image,
                        'token'                     => $cbm_user->token,
                        'notification_mail'         => $cbm_user->notification_mail,
                        'marketting_mail'           => $cbm_user->marketting_mail,
                        'auth'                      => $cbm_user->auth,
                        'terms_conditions'          => $cbm_user->terms_conditions,
                        'affiliate_disclosure'      => $cbm_user->affiliate_disclosure,
                        'privacy_disclosure'        => $cbm_user->privacy_disclosure,
                        'reserve_wallet_commission_status'  => $cbm_user->reserve_wallet_commission_status,
                        'email_verified_at'         => $cbm_user->created_at,
                        'approved'                  => 1,
                        'verified'                  => 1,
                        'verified_at'               => $cbm_user->created_at,
                        'verification_token'        => '',
                        'two_factor'                => 0,
                        'remember_token'            => '',
                        'two_factor_code'           => '',
                        'two_factor_expires_at'     => null,
                        'sponsor_id'                => null,
                        'country_id'                => $cbm_user->country !== '' && $cbm_user->country !== ' ' ? $cbm_user->country : null,
                        'bus_address_country_id'    => $cbm_user->busAddress_country !=='' ? $cbm_user->busAddress_country : null,
                        'rank_id'                   => null,
                        'product_id'                => null,
                        'role'                      => $cbm_user->role,
                        'cbm'                       => 1,
                        'created_at'                => $cbm_user->created_at,
                        'updated_at'                => $cbm_user->modified_at,
                        'deleted_at'                => null,

                    ];
                    $id = User::insertGetId(
                        $userToinsert
                    );
                    // role_user
                    DB::table('role_user')->insert([
                        'user_id'     => $id,
                        'role_id'     => 2
                    ]);
                    $userToinsert['id'] = $id;
                    $utit_user_data->push((object)$userToinsert);
                    $use_id_insert = $id;

                }else{
                    $this->info("user found" );
                    $use_id_insert = $utit_user->id;
                }
                $new_order_id = Order::insertGetId(
                    [
                        'order'                   => $cbm_order->order_id,
                        'vat'                     => $cbm_order->vat,
                        'vat_percentage'          => $cbm_order->vat_percentage,
                        'vat_number'              => $cbm_order->vat_number,
                        'company'                 => $cbm_order->company,
                        'order_status'            => 2,
                        'order_origin'            => $cbm_order->order_origin,
                        'building'                => $cbm_order->building,
                        'street'                  => $cbm_order->street,
                        'region'                  => $cbm_order->region,
                        'postcode'                => $cbm_order->postcode,
                        'city'                    => $cbm_order->city,
                        'order_total'             => $cbm_order->orderTotal,
                        'discount'                => $cbm_order->discount,
                        'net_total'               => $cbm_order->netTotal,
                        'invoice_number'          => $cbm_order->invoice_number,
                        'invoice_date'            => $cbm_order->invoice_date,
                        'is_subscription_enabled' => null,
                        'order_comment'           => $cbm_order->order_comment,
                        'user_name'               => $cbm_order->user_name,
                        'email'                   => $cbm_order->email,
                        'voucher_code'            => $cbm_order->voucher_code,
                        'voucher_discount'        => $cbm_order->voucher_discount,
                        'user_id'                 => $use_id_insert,
                        'country_id'              => $cbm_order->country !== '' && $cbm_order->country !== ' ' ? $cbm_order->country : null,
                        'address_type'            => '',
                        'cbm'                     => 1,
                        'created_at'              => $cbm_order->created_date,
                        'updated_at'              => $cbm_order->modified_date,
                        'deleted_at'              => null,
                    ]
                );
                $line_itm_products = $cbm_order_line_item->where('order_info_id', $cbm_order->order_info_id );
                $order_payment_data = $cbm_order_payment->where('order_info_id', $cbm_order->order_info_id );
                // dd($line_itm_products);
                foreach($line_itm_products as $line_item){
                    $line_item_products[] = [
                        'product_name'  => $line_item->product_name,
                        'item_qty'      => $line_item->item_qty,
                        'item_disc'     => $line_item->item_disc,
                        'item_price'    => $line_item->item_price,
                        'licence_key'   => '',
                        'cycle_ends_at' => null,
                        'product_sku'   => 'cbm_cashback',
                        'comment'       => '',
                        'order_id'      => $new_order_id,
                        // 'product_id'    => 3,
                        'product_id'    => 8,
                        'cbm'           => 1,
                        'created_at'    => $line_item->created_at,
                        'updated_at'    => $line_item->modified_at,
                    ];
                }
                foreach($order_payment_data as $cbm_payment){
                    $payment_data[] = [
                        'total'             => $cbm_payment->total,
                        'payment_mode'      => 3,
                        'payment_ref_id'    => $cbm_payment->payment_ref_id,
                        'payment_status'    => '2',
                        'payment_date'      => $cbm_payment->payment_date,
                        'transaction_mode'  => $cbm_payment->transaction_mode,
                        'denomination_id'   => $cbm_payment->denomination_id,
                        'order_id'          => $new_order_id,
                        'cbm'               => 1,
                        'created_at'        => $cbm_payment->created_at,
                        'updated_at'        => $cbm_payment->modified_at,
                    ];
                }
               
                $this->info("order inserted ".$cbm_order->order_id );
            }
            $this->info("line item inserting" );
            OrderLineItem::insert($line_item_products);
            $this->info("payment inserting" );
            OrderPayment::insert($payment_data);

            // $cbm_order_payment = DB::table('cbm_order_payment')->get();

            // foreach($cbm_order_payment as $cbm_payment)
            // {
            //     OrderPayment::insert(
            //         [
            //             'total'             => $cbm_payment->total,
            //             'payment_mode'      => $cbm_payment->payment_mode,
            //             'payment_ref_id'    => $cbm_payment->payment_ref_id,
            //             'payment_status'    => $cbm_payment->payment_status,
            //             'payment_date'      => $cbm_payment->payment_date,
            //             'transaction_mode'  => $cbm_payment->transaction_mode,
            //             'denomination_id'   => $cbm_payment->denomination_id,
            //             'order_id'          => $cbm_payment->order_info_id,
            //             'cbm'               => 1,
            //             'created_at'        => '',
            //             'updated_at'        => '',
            //         ]
            //     );
            // }

            // $cbm_order_line_item = DB::table('cbm_order_line_item')->get();

            // foreach($cbm_order_line_item as $line_item)
            // {
            //     OrderLineItem::insert(
            //         [
            //             'product_name'  => $line_item->product_name,
            //             'item_qty'      => $line_item->item_qty,
            //             'item_disc'     => $line_item->item_disc,
            //             'item_price'    => $line_item->item_price,
            //             'licence_key'   => '',
            //             'cycle_ends_at' => '',
            //             'product_sku'   => $line_item->product_sku,
            //             'comment'       => '',
            //             'order_id'      => $line_item->order_info_id,
            //             'product_id'    => $line_item->product_id,
            //             'cbm'           => 1,
            //             'created_at'    => '',
            //             'updated_at'    => '',
            //         ]
            //     );
            // }
        // }catch(\Exception $error){
        //     dd($error);
        // }
    }
}
