<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use http\Exception;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\OrderPayment;
use App\Models\CbmMtFourAccount;
use App\Models\CbmUserLicenses;
use App\Models\UserPositionAccount;
use App\Models\RegistrationSteps;
use App\Models\RegistrationStatus;
use App\Models\CbmLogs;
use App\Models\WalletType;
use App\Models\OrderCreditItems;

class OrderHelper {

    /**
     * Create New Invoice Number
     * @return array
     */
    public static function getInvoiceNumber()
    {
        $currentYear = date('y');
        //finding missing invoice no if available in database.
        $row = "SELECT (t1.invoice_number + 1) as gap_starts_at, (SELECT MIN(t3.invoice_number) -1 FROM ecom_orders t3 WHERE t3.invoice_number > t1.invoice_number) as gap_ends_at FROM ecom_orders t1 WHERE NOT EXISTS (SELECT t2.invoice_number FROM ecom_orders t2 WHERE t2.invoice_number = t1.invoice_number + 1) AND t1.invoice_number LIKE '" . $currentYear . "%' HAVING gap_ends_at IS NOT NULL";
        $missingInvoice = DB::select($row);
        if (empty($missingInvoice['gap_starts_at'])) {
            $prefix = $currentYear;
            $maxInvoice = DB::select('select max(invoice_number) as invoice_num from ecom_order_invoices');
            if (isset($maxInvoice[0]->invoice_num)) {
                $currentYear = date('y');
                $LastInvoiceYear = substr($maxInvoice[0]->invoice_num, 0, 2);
                if ($currentYear == $LastInvoiceYear) {
                    $newInvoice = str_pad(((int)$maxInvoice[0]->invoice_num + 1), 4, '0', STR_PAD_LEFT);
                } else {
                    $newInvoice = $currentYear . str_pad(1, 4, '0', STR_PAD_LEFT);
                }
            } else {
                $newInvoice = $prefix . str_pad(1, 4, '0', STR_PAD_LEFT);
            }
            return $newInvoice;
        } else {
            $newInvoice = $missingInvoice['gap_starts_at'];
            return $newInvoice;
        }
    }

    /**
     * Add New CBM nodes based on the recent Order
     * @return array
     */
    public static function generateCBMNodes($login)
    {
        $cbmAccount = CbmMtFourAccount::where('login', $login)->first();
        $user = User::where(['email' => $cbmAccount->email_address])->first();
        $cbm_user_licenses = CbmUserLicenses::where(['email' => $cbmAccount->email_address])->first();

        $available_licenses = $cbm_user_licenses->available_licenses;
        if (isset($cbmAccount->login)) {
            $node_created = 0;
            if ($available_licenses > 0) {
                //Check for un-placed CBM User Accounts
                $cbmUserAccounts = UserPositionAccount::where(['login' => $login, 'agent_num' => $cbmAccount->agent, 'matrix_node_num' => null, 'matrix_node_num' => ''])->get();
                $clusterId = MatrixHelper::getNewClusterId($login);
                if (count($cbmUserAccounts) > $available_licenses) {
                    for ($i = 0; $i < $available_licenses; $i++) {
                        $sponsor_id = MatrixHelper::getMatrixSponsor($cbmUserAccounts[$i]['user_account_num'], $cbmUserAccounts[$i]['matrix']);
                        MatrixHelper::addToMatrix($cbmUserAccounts[$i]['user_account_num'], $sponsor_id);
                        $node_created++;
                    }
                } else {
                    foreach ($cbmUserAccounts as $account) {
                        $sponsor_id = MatrixHelper::getMatrixSponsor($account['user_account_num'], $account['matrix']);
                        MatrixHelper::addToMatrix($account['user_account_num'], $sponsor_id);
                        $node_created++;
                    }
                }
            }

            $cbm_user_licenses->available_licenses -= $node_created;
            $cbm_user_licenses->updated_at = now();
            $cbm_user_licenses->save();
        }
    }

    /**
     * Send Order Confirmation Mail
     * @return array
     */
    public static function orderConfirmationMail($orderId)
    {
        $order = Order::find($orderId);
        echo '<pre>';print_r($order);die;
        $orderLineItem = OrderLineItem::where(['order_id' => $orderId])->get();
        $orderPayment = OrderPayment::where(['order_id' => $orderId])->get();
        $user = User::find($order->user_id);
        $dashBoardUrl = url('/login');
        $orderItems = array();
        foreach ($orderLineItem as $item) {
            $product = Product::find($item->product_id);
            $temp = array();
            $temp['name'] = $item->product_name;
            $temp['image'] = url('/'). $product->image;
            $temp['quantity'] = $item->item_qty;
            $temp['price'] = $item->item_price;
            array_push($orderItems, $temp);
        }
        if (isset($order->id)) {
            $mail = new YiiMailer('order', [
                'full_name' => $user->name,
                'first_name' => $user->first_name,
                'dashBoardURL' => $dashBoardUrl,
                'order' => $order,
                'orderItems' => $orderItems,
                'orderPayment' => $orderPayment
            ]);
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Order Confirmation");
            $mail->setTo($user->email);
            $mail->send();
        }
    }

    /**
     * Update User Status
     * @return array
     */
    public static function updateUserStatus($orderId)
    {
        try {
            $order = Order::find($orderId);
            $user = User::find($order->user_id);

            if ($order->order_status == 1) {
                $orderLineItem = OrderLineItem::where(['order_id' => $order->id])->first();
                foreach ($orderLineItem as $item) {
                    $productId = $item->product_id;
                    $registration_step = RegistrationSteps::where(['product_id' => $productId, 'status_name' => 'BUYING LICENSES'])->first();
                    $registration_status = RegistrationStatus::where(['user_id' => $user->user_id, 'product_id' => $productId])->first();
                    if (isset($registration_status->id)) {
                        if ($registration_status->step_number < $registration_step->step_number) {
                            $registration_status->step_number = $registration_step->step_number;
                            $registration_status->updated_at = now();
                        }
                    } else {
                        $registration_status = new RegistrationStatus();
                        $registration_status->user_id = $user->id;
                        $registration_status->product_id = $productId;
                        $registration_status->email = $user->email;
                        $registration_status->step_number = $registration_step->step_number;
                    }
                    $registration_status->save();
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $logs = new CbmLogs;
            $logs->status = 0;
            $logs->created_at = now();
            $logs->log = 'Update Registration Step Logs: ' . $e->getMessage();
            $logs->save();
        }
    }

    /**
     * Update To Success
     */
    public static function updateToSuccess($orderId)
    {
        $model = Order::where(['order' => $orderId])->first();

        OrderHelper::generateAffiliateCommission($model->order);
        OrderHelper::orderConfirmationMail($model->id);
    }


    /**
     * Generate Affiliate Commission
     */
    public static function generateAffiliateCommission($orderId)
    {
        $order = Order::where(['order' => $orderId])->first();
        $user = User::find($order['user_id']);
        $systemId = config('global.SystemUserId');

        //Wallet type is User
        $wallet_type = WalletType::where(['wallet_type' => 'User'])->first();

        //Default parent
        $level1_user_id = $systemId;
        $level2_user_id = $systemId;

        $orderItems = OrderLineItem::where(['order_id' => $order->id])->get();
        $affiliateDistributed = false;
        foreach ($orderItems as $orderItem){
            //Incase of order credit memo created for partial or full order
            $orderCreditItem = OrderCreditItems::where(['order_line_item_id' => $orderItem->id])->first();
            if(isset($orderCreditItem->id)){
                $qty = ($orderItem->item_qty) - ($orderCreditItem->refund_item_qty);
            } else {
                $qty = $orderItem->item_qty;
            }
            if($qty > 0){
                $product = Product::find($orderItem->product_id);

                //Comments
                $level1_comment = "Level 1 Affiliate commission from user_id " . $user->id . " for order_id " . $orderId . " and product_id " . $orderItem->product_id;
                $level2_comment = "Level 2 Affiliate commission from user_id " . $user->id . " for order_id " . $orderId . " and product_id " . $orderItem->product_id;

                //credits
                $level1_credit = $qty * (!empty($product->level_one_affiliate)) ? $product->level_one_affiliate : '' ;
                $level2_credit = $qty * (!empty($product->level_two_affiliate)) ? $product->level_two_affiliate : '' ;

                if (isset($user->sponsor_id)) {
                    $level1_parent = User::find($user->sponsor_id);
                    $level1_user_id = $level1_parent->id;

                    //Distribute Level One Commission
                    WalletHelper::addToWallet($level1_parent->id, $wallet_type->id, 0, 1,
                        $orderId, $level1_comment, 1, 2, 1, $level1_credit,
                        now());

                    if (isset($level1_parent->sponsor_id)) {
                        $level2_parent = User::find($level1_parent->sponsor_id);
                        $level2_user_id = $level2_parent->id;

                        //Distribute Level One Commission
                        WalletHelper::addToWallet($level2_parent->id, $wallet_type->id, 0, 1,
                            $orderId, $level2_comment, 1, 2, 1, $level2_credit,
                            now());

                    } else {
                        //Level Two Commission to System
                        WalletHelper::addToWallet($systemId, $wallet_type->id, 0, 1,
                            $orderId, $level2_comment, 1, 2, 1, $level2_credit,
                            now());
                    }
                } else {
                    //Level One Commission to System
                    WalletHelper::addToWallet($systemId, $wallet_type->id, 0, 1,
                        $orderId, $level1_comment, 1, 2, 1, $level1_credit,
                        now());

                    //Level Two Commission to System
                    WalletHelper::addToWallet($systemId, $wallet_type->id, 0, 1,
                        $orderId, $level2_comment, 1, 2, 1, $level2_credit,
                        now());
                }
                $affiliateDistributed = true;
            }
        }
        if($affiliateDistributed == true){
            self::affiliateLevelOne($user->name, $level1_user_id);
            self::affiliateLevelTwo($user->name, $level2_user_id);
        }
    }

    /**
     * Send Affiliate Level 1 Commission Mail
     */
    public static function affiliateLevelOne($fromName, $toUserId)
    {
        $user = User::find($toUserId);
        if (isset($user->id) && $user->id != 1) {
            $mail = new YiiMailer('affiliate-level-one', [
                'from_name' => $fromName,
                'to_name' => $user->name
            ]);
            $mail->setFrom('info@iriscall.be', 'IrisCall');
            $mail->setSubject("Affiliate Level One Commission");
            $mail->setTo($user->email);
            $mail->send();
        }
    }

    /**
     * Send Affiliate Level 2 Commission Mail
     */
    public static function affiliateLevelTwo($fromName, $toUserId)
    {
        $user = User::find($toUserId);
        if (isset($user->id) && $user->id != 1) {
            $mail = new YiiMailer('affiliate-level-two', [
                'from_name' => $fromName,
                'to_name' => $user->name
            ]);
            $mail->setFrom('info@iriscall.be', 'IrisCall');
            $mail->setSubject("Affiliate Level Two Commission");
            $mail->setTo($user->email);
            $mail->send();
        }
    }
}
?>