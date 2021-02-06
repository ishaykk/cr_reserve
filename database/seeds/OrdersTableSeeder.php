<?php

use Illuminate\Database\Seeder;
use App\Order;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::truncate();

        $today = Carbon::now('Israel')->format('Y-m-d');
        $tomorrow = Carbon::now('Israel')->addDays(1)->format('Y-m-d');
        $dayAfterTomorrow = Carbon::now('Israel')->addDays(2)->format('Y-m-d');

        Order::create(['user_id' => 1, 'room_id' => 505, 'date' => $today, 'start_time' => '07:00', 'end_time' => '07:15', 'status' => 1]);
        Order::create(['user_id' => 1, 'room_id' => 506, 'date' => $tomorrow, 'start_time' => '08:00', 'end_time' => '09:15', 'status' => 1]);
        Order::create(['user_id' => 1, 'room_id' => 507, 'date' => $dayAfterTomorrow, 'start_time' => '07:00', 'end_time' => '07:15', 'status' => 1]);
        
        Order::create(['user_id' => 3, 'room_id' => 505, 'date' => $today, 'start_time' => '07:00', 'end_time' => '07:15', 'status' => 1]);
        Order::create(['user_id' => 3, 'room_id' => 506, 'date' => $tomorrow, 'start_time' => '08:00', 'end_time' => '09:15', 'status' => 1]);
        Order::create(['user_id' => 3, 'room_id' => 507, 'date' => $dayAfterTomorrow, 'start_time' => '07:00', 'end_time' => '07:15', 'status' => 1]);
    }
}
