<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class TodoListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todo_lists')->insert([
            'name' => 'Laravel学習',
            'dead_line' => new DateTime(),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
    }
}
