<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BookingBug\Config;
use BookingBug\Client;

$config = new Config([
    'app_id'   => 'edb1ef31',
    'app_key'  => '7cda5a59e91113e7a0f1b3654dadca86',
    'base_uri' => 'https://assist-dev.bookingbug.com/api/v1',
]);

$client = new Client($config);
var_dump($client);
