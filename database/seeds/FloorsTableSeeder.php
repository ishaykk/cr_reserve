<?php

use Illuminate\Database\Seeder;
use App\Floor;

class FloorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Floor::truncate();

        Floor::create(['floor_id' => 5]);
    }
}
