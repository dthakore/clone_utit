<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class CommissionPlanSeeder extends Seeder
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
                "name" => "Default",
                "is_active" => 1,
                "created_at" => now(),
            ]
        ];
        Plan::insert($data);
    }
}
