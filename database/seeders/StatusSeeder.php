<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name' => 'sent',
        ]);

        DB::table('statuses')->insert([
            'name' => 'received',
        ]);

        DB::table('statuses')->insert([
            'name' => 'seen',
        ]);

        DB::table('statuses')->insert([
            'name' => 'confirmed',
        ]);

        DB::table('statuses')->insert([
            'name' => 'in progress',
        ]);

        DB::table('statuses')->insert([
            'name' => 'unachieved',
        ]);

        DB::table('statuses')->insert([
            'name' => 'validated',
        ]);
    }
}
