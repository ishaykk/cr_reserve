<?php

use Illuminate\Database\Seeder;
use App\Configuration;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::truncate();

        Configuration::create(['section' => 'orders', 'key' => 'orders_time_interval', 'value' => '15', 'label' => 'Orders interval']);
        Configuration::create(['section' => 'orders', 'key' => 'min_start_time', 'value' => '7', 'label' => 'Earliest order start time']);
        Configuration::create(['section' => 'orders', 'key' => 'max_start_time', 'value' => '18:45', 'label' => 'Latest order start time']);
        Configuration::create(['section' => 'orders', 'key' => 'min_end_time', 'value' => '07:15', 'label' => 'Earliest order end time']);
        Configuration::create(['section' => 'orders', 'key' => 'max_end_time', 'value' => '19:00', 'label' => 'Latest order end time']);
    }
}
