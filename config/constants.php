<?php

$config = array(
    'orders' => array(
        'orders_time_interval' => 15,
        'min_start_time' => '7',
        'max_start_time' => '18:45',
        'min_end_time' => '07:15',
        'max_end_time' => '19:00',
    ),
);

return json_encode($config);

?>