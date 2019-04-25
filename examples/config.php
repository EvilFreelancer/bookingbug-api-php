<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BookingBug\Config;

//$config = new Config();
//$config->set('appId', 'edb1ef31');
//$config->set('appKey', '7cda5a59e91113e7a0f1b3654dadca86');
//$config->set('url', 'https://assist-dev.bookingbug.com/api/v1');

$config = new Config([
    'app_id'    => 'edb1ef31',
    'app_key'   => '7cda5a59e91113e7a0f1b3654dadca86',
    'base_uri'   => 'https://assist-dev.bookingbug.com/api/v1'
]);
var_dump($config);
var_dump($config->validate());
var_dump($config->getGuzzle());
var_dump($config->getAll());
