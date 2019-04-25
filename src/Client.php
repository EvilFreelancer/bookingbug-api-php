<?php

namespace BookingBug;

use GuzzleHttp\Exception\GuzzleException;

/**
 * @author  Paul Rock <paul@drteam.rocks>
 * @link    http://drteam.rocks
 * @license MIT
 * @package BookingBug
 */
class Client
{
    /**
     * Initial state of some variables
     */
    protected $_client;

    /**
     * @var Config
     */
    protected $_config;

    /**
     * Count of tries
     *
     * @var int
     */
    private $tries = 10;

    /**
     * Waiting time per each try
     *
     * @var int
     */
    private $seconds = 10;

    /**
     * List of allowed methods
     */
    public const ALLOWED_METHODS = [
        'get',
        'post',
    ];

    /**
     * Client constructor.
     *
     * @param array|Config $config User defined configuration
     * @throws \Exception
     */
    public function __construct($config)
    {
        // If array then need create object
        if (\is_array($config)) {
            $config = new Config($config);
        }

        // Count of tries
        if ($config->get('tries') !== false) {
            $this->tries = $config->get('tries');
        }

        // Waiting time
        if ($config->get('seconds') !== false) {
            $this->tries = $config->get('seconds');
        }

        // Save config into local variable
        $this->_config = $config;

        // Store the client object
        $this->_client = new \GuzzleHttp\Client($config->getGuzzle());
    }

    /**
     * Get some parameter from config
     *
     * @param string $parameter Name of required parameter
     * @return mixed
     * @throws \Exception
     */
    private function config(string $parameter)
    {
        return $this->_config->get($parameter);
    }

    /**
     * Request executor with timeout and repeat tries
     *
     * @param string $type   Request method
     * @param string $url    endpoint url
     * @param array  $params List of parameters
     * @return bool|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function repeatRequest($type, $url, $params)
    {
        for ($i = 1; $i < $this->tries; $i++) {

            // Execute the request to server
            $result = $this->_client->request($type, $url);

            print_r($type);
            print_r($url);
            die();

            // Check the code status
            $code = $result->getStatusCode();

            // If code is not 405 (but 200 foe example) then exit from loop
            if ($code === 200 || $code === 500) {
                return $result;
            }

            // If page returned 404 error
            if ($code === 404) {
                throw new \Exception('404 Page not found');
            }

            // Waiting in seconds
            sleep($this->seconds);
        }

        // Return false if loop is done but no answer from server
        return false;
    }

    /**
     * Make the request and analyze the result
     *
     * @param string $type     Request method
     * @param string $endpoint Api request endpoint
     * @param array  $params   List of parameters
     * @param bool   $raw      Return data in raw format
     *
     * @return mixed|bool Array with data or error, or False when something went fully wrong
     * @throws \Exception
     */
    public function doRequest($type, $endpoint, array $params = [], $raw = false)
    {
        try {
            // Execute the request to server
            $result = $this->repeatRequest($type, $endpoint, $params);

            var_dump($result);
            die();

            // Return result
            return $raw ? (string) $result->getBody() : json_decode($result->getBody());

        } catch (GuzzleException $e) {
            echo $e->getMessage() . "\n";
            echo $e->getTrace();
        }

        return false;
    }

}
