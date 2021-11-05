<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            'relation_id' => '1',
            'title' => 'learn laravel',
            'description' => 'eloquents',
            'status' => 'affected',
        ]);

        DB::table('tasks')->insert([
            'relation_id' => '1',
            'title' => 'learn laravel 8',
            'description' => 'error code',
            'status' => 'affected',
        ]);

        DB::table('tasks')->insert([
            'relation_id' => '2',
            'title' => 'learn OWL',
            'description' => 'OWL',
            'status' => 'affected',
        ]);
       
        DB::table('tasks')->insert([
            'relation_id' => '2',
            'title' => 'learn JS',
            'description' => 'JS',
            'status' => 'affected',
        ]);

        DB::table('tasks')->insert([
            'relation_id' => '3',
            'title' => 'todo list frontend',
            'description' => 'tailwindcss',
            'status' => 'affected',
        ]);

        DB::table('tasks')->insert([
            'relation_id' => '3',
            'title' => 'web design',
            'description' => 'design',
            'status' => 'affected',
        ]);

        DB::table('tasks')->insert([
            'relation_id' => '4',
            'title' => 'backend api',
            'description' => 'Json',
            'status' => 'affected',
        ]);

        DB::table('tasks')->insert([
            'relation_id' => '4',
            'title' => 'Laravel api',
            'description' => 'api',
            'status' => 'affected',
        ]);
    }
}
