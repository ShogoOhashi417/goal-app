<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
		'name' => 'kazuki',
		'email' => 'test@example.com',
		'age' => 27,
	];
	DB::table('people')->insert($param);

	$param = [
		'name' => 'taro',
		'email' => 'test1example.com',
		'age' => '23',
	];
	DB::table('people')->insert($param);
    }
}
