<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
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
                'status_name' => 'Plaćeno',
                'created_at' => now()
            ],
            [
                'status_name' => 'Neplaćeno',
                'created_at' => now()
            ],            [
                'status_name' => 'Prošao Rok',
                'created_at' => now()
            ],
        ];
        DB::table('invoice_statuses')->insert($data);

    }
}
