<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relations')->insert([
            'admin_id' => 4,
            'sub_id' => 1,
        ]);
        DB::table('relations')->insert([
            'admin_id' => 1,
            'sub_id' => 2,
        ]);
 
        DB::table('relations')->insert([
            'admin_id' => 1,
            'sub_id' => 3,
        ]);
        DB::table('relations')->insert([
            'admin_id' => 3,
            'sub_id' => 1,
        ]);
        DB::table('relations')->insert([
            'admin_id' => 3,
            'sub_id' => 2,
        ]);
    }
}
