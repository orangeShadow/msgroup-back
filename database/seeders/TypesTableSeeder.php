<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert(
            [
                ['title' => 'Компьютеры'],
                ['title' => 'Мобильные устройства'],
                ['title' => 'Бытовая техника'],
            ]
        );
    }
}
