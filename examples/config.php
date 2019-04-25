<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BookingBug\Config;

//$config = new Config();
//$config->set('appId', 'edb1ef31');
//$config->set('appKey', '7cda5a59e91113e7a0f1b3654dadca86');
//$config->set('useragent', 'BookingBug PHP Client');
//$config->set('url', 'https://assist-dev.bookingbug.com/api/v1');

$config = new Config([
    'appId'     => 'edb1ef31',
    'appKey'    => '7cda5a59e91113e7a0f1b3654dadca86',
    'useragent' => 'BookingBug PHP Client',
    'url'       => 'https://assist-dev.bookingbug.com/api/v1'
]);
var_dump($config);

var_dump($config->validate());

