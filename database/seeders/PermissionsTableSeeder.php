<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'product_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'product_tag_create',
            ],
            [
                'id'    => 24,
                'title' => 'product_tag_edit',
            ],
            [
                'id'    => 25,
                'title' => 'product_tag_show',
            ],
            [
                'id'    => 26,
                'title' => 'product_tag_delete',
            ],
            [
                'id'    => 27,
                'title' => 'product_tag_access',
            ],
            [
                'id'    => 28,
                'title' => 'product_create',
            ],
            [
                'id'    => 29,
                'title' => 'product_edit',
            ],
            [
                'id'    => 30,
                'title' => 'product_show',
            ],
            [
                'id'    => 31,
                'title' => 'product_delete',
            ],
            [
                'id'    => 32,
                'title' => 'product_access',
            ],
            [
                'id'    => 33,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 34,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 35,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 36,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 37,
                'title' => 'denomination_create',
            ],
            [
                'id'    => 38,
                'title' => 'denomination_edit',
            ],
            [
                'id'    => 39,
                'title' => 'denomination_show',
            ],
            [
                'id'    => 40,
                'title' => 'denomination_delete',
            ],
            [
                'id'    => 41,
                'title' => 'denomination_access',
            ],
            [
                'id'    => 42,
                'title' => 'wallet_meta_type_create',
            ],
            [
                'id'    => 43,
                'title' => 'wallet_meta_type_edit',
            ],
            [
                'id'    => 44,
                'title' => 'wallet_meta_type_show',
            ],
            [
                'id'    => 45,
                'title' => 'wallet_meta_type_delete',
            ],
            [
                'id'    => 46,
                'title' => 'wallet_meta_type_access',
            ],
            [
                'id'    => 47,
                'title' => 'wallet_type_create',
            ],
            [
                'id'    => 48,
                'title' => 'wallet_type_edit',
            ],
            [
                'id'    => 49,
                'title' => 'wallet_type_show',
            ],
            [
                'id'    => 50,
                'title' => 'wallet_type_delete',
            ],
            [
                'id'    => 51,
                'title' => 'wallet_type_access',
            ],
            [
                'id'    => 52,
                'title' => 'wallet_management_access',
            ],
            [
                'id'    => 53,
                'title' => 'allwallettransaction_create',
            ],
            [
                'id'    => 54,
                'title' => 'allwallettransaction_edit',
            ],
            [
                'id'    => 55,
                'title' => 'allwallettransaction_show',
            ],
            [
                'id'    => 56,
                'title' => 'allwallettransaction_delete',
            ],
            [
                'id'    => 57,
                'title' => 'allwallettransaction_access',
            ],
            [
                'id'    => 58,
                'title' => 'order_create',
            ],
            [
                'id'    => 59,
                'title' => 'order_edit',
            ],
            [
                'id'    => 60,
                'title' => 'order_show',
            ],
            [
                'id'    => 61,
                'title' => 'order_delete',
            ],
            [
                'id'    => 62,
                'title' => 'order_access',
            ],
            [
                'id'    => 63,
                'title' => 'cbm_mt_four_account_create',
            ],
            [
                'id'    => 64,
                'title' => 'cbm_mt_four_account_show',
            ],
            [
                'id'    => 65,
                'title' => 'cbm_mt_four_account_access',
            ],
            [
                'id'    => 66,
                'title' => 'mt_four_manager_access',
            ],
            [
                'id'    => 67,
                'title' => 'country_access',
            ],
            [
                'id'    => 68,
                'title' => 'e_commerce_access',
            ],
            [
                'id'    => 69,
                'title' => 'shipment_info_create',
            ],
            [
                'id'    => 70,
                'title' => 'shipment_info_edit',
            ],
            [
                'id'    => 71,
                'title' => 'shipment_info_show',
            ],
            [
                'id'    => 72,
                'title' => 'shipment_info_delete',
            ],
            [
                'id'    => 73,
                'title' => 'shipment_info_access',
            ],
            [
                'id'    => 74,
                'title' => 'order_credit_memo_show',
            ],
            [
                'id'    => 75,
                'title' => 'order_credit_memo_delete',
            ],
            [
                'id'    => 76,
                'title' => 'order_credit_memo_access',
            ],
            [
                'id'    => 77,
                'title' => 'mt_four_broker_create',
            ],
            [
                'id'    => 78,
                'title' => 'mt_four_broker_edit',
            ],
            [
                'id'    => 79,
                'title' => 'mt_four_broker_show',
            ],
            [
                'id'    => 80,
                'title' => 'mt_four_broker_delete',
            ],
            [
                'id'    => 81,
                'title' => 'mt_four_broker_access',
            ],
            [
                'id'    => 82,
                'title' => 'user_position_account_create',
            ],
            [
                'id'    => 83,
                'title' => 'user_position_account_access',
            ],
            [
                'id'    => 84,
                'title' => 'mt_four_deposit_withdraw_create',
            ],
            [
                'id'    => 85,
                'title' => 'mt_four_deposit_withdraw_show',
            ],
            [
                'id'    => 86,
                'title' => 'mt_four_deposit_withdraw_access',
            ],
            [
                'id'    => 87,
                'title' => 'mt_four_trade_show',
            ],
            [
                'id'    => 88,
                'title' => 'mt_four_trade_delete',
            ],
            [
                'id'    => 89,
                'title' => 'mt_four_trade_access',
            ],
            [
                'id'    => 90,
                'title' => 'commission_plan_access',
            ],
            [
                'id'    => 91,
                'title' => 'plan_create',
            ],
            [
                'id'    => 92,
                'title' => 'plan_edit',
            ],
            [
                'id'    => 93,
                'title' => 'plan_show',
            ],
            [
                'id'    => 94,
                'title' => 'plan_delete',
            ],
            [
                'id'    => 95,
                'title' => 'plan_access',
            ],
            [
                'id'    => 96,
                'title' => 'commission_rule_create',
            ],
            [
                'id'    => 97,
                'title' => 'commission_rule_edit',
            ],
            [
                'id'    => 98,
                'title' => 'commission_rule_show',
            ],
            [
                'id'    => 99,
                'title' => 'commission_rule_delete',
            ],
            [
                'id'    => 100,
                'title' => 'commission_rule_access',
            ],
            [
                'id'    => 101,
                'title' => 'rank_create',
            ],
            [
                'id'    => 102,
                'title' => 'rank_edit',
            ],
            [
                'id'    => 103,
                'title' => 'rank_show',
            ],
            [
                'id'    => 104,
                'title' => 'rank_delete',
            ],
            [
                'id'    => 105,
                'title' => 'rank_access',
            ],
            [
                'id'    => 106,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 107,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 108,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 109,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 110,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 111,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 112,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 113,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 114,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 115,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 116,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 117,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 118,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 119,
                'title' => 'contact_management_access',
            ],
            [
                'id'    => 120,
                'title' => 'contact_company_create',
            ],
            [
                'id'    => 121,
                'title' => 'contact_company_edit',
            ],
            [
                'id'    => 122,
                'title' => 'contact_company_show',
            ],
            [
                'id'    => 123,
                'title' => 'contact_company_delete',
            ],
            [
                'id'    => 124,
                'title' => 'contact_company_access',
            ],
            [
                'id'    => 125,
                'title' => 'contact_contact_create',
            ],
            [
                'id'    => 126,
                'title' => 'contact_contact_edit',
            ],
            [
                'id'    => 127,
                'title' => 'contact_contact_show',
            ],
            [
                'id'    => 128,
                'title' => 'contact_contact_delete',
            ],
            [
                'id'    => 129,
                'title' => 'contact_contact_access',
            ],
            [
                'id'    => 130,
                'title' => 'course_create',
            ],
            [
                'id'    => 131,
                'title' => 'course_edit',
            ],
            [
                'id'    => 132,
                'title' => 'course_show',
            ],
            [
                'id'    => 133,
                'title' => 'course_delete',
            ],
            [
                'id'    => 134,
                'title' => 'course_access',
            ],
            [
                'id'    => 135,
                'title' => 'lesson_create',
            ],
            [
                'id'    => 136,
                'title' => 'lesson_edit',
            ],
            [
                'id'    => 137,
                'title' => 'lesson_show',
            ],
            [
                'id'    => 138,
                'title' => 'lesson_delete',
            ],
            [
                'id'    => 139,
                'title' => 'lesson_access',
            ],
            [
                'id'    => 140,
                'title' => 'test_create',
            ],
            [
                'id'    => 141,
                'title' => 'test_edit',
            ],
            [
                'id'    => 142,
                'title' => 'test_show',
            ],
            [
                'id'    => 143,
                'title' => 'test_delete',
            ],
            [
                'id'    => 144,
                'title' => 'test_access',
            ],
            [
                'id'    => 145,
                'title' => 'question_create',
            ],
            [
                'id'    => 146,
                'title' => 'question_edit',
            ],
            [
                'id'    => 147,
                'title' => 'question_show',
            ],
            [
                'id'    => 148,
                'title' => 'question_delete',
            ],
            [
                'id'    => 149,
                'title' => 'question_access',
            ],
            [
                'id'    => 150,
                'title' => 'question_option_create',
            ],
            [
                'id'    => 151,
                'title' => 'question_option_edit',
            ],
            [
                'id'    => 152,
                'title' => 'question_option_show',
            ],
            [
                'id'    => 153,
                'title' => 'question_option_delete',
            ],
            [
                'id'    => 154,
                'title' => 'question_option_access',
            ],
            [
                'id'    => 155,
                'title' => 'test_result_create',
            ],
            [
                'id'    => 156,
                'title' => 'test_result_edit',
            ],
            [
                'id'    => 157,
                'title' => 'test_result_show',
            ],
            [
                'id'    => 158,
                'title' => 'test_result_delete',
            ],
            [
                'id'    => 159,
                'title' => 'test_result_access',
            ],
            [
                'id'    => 160,
                'title' => 'test_answer_create',
            ],
            [
                'id'    => 161,
                'title' => 'test_answer_edit',
            ],
            [
                'id'    => 162,
                'title' => 'test_answer_show',
            ],
            [
                'id'    => 163,
                'title' => 'test_answer_delete',
            ],
            [
                'id'    => 164,
                'title' => 'test_answer_access',
            ],
            [
                'id'    => 165,
                'title' => 'courses_management_access',
            ],
            [
                'id'    => 166,
                'title' => 'system_account_access',
            ],
            [
                'id'    => 167,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 168,
                'title' => 'exchange_create',
            ],
            [
                'id'    => 169,
                'title' => 'exchange_edit',
            ],
            [
                'id'    => 170,
                'title' => 'exchange_show',
            ],
            [
                'id'    => 171,
                'title' => 'exchange_delete',
            ],
            [
                'id'    => 172,
                'title' => 'exchange_access',
            ],
            [
                'id'    => 173,
                'title' => 'user_exchange_create',
            ],
            [
                'id'    => 174,
                'title' => 'user_exchange_edit',
            ],
            [
                'id'    => 175,
                'title' => 'user_exchange_show',
            ],
            [
                'id'    => 176,
                'title' => 'user_exchange_delete',
            ],
            [
                'id'    => 177,
                'title' => 'user_exchange_access',
            ],
            [
                'id'    => 178,
                'title' => 'symbol_access',
            ],
            [
                'id'    => 179,
                'title' => 'bot_create',
            ],
            [
                'id'    => 180,
                'title' => 'bot_edit',
            ],
            [
                'id'    => 181,
                'title' => 'bot_show',
            ],
            [
                'id'    => 182,
                'title' => 'bot_delete',
            ],
            [
                'id'    => 183,
                'title' => 'bot_access',
            ],
            [
                'id'    => 184,
                'title' => 'session_access',
            ],
            [
                'id'    => 185,
                'title' => 'trade_create',
            ],
            [
                'id'    => 186,
                'title' => 'trade_edit',
            ],
            [
                'id'    => 187,
                'title' => 'trade_show',
            ],
            [
                'id'    => 188,
                'title' => 'trade_delete',
            ],
            [
                'id'    => 189,
                'title' => 'trade_access',
            ],
            [
                'id'    => 190,
                'title' => 'cover_create',
            ],
            [
                'id'    => 191,
                'title' => 'cover_edit',
            ],
            [
                'id'    => 192,
                'title' => 'cover_delete',
            ],
            [
                'id'    => 193,
                'title' => 'cover_access',
            ],
            [
                'id'    => 194,
                'title' => 'bot_management_access',
            ],
            [
                'id'    => 195,
                'title' => 'profile_delete_account',
            ],
            [
                'id'    => 196,
                'title' => 'profile_two_factor',
            ],
            [
                'id'    => 197,
                'title' => 'exchange_log_show',
            ],
            [
                'id'    => 198,
                'title' => 'exchange_log_delete',
            ],
            [
                'id'    => 199,
                'title' => 'exchange_log_access',
            ],
            [
                'id'    => 200,
                'title' => 'execute_job_access',
            ],
            [
                'id'    => 201,
                'title' => 'payment_create',
            ],
            [
                'id'    => 202,
                'title' => 'payment_edit',
            ],
            [
                'id'    => 203,
                'title' => 'payment_show',
            ],
            [
                'id'    => 204,
                'title' => 'payment_delete',
            ],
            [
                'id'    => 205,
                'title' => 'payment_access',
            ],
            [
                'id'    => 206,
                'title' => 'mt_four_vpamm',
            ],
            [
                'id'    => 207,
                'title' => 'mt_four_daily_balance',
            ],
            [
                'id'    => 208,
                'title' => 'mt_four_mam_account_show',
            ],
            [
                'id'    => 209,
                'title' => 'mt_four_mam_account_edit',
            ],
            [
                'id'    => 210,
                'title' => 'mt_four_mam_account_delete',
            ],
            [
                'id'    => 211,
                'title' => 'expert_show',
            ],
            [
                'id'    => 212,
                'title' => 'expert_edit',
            ],
            [
                'id'    => 213,
                'title' => 'expert_delete',
            ],
            [
                'id'    => 214,
                'title' => 'user_expert_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
