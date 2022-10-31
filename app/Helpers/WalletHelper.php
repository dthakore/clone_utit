<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\WalletType;
use App\Models\Allwallettransaction;

class WalletHelper {

    /**
     * insert data into all_wallet_transactions table
     * @return array
     */
    public static function addToWallet($userId, $walletTypeId, $transactionType, $referenceId, $referenceNum,
                                       $transactionComment, $denominationID, $transactionStatus, $portalId,
                                       $creditAmount, $createdDate){
        $wallet = new Wallet();
        $wallet->user_id = $userId;
        $wallet->wallet_type_id = $walletTypeId;
        $wallet->transaction_type = $transactionType;
        $wallet->reference_id = $referenceId;
        $wallet->reference_num = $referenceNum;
        $wallet->transaction_comment = $transactionComment;
        $wallet->denomination_id = $denominationID;
        $wallet->transaction_status = $transactionStatus;
        $wallet->portal_id = $portalId;
        $wallet->amount = $creditAmount;
        $wallet->created_at = $createdDate;
        $wallet->save(false);
    }

    /**
     * Commission, Affiliate and Payout Earnings are considered in User Wallet Earnings
     * @return array
     */
    public static function getUserWalletEarnings($userId){
        $userWallet = WalletType::where(['wallet_slug'=>'user'])->first();
        $walletType = isset($userWallet->id) ? $userWallet->id : '';

        $credit = Allwallettransaction::select(DB::raw('SUM(CASE WHEN transaction_type = 1 THEN amount ELSE 0 END) AS credit_amt'))
            ->where(['user_id' => $userId, 'wallet_type_id' => $walletType])
            ->where('transaction_status', '!=' , 4)
            ->first();
        $debit = Allwallettransaction::select(DB::raw('SUM(CASE WHEN transaction_type = 2 THEN amount ELSE 0 END) AS debit_amt'))
            ->where(['user_id' => $userId, 'wallet_type_id' => $walletType])
            ->where('transaction_status', '!=' , 4)
            ->first();
        $balance = round($credit['credit_amt'], 5) - round($debit['debit_amt'], 5);
        return $balance;
    }

    /**
     * User Wallet Reserve Amount
     * @return array
     */
    public static function getReserveWalletBalance($userId){
        $reserve_wallet = WalletType::where(['wallet_type' => "Reserve Wallet"])->first();
        $walletType = isset($reserve_wallet->id) ? $reserve_wallet->id : '';

        $credit = Allwallettransaction::select(DB::raw('SUM(CASE WHEN transaction_type = 1 THEN amount ELSE 0 END) AS credit_amt'))
            ->where(['user_id' => $userId, 'wallet_type_id' => $walletType])
            ->where('transaction_status', '!=' , 4)
            ->first();
        $debit = Allwallettransaction::select(DB::raw('SUM(CASE WHEN transaction_type = 2 THEN amount ELSE 0 END) AS debit_amt'))
            ->where(['user_id' => $userId, 'wallet_type_id' => $walletType])
            ->where('transaction_status', '!=' , 4)
            ->first();
        $reserve_balance = $credit['credit_amt'] - $debit['debit_amt'];
        return $reserve_balance;
    }
}
?>
