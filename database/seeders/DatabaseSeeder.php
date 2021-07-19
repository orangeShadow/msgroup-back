<?php

namespace Database\Seeders;

use App\Models\Api\Type;
use App\Models\Chat;
use App\Models\Condition;
use App\Models\Deal;
use App\Models\Deal_malfunction;
use App\Models\Deal_spare;
use App\Models\DealMalfunction;
use App\Models\DealSpare;
use App\Models\Discount;
use App\Models\Fcm;
use App\Models\Fine;
use App\Models\Malfunction;
use App\Models\MalfunctionSpare;
use App\Models\Manufacturer;
use App\Models\Device;
use App\Models\Point;
use App\Models\Push;
use App\Models\Source;
use App\Models\Spare;
use App\Models\UserPoint;
use App\Models\UserMalfunction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Point::factory(12)->create();
        \App\Models\User::factory(30)->create();
        Discount::factory(10)->create();
        Fcm::factory(30)->create();
        Fine::factory(10)->create();
        Malfunction::factory(20)->create();
        Manufacturer::insert([
            ['title' => 'Apple'],
            ['title' => 'Sony'],
            ['title' => 'Toshiba'],
            ['title' => 'Dell'],
            ['title' => 'Acer'],
            ['title' => 'Zanussi'],
            ['title' => 'Nokia'],
            ['title' => 'Motorola'],
            ['title' => 'Panasonic'],
        ]);
        Device::factory(59)->create();
        Source::factory(12)->create();
        Spare::factory(300)->create();
        Condition::factory(9)->create();
        Deal::factory(100)->create();
        Chat::factory(300)->create();
        Push::factory(300)->create();

        // Таблицы связей
        MalfunctionSpare::factory(50)->create();
        UserMalfunction::factory(100)->create();
        DealMalfunction::factory(500)->create();
        DealSpare::factory(500)->create();
    }
}
