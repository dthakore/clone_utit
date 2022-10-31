<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlanMeta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SubscriptionPlanMeta::truncate();
        $data = [
            [
                "title" => "Number of Trading Pairs",
                "key" => "trading-pairs",
                "value" => "2",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Exchanges",
                "key" => "exchanges",
                "value" => "1",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Service Fees (% of profit)",
                "key" => "service-fee",
                "value" => "30",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Dedicated Agent (Monthly private meeting)",
                "key" => "dedicated-agent",
                "value" => "no",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls - Priority in the waiting line",
                "key" => "zoom-calls-support-priority",
                "value" => "no",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Access to the Marketing Tools",
                "key" => "marketing-tools-access",
                "value" => "no",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Replicated website (Referral link)",
                "key" => "replicated-website",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Optional Auto compounding ",
                "key" => "Optional Auto compounding ",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Profit display",
                "key" => "Real time Profit display",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multiple trading strategies (Built in) Can withstand 50+% market drop ",
                "key" => "multiple-trading-strategies",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real Time monthly built in strategies performance tracking Coin Wise on real account.",
                "key" => "real-time-monthly-strategies",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full Explanations on the built in strategies (Full transperancy)",
                "key" => "full-transperancy",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Downtrend Retracement (Will only take new trades when the market move up by a set % Decided by the user)",
                "key" => "powerful-downtrend-retracement",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Take profit retracement (if the market move up fast will take profit at the highest point after the market starts moving down with a set % decided by the user)",
                "key" => "powerful-take-profit-retracement",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable entry point",
                "key" => "customizable-entry-point",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Overview zoom calls",
                "key" => "daily-overview-zoom-calls",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls ",
                "key" => "daily-support-zoom-calls ",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Detailed trading reports (CSV)",
                "key" => "detailed-trading-reports-csv",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable Parameters for Advanced Traders",
                "key" => "customizable-parameters-advanced-traders",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "24 hours Customer email Support",
                "key" => "24-hours-customer-email-support",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "multi orders / covers options on market drop",
                "key" => "multi-orders-covers-options-market-drop",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "manual orders/covers option (adding to the everage orders)",
                "key" => "manual-orders-covers-option",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For One Running Cycle)",
                "key" => "manual-liquidation-option-cycle",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For All Running Cycle)",
                "key" => "manual-liquidation-option-all-running",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Limited) (User Can Define the Number of Cycles after which the bot wull not take more trades)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Unlimited)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Single Cycle Strategy Option",
                "key" => "single-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Possibility to use Multi Trading Stategies on the same Coin",
                "key" => "possibility-multi-trading-same-coin",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Fetching for the available USDT.",
                "key" => "real-time-fetching-available-USDT",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Reminder to re fill USDT to the prepaid wallet on law balance (less than $5)",
                "key" => "USDT-prepaid-wallet",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Fetching the balance and giving wornings when overusing the USDT funds",
                "key" => "balance-warnings-USDT-funds",
                "value" => "yes",
                "plan_id" => 1,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Trading Pairs",
                "key" => "trading-pairs",
                "value" => "5",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Exchanges",
                "key" => "exchanges",
                "value" => "1",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Service Fees (% of profit)",
                "key" => "service-fee",
                "value" => "20",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Dedicated Agent (Monthly private meeting)",
                "key" => "dedicated-agent",
                "value" => "no",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls - Priority in the waiting line",
                "key" => "zoom-calls-support-priority",
                "value" => "no",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Access to the Marketing Tools",
                "key" => "marketing-tools-access",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Replicated website (Referral link)",
                "key" => "replicated-website",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Optional Auto compounding ",
                "key" => "Optional Auto compounding ",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Profit display",
                "key" => "Real time Profit display",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multiple trading strategies (Built in) Can withstand 50+% market drop ",
                "key" => "multiple-trading-strategies",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real Time monthly built in strategies performance tracking Coin Wise on real account.",
                "key" => "real-time-monthly-strategies",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full Explanations on the built in strategies (Full transperancy)",
                "key" => "full-transperancy",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Downtrend Retracement (Will only take new trades when the market move up by a set % Decided by the user)",
                "key" => "powerful-downtrend-retracement",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Take profit retracement (if the market move up fast will take profit at the highest point after the market starts moving down with a set % decided by the user)",
                "key" => "powerful-take-profit-retracement",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable entry point",
                "key" => "customizable-entry-point",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Overview zoom calls",
                "key" => "daily-overview-zoom-calls",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls ",
                "key" => "daily-support-zoom-calls ",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Detailed trading reports (CSV)",
                "key" => "detailed-trading-reports-csv",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable Parameters for Advanced Traders",
                "key" => "customizable-parameters-advanced-traders",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "24 hours Customer email Support",
                "key" => "24-hours-customer-email-support",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "multi orders / covers options on market drop",
                "key" => "multi-orders-covers-options-market-drop",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "manual orders/covers option (adding to the everage orders)",
                "key" => "manual-orders-covers-option",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For One Running Cycle)",
                "key" => "manual-liquidation-option-cycle",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For All Running Cycle)",
                "key" => "manual-liquidation-option-all-running",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Limited) (User Can Define the Number of Cycles after which the bot wull not take more trades)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Unlimited)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Single Cycle Strategy Option",
                "key" => "single-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Possibility to use Multi Trading Stategies on the same Coin",
                "key" => "possibility-multi-trading-same-coin",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Fetching for the available USDT.",
                "key" => "real-time-fetching-available-USDT",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Reminder to re fill USDT to the prepaid wallet on law balance (less than $5)",
                "key" => "USDT-prepaid-wallet",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Fetching the balance and giving wornings when overusing the USDT funds",
                "key" => "balance-warnings-USDT-funds",
                "value" => "yes",
                "plan_id" => 2,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Trading Pairs",
                "key" => "trading-pairs",
                "value" => "10",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Exchanges",
                "key" => "exchanges",
                "value" => "2",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Service Fees (% of profit)",
                "key" => "service-fee",
                "value" => "20",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Dedicated Agent (Monthly private meeting)",
                "key" => "dedicated-agent",
                "value" => "no",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls - Priority in the waiting line",
                "key" => "zoom-calls-support-priority",
                "value" => "no",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Access to the Marketing Tools",
                "key" => "marketing-tools-access",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Replicated website (Referral link)",
                "key" => "replicated-website",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Optional Auto compounding ",
                "key" => "Optional Auto compounding ",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Profit display",
                "key" => "Real time Profit display",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multiple trading strategies (Built in) Can withstand 50+% market drop ",
                "key" => "multiple-trading-strategies",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real Time monthly built in strategies performance tracking Coin Wise on real account.",
                "key" => "real-time-monthly-strategies",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full Explanations on the built in strategies (Full transperancy)",
                "key" => "full-transperancy",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Downtrend Retracement (Will only take new trades when the market move up by a set % Decided by the user)",
                "key" => "powerful-downtrend-retracement",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Take profit retracement (if the market move up fast will take profit at the highest point after the market starts moving down with a set % decided by the user)",
                "key" => "powerful-take-profit-retracement",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable entry point",
                "key" => "customizable-entry-point",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Overview zoom calls",
                "key" => "daily-overview-zoom-calls",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls ",
                "key" => "daily-support-zoom-calls ",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Detailed trading reports (CSV)",
                "key" => "detailed-trading-reports-csv",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable Parameters for Advanced Traders",
                "key" => "customizable-parameters-advanced-traders",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "24 hours Customer email Support",
                "key" => "24-hours-customer-email-support",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "multi orders / covers options on market drop",
                "key" => "multi-orders-covers-options-market-drop",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "manual orders/covers option (adding to the everage orders)",
                "key" => "manual-orders-covers-option",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For One Running Cycle)",
                "key" => "manual-liquidation-option-cycle",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For All Running Cycle)",
                "key" => "manual-liquidation-option-all-running",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Limited) (User Can Define the Number of Cycles after which the bot wull not take more trades)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Unlimited)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Single Cycle Strategy Option",
                "key" => "single-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Possibility to use Multi Trading Stategies on the same Coin",
                "key" => "possibility-multi-trading-same-coin",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Fetching for the available USDT.",
                "key" => "real-time-fetching-available-USDT",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Reminder to re fill USDT to the prepaid wallet on law balance (less than $5)",
                "key" => "USDT-prepaid-wallet",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Fetching the balance and giving wornings when overusing the USDT funds",
                "key" => "balance-warnings-USDT-funds",
                "value" => "yes",
                "plan_id" => 3,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Trading Pairs",
                "key" => "trading-pairs",
                "value" => "all",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Number of Exchanges",
                "key" => "exchanges",
                "value" => "4",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Service Fees (% of profit)",
                "key" => "service-fee",
                "value" => "20",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Dedicated Agent (Monthly private meeting)",
                "key" => "dedicated-agent",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls - Priority in the waiting line",
                "key" => "zoom-calls-support-priority",
                "value" => "no",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Access to the Marketing Tools",
                "key" => "marketing-tools-access",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Replicated website (Referral link)",
                "key" => "replicated-website",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Optional Auto compounding ",
                "key" => "Optional Auto compounding ",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Profit display",
                "key" => "Real time Profit display",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multiple trading strategies (Built in) Can withstand 50+% market drop ",
                "key" => "multiple-trading-strategies",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real Time monthly built in strategies performance tracking Coin Wise on real account.",
                "key" => "real-time-monthly-strategies",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full Explanations on the built in strategies (Full transperancy)",
                "key" => "full-transperancy",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Downtrend Retracement (Will only take new trades when the market move up by a set % Decided by the user)",
                "key" => "powerful-downtrend-retracement",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Powerful Take profit retracement (if the market move up fast will take profit at the highest point after the market starts moving down with a set % decided by the user)",
                "key" => "powerful-take-profit-retracement",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable entry point",
                "key" => "customizable-entry-point",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Overview zoom calls",
                "key" => "daily-overview-zoom-calls",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Daily Support zoom calls ",
                "key" => "daily-support-zoom-calls ",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Detailed trading reports (CSV)",
                "key" => "detailed-trading-reports-csv",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Customizable Parameters for Advanced Traders",
                "key" => "customizable-parameters-advanced-traders",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "24 hours Customer email Support",
                "key" => "24-hours-customer-email-support",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "multi orders / covers options on market drop",
                "key" => "multi-orders-covers-options-market-drop",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "manual orders/covers option (adding to the everage orders)",
                "key" => "manual-orders-covers-option",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For One Running Cycle)",
                "key" => "manual-liquidation-option-cycle",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Full manual liquidation option (For All Running Cycle)",
                "key" => "manual-liquidation-option-all-running",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Limited) (User Can Define the Number of Cycles after which the bot wull not take more trades)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Multi Cycle Strategy Option (Unlimited)",
                "key" => "multi-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Single Cycle Strategy Option",
                "key" => "single-cycle-strategy-option",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Possibility to use Multi Trading Stategies on the same Coin",
                "key" => "possibility-multi-trading-same-coin",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Real time Fetching for the available USDT.",
                "key" => "real-time-fetching-available-USDT",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Reminder to re fill USDT to the prepaid wallet on law balance (less than $5)",
                "key" => "USDT-prepaid-wallet",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ],
            [
                "title" => "Fetching the balance and giving wornings when overusing the USDT funds",
                "key" => "balance-warnings-USDT-funds",
                "value" => "yes",
                "plan_id" => 4,
                "created_at" => gmdate("Y-m-d H:i:s"),
                "updated_at" => gmdate("Y-m-d H:i:s")
            ]
        ];
        SubscriptionPlanMeta::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
