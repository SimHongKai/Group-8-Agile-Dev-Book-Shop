<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => -1,
            'username' => 'SIMHK',
            'userEmail' => 'SIMHK@gmail.com',
            'userPassword' => Hash::make('PotatoSim@10'),
            'userPrivilige' => 2
        ]);
    }
}
