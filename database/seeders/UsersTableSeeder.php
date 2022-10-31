<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                       => 1,
                'name'                     => 'Admin',
                'email'                    => 'admin@puxeo.com',
                'password'                 => bcrypt('password'),
                'remember_token'           => null,
                'approved'                 => 1,
                'verified'                 => 1,
                'verified_at'              => date("Y-m-d H:i:s"),
                'verification_token'       => '',
                'two_factor_code'          => '',
                'first_name'               => '',
                'middle_name'              => '',
                'last_name'                => '',
                'api_token'                => '',
                'building_num'             => '',
                'street'                   => '',
                'region'                   => '',
                'postcode'                 => '',
                'city'                     => '',
                'phone'                    => '',
                'business_name'            => '',
                'vat_number'               => '',
                'bus_address_building_num' => '',
                'bus_address_street'       => '',
                'bus_address_region'       => '',
                'bus_address_city'         => '',
                'bus_address_postcode'     => '',
                'business_phone'           => '',
                'image'                    => '',
                'token'                    => '',
                'auth'                     => '',
            ],
            [
                'id'                       => 2,
                'name'                     => 'John Doe',
                'email'                    => 'user@puxeo.com',
                'password'                 => bcrypt('password'),
                'remember_token'           => null,
                'approved'                 => 1,
                'verified'                 => 1,
                'verified_at'              => '2021-10-27 07:46:15',
                'verification_token'       => '',
                'two_factor_code'          => '',
                'first_name'               => 'John',
                'middle_name'              => '',
                'last_name'                => 'Doe',
                'api_token'                => '',
                'building_num'             => '',
                'street'                   => '',
                'region'                   => '',
                'postcode'                 => '',
                'city'                     => '',
                'phone'                    => '',
                'business_name'            => '',
                'vat_number'               => '',
                'bus_address_building_num' => '',
                'bus_address_street'       => '',
                'bus_address_region'       => '',
                'bus_address_city'         => '',
                'bus_address_postcode'     => '',
                'business_phone'           => '',
                'image'                    => '',
                'token'                    => '',
                'auth'                     => '',
            ],
        ];

        User::insert($users);
    }
}
