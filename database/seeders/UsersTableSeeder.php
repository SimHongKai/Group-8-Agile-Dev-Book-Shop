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
            'username' => 'SIMHK',
            'userEmail' => 'SIMHK@gmail.com',
            'userPassword' => Hash::make('PotatoSim@10')
        ]);
    }
}
