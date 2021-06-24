<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

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
                'id' => Uuid::uuid1()->toString(),
                'code' => 'MXN',
                'name' => 'Peso Mexicano',
                'base_exchange_rate' => 1,
                'exchange_rate' => 1
            ],
            [
                'id' => Uuid::uuid1()->toString(),
                'code' => 'USD',
                'name' => 'Dólar Estadounidense',
                'base_exchange_rate' => 0.050,
                'exchange_rate' => 20.03,
            ],
            [
                'id' => Uuid::uuid1()->toString(),
                'code' => 'EUR',
                'name' => 'Euro',
                'base_exchange_rate' => 0.042,
                'exchange_rate' => 23.90,
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
