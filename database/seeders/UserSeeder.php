<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('users')->insert([
            'username' => 'pera',
            'password' => Hash::make('pera'),
            'vat' => '123456789',
            'bank_account_number' => 123456789012345678,
            'address' => $faker->streetName . " " . rand(1,300),
            'registration_number' => 1234567890123455,
            'email' => 'pera@gmail.com',
            'is_active' => true,
            'country_id' => rand(1,4),
            'zip' => 32000,
            'city_id' => rand(2,6),
            'full_company_name' => 'Pera Komerc',
            'created_at'=>now()
        ]);
    }
}
