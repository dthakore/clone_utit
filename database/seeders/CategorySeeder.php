<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "Crypto Bot Trading Packages",
                "description" => "Crypto Bot Trading Packages",
                "is_active" => 1,
                "created_at" => now()
            ]
        ];
        ProductCategory::insert($data);
    }
}
