<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\user;
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

        $today = Carbon::now('Israel')->toDateTimeString();
        $yesterday = Carbon::now('Israel')->subDays(1)->format('Y-m-d');
        $twoDaysAgo = Carbon::now('Israel')->subDays(2)->format('Y-m-d');
        $admin = User::first()->id;
        $user = User::skip(2)->first()->id;

        Order::create(['user_id' => $admin, 'room_id' => 505, 'date' => $today, 'start_time' => '07:00:00', 'end_time' => '07:15:00', 'status' => 1]);
        Order::create(['user_id' => $admin, 'room_id' => 505, 'date' => $today, 'start_time' => '07:15:00', 'end_time' => '12:00:00', 'status' => 1]);
        Order::create(['user_id' => $admin, 'room_id' => 506, 'date' => $yesterday, 'start_time' => '08:00:00', 'end_time' => '09:15:00', 'status' => 1]);
        Order::create(['user_id' => $admin, 'room_id' => 507, 'date' => $twoDaysAgo, 'start_time' => '07:00:00', 'end_time' => '07:15:00', 'status' => 1]);
        
        Order::create(['user_id' => $user, 'room_id' => 505, 'date' => $today, 'start_time' => '13:15:00', 'end_time' => '19:00:00', 'status' => 1]);
        Order::create(['user_id' => $user, 'room_id' => 506, 'date' => $today, 'start_time' => '11:15:00', 'end_time' => '12:15:00', 'status' => 1]);
        Order::create(['user_id' => $user, 'room_id' => 506, 'date' => $yesterday, 'start_time' => '10:00:00', 'end_time' => '14:15:00', 'status' => 1]);
        Order::create(['user_id' => $user, 'room_id' => 507, 'date' => $twoDaysAgo, 'start_time' => '16:00:00', 'end_time' => '16:15:00', 'status' => 1]);
        Order::create(['user_id' => $user, 'room_id' => 507, 'date' => $today, 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'status' => 1]);

    }
}
