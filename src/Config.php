<?php

namespace BookingBug;

class Config
{
    /**
     * List of allower parameters
     */
    public const ALLOWED = [
        'appId',
        'appKey',
        'companyId',
        'useragent',
        'base_url',
        'tries',
        'seconds'
    ];

    /**
     * List of minimal required parameters
     */
    public const REQUIRED = [
        'appId',
        'appKey',
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
        'useragent'   => 'BookingBug PHP Client',
        'base_url'    => 'https://uk.bookingbutt.com'
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
     * @param string          $name
     * @param string|bool|int $value
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
     * @return string|bool|int
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
     * @param bool  $ignore       Ignore parameters which is not important for client
     * @param array $ignore_items Which items should be excluded from array
     * @return array
     */
    public function all($ignore = false, array $ignore_items = ['tries', 'seconds']): array
    {
        $parameters = $this->_parameters;
        // Remove ignored items from array
        if ($ignore) {
            foreach ($parameters as $name => $value) {
                if (in_array($name, $ignore_items, false)) {
                    unset($parameters[$name]);
                }
            }
        }
        return $parameters;
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
