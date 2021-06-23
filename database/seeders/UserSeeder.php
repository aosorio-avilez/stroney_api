<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'id' => Uuid::uuid1()->toString(),
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
