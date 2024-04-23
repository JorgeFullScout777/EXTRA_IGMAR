<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jorge Luis',
            'email' => 'jorgefullscout2.0@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
