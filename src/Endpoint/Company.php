<?php

namespace BookingBug\Endpoint;

use BookingBug\Client;

class Company extends Client
{
    /**
     * @param int $company_id
     * @return mixed
     * @throws \Exception
     */
    public function get(int $company_id)
    {
        $endpoint = '/company/' . $company_id;
        return $this->doRequest('get', $endpoint);
    }
}
