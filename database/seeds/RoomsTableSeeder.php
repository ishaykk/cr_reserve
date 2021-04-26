<?php

use Illuminate\Database\Seeder;
use App\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::truncate();

        Room::create(['room_id' => 505, 'floor' => 5, 'capacity' => 10, 'projector' => 1, 'occupied' => 1, 'available' => 1]);
        Room::create(['room_id' => 506, 'floor' => 5, 'capacity' => 8, 'projector' => 0, 'occupied' => 0, 'available' => 1]);
        Room::create(['room_id' => 507, 'floor' => 5, 'capacity' => 12, 'projector' => 1, 'occupied' => 1, 'available' => 1]);
        Room::create(['room_id' => 508, 'floor' => 5, 'capacity' => 20, 'projector' => 1, 'occupied' => 0, 'available' => 1]);
    }
}