<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PdvTypeSeeder extends Seeder
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
                'pdv_type_name' => 0,
                'created_at' => now()
            ],
            [
                'pdv_type_name' => 20,
                'created_at' => now()
            ],            [
                'pdv_type_name' => 10,
                'created_at' => now()
            ]
        ];
        DB::table('pdv_types')->insert($data);
    }
}
