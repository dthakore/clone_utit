<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            //PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            CountriesTableSeeder::class,
            ExchangesSeeder::class,
            SymbolsSeeder::class,
            UserExchangesSeeder::class,
            BotSeeder::class,
            CoverSeeder::class,
            SessionSeeder::class,
            TradeSeeder::class,
            ExchangeLogsSeeder::class,
            CategorySeeder::class,
            CommissionPlanSeeder::class,
            CommissionRuleSeeder::class,
            DenominationSeeder::class,
            ProductSeeder::class,
            RankSeeder::class,
            WalletMetaTypes::class,
            WalletTypes::class,
            WalletSeeder::class,
            SubscriptionPlanMetaSeeder::class
        ]);
    }
}
