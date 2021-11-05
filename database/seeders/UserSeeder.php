<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'dalal@email.com',
            'phone_number' => '673514367',
        ]);

        DB::table('users')->insert([
            'email' => 'User1@email.com',
            'phone_number' => '632997409',
        ]);

        DB::table('users')->insert([
            'email' => 'user2@email.com',
            'phone_number' => '694387793',
        ]);

        DB::table('users')->insert([
            'email' => 'user3@email.com',
            'phone_number' => '6209398466',
        ]);
    }
}
