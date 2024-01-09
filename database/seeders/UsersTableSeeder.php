<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'name' => 'shogo',
            'email' => 'shogo.ohashi0417@gmail.com',
            'password' => 'shogo0417'
        ];

        DB::table('users')->insert($param);
    }
}
