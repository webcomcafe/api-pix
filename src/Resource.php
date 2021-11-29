<?php

namespace Webcomcafe\Pix;
use stdClass;

abstract class Resource implements ResourceInterface
{
    /**
     * @var Api $api
     */
    protected static $api;

    /**
     * @param Api $api
     * @return void;
     */
    final public static function setApi(Api $api)
    {
        self::$api = $api;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return false|stdClass|string
     */
    final protected function req(string $method, string $uri, array $options = [])
    {
        return self::$api->req($method, $uri, $options);
    }
}