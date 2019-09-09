<?php

namespace BookingBug;

class Config
{
    /**
     * List of allower parameters
     */
    public const ALLOWED = [
        'useragent',
        'base_uri',
        'app_id',
        'app_key',
        'timeout',
        'username',
        'password',
        'tries',
        'seconds'
    ];

    /**
     * List of minimal required parameters
     */
    public const REQUIRED = [
        'useragent',
        'base_uri',
        'timeout',
        'app_id',
        'app_key',
    ];

    /**
     * List of configured parameters
     *
     * @var array
     */
    private $_parameters = [
        // Errors must be disabled by default, because we need to get error codes
        // @link http://docs.guzzlephp.org/en/stable/request-options.html#http-errors
        'http_errors' => false,

        // Main parameters
        'timeout'     => 20,
        'useragent'   => 'BookingBug PHP Client',
        'base_uri'    => 'https://uk.bookingbug.com',
        'base_path'   => '/api/v1'
    ];

    /**
     * Config constructor.
     *
     * @param array $parameters List of parameters which can be set on object creation stage
     * @throws \Exception
     */
    public function __construct(array $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Set parameter by name
     *
     * @param string               $name  Name of parameter
     * @param string|bool|int|null $value Value of parameter
     * @return \BookingBug\Config
     * @throws \Exception
     */
    public function set($name, $value): self
    {
        if (!\in_array($name, $this->getAllowed(), false)) {
            throw new \Exception("Parameter \"$name\" is not in available list [" . implode(',', $this->getAllowed()) . ']');
        }

        // Add parameters into array
        $this->_parameters[$name] = $value;
        return $this;
    }

    /**
     * Get all available parameters on only one
     *
     * @param string $name
     * @return string|bool|int|null
     */
    public function get($name)
    {
        return $this->_parameters[$name] ?? false;
    }

    /**
     * Return all allowed parameters
     *
     * @return array
     */
    public function getAllowed(): array
    {
        return self::ALLOWED;
    }

    /**
     * Return all preconfigured parameters
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->_parameters;
    }

    /**
     * Return all ready for Guzzle parameters
     *
     * @return array
     */
    public function getGuzzle(): array
    {
        return [
            'base_uri' => $this->get('base_uri') . $this->get('base_path'),
            'timeout'  => $this->get('timeout'),
            'headers'  => [
                'User-Agent' => $this->get('useragent'),
                'App-Id'     => $this->get('app_id'),
                'App-Key'    => $this->get('app_key'),
            ]
        ];
    }

    /**
     * Validate preconfigured parameters
     *
     * @return bool
     */
    public function validate(): bool
    {
        foreach (self::REQUIRED as $item) {
            if (false === array_key_exists($item, $this->_parameters)) {
                return false;
            }
        }
        return true;
    }
}
