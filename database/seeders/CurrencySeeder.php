<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('currencies')->truncate();
        DB::table('currencies')->insert([
            [
                'code' => 'MXN',
                'name' => 'Peso Mexicano',
                'exchange_rate' => 1
            ],
            [
                'code' => 'USD',
                'name' => 'Dólar Estadounidense',
                'exchange_rate' => 20.49,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'exchange_rate' => 24.42,
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
