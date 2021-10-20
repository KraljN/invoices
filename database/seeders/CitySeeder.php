<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0;$i<5;$i++){
            DB::table('cities')->insert([
                'city_name'=>$faker->city,
                'created_at'=>now()
            ]);
        }
    }
}
