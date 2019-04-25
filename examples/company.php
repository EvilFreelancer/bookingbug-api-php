<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BookingBug\Client;
use BookingBug\Endpoint\Company;

//$client = new Client([
//    'app_id'   => 'edb1ef31',
//    'app_key'  => '7cda5a59e91113e7a0f1b3654dadca86',
//    'base_uri' => 'https://assist-dev.bookingbug.com/api/v1'
//]);

$company = new Company([
    'app_id'   => 'edb1ef31',
    'app_key'  => '7cda5a59e91113e7a0f1b3654dadca86',
    'base_uri' => 'https://assist-dev.bookingbug.com'
]);

for ($i = 1; $i < 1000; $i++) {
    try {
        $result = $company->get($i);

        if (!empty($result)) {
            die($i);
        }

    } catch (\Exception $e) {
        echo $e->getMessage() . "\n";
    }
}
