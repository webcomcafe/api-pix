<?php

namespace Webcomcafe\Pix;
use stdClass as object;

abstract class Resource implements ResourceInterface
{
    /**
     * @var Api $api
     */
    private static $api;

    /**
     * @param Api $api
     * @return void;
     */
    final public static function setApi(Api $api)
    {
        self::$api = $api;
    }

    /**
     * @param string|null $param
     * @return string
     */
    private function getBaseUri(string $param = null): string
    {
        $psp = self::$api->getPsp();

        $name = substr(strrchr(static::class, '\\'), 1);

        return $psp->{'get'.$name.'URI'}($param);
    }

    /**
     * @param string $method
     * @param string|null $param
     * @param array $data
     * @param array $options
     * @return false|object|string
     */
    final protected function req(string $method, string $param = null, array $data = [], array $options = [])
    {
        $uri = $this->getBaseUri($param);

        if( !empty($data) ) $options['body'] = $data;

        return self::$api->req($method, $uri, $options);
    }

    /**
     * @return array|false|object|string
     */
    public function all(array $query = [], array $options = []): object
    {
        return $this->req('GET', null, [], $options);
    }

    /**
     * @param array $data
     * @param array $options
     * @return object
     */
    public function create(array $data, array $options = []): object
    {
        return $this->req('POST', null, $data, $options);
    }

    /**
     * @param string $identify
     * @param array $query
     * @param array $options
     * @return object
     */
    public function find(string $identify, array $query = [], array $options = []): object
    {
        $options['query'] = $query;

        return $this->req('GET', $identify, [], $options);
    }

    /**
     * @param string $identify
     * @param array $data
     * @param array $options
     * @return object
     */
    public function update(string $identify, array $data, array $options = []): object
    {
        return $this->req('PUT', $identify, $data, $options);
    }

    /**
     * @param string $identify
     * @param array $data
     * @param array $options
     * @return object
     */
    public function change(string $identify, array $data, array $options = []): object
    {
        return $this->req('PATCH', $identify, $data, $options);
    }

    /**
     * @param string $identify
     * @param array $options
     * @return object
     */
    public function delete(string $identify, array $options = []): object
    {
        return $this->req('DELETE', $identify, [], $options);
    }
}