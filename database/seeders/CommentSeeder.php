<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'task_id' => 'e6aa8ace-808d-45cb-b11f-d82d4fb9a06b',
            'user_id' => '1',
            'seen' => true,
            'body' => 'comments body',
        ]);

        DB::table('comments')->insert([
            'task_id' => 'e6aa8ace-808d-45cb-b11f-d82d4fb9a06b',
            'user_id' => '1',
            'seen' => false,
            'body' => 'comments body2',
        ]);
    }
}