<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'id'=> Str::uuid(),
            'relation_id' => '1',
            'title' => 'learn laravel',
            'description' => 'eloquents',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '1',
            'title' => 'learn laravel 8',
            'description' => 'error code',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '2',
            'title' => 'learn OWL',
            'description' => 'OWL',
            'status_id' => '1',
        ]);
       
        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '2',
            'title' => 'learn JS',
            'description' => 'JS',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '3',
            'title' => 'todo list frontend',
            'description' => 'tailwindcss',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '3',
            'title' => 'web design',
            'description' => 'design',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '4',
            'title' => 'backend api',
            'description' => 'Json',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '4',
            'title' => 'Laravel api',
            'description' => 'api',
            'status_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'id'=> Str::uuid(),
            'relation_id' => '4',
            'title' => 'date test',
            'description' => 'test description',
            'status_id' => '1',
            'deadline' => '2021-12-02'
        ]);
    }
}
