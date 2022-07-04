<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stock')->insert([
            'ISBN13' => 'testISBN12345',
            'bookName' => 'testName',
            'bookAuthor' => 'testAuthor',
            'qty' => '5'
        ]);
    }
}
