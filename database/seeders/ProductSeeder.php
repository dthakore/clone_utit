<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $data = [
            [
                "name" => "Free Plan",
                "sku" => "Free",
                "price" => 0,
                "short_description" => "Free Plan",
                "description" => "Free plan for all user - Default Plan",
                "is_active" => 1,
                "is_subscription_enabled" => 1,
                "category_id" => 1,
                "created_at" => now()
            ],
            [
                "name" => "199$ Plan",
                "sku" => "P1",
                "price" => 199.00,
                "short_description" => "199$ Plan",
                "description" => "199$ Plan",
                "is_active" => 1,
                "is_subscription_enabled" => 1,
                "category_id" => 1,
                "created_at" => now()
            ],
            [
                "name" => "599$ Plan",
                "sku" => "P2",
                "price" => 599.00,
                "short_description" => "599$ Plan",
                "description" => "599$ Plan",
                "is_active" => 1,
                "is_subscription_enabled" => 1,
                "category_id" => 2,
                "created_at" => now()
            ],
            [
                "name" => "1599$ Plan",
                "sku" => "P3",
                "price" => 1599.00,
                "short_description" => "1599$ Plan",
                "description" => "1599$ Plan",
                "is_active" => 1,
                "is_subscription_enabled" => 1,
                "category_id" => 1,
                "created_at" => now()
            ]
        ];
        Product::insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
