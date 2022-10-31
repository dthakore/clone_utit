<?php

namespace App\Helpers;

use App\Models\VoucherInfo;
use App\Models\Order;

class VoucherHelper {

    /**
     * Update Voucher To Success
     * @return array
     */
    public static function updateVoucherToSuccess($voucher_code, $id){

        $voucher = VoucherInfo::where(['voucher_code' => $voucher_code])->first();
        $order = Order::find($id);
        $voucher->redeemed_at = now();
        $voucher->user_id = $order->user_id;
        $voucher->order_id = $id;
        $voucher->voucher_status = 0;
        $voucher->updated_at = now();
        $voucher->save();
    }
}
?>