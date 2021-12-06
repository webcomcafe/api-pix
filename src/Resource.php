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
     * @var string $identify
     */
    protected $identify;

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
     * Verifica se há opções de configurações
     *
     * @param array $data
     * @return array
     */
    private function checkForConfigOptions(array &$data): array
    {
        $filter = array_filter ($data, function($key) {
                return substr($key,0,1) == ':';
            },
            ARRAY_FILTER_USE_KEY
        );

        if( empty($filter) ) return [];

        $data = array_diff_key($data, $filter);

        $options = [];
        foreach ($filter as $key => $value)
            $options[substr($key,1)] = $value;

        return $options;
    }

    /**
     * @param string $method
     * @param string|null $param
     * @param array $data
     * @return false|object|string
     */
    final protected function req(string $method, string $param = null, array $data = [])
    {
        $uri = $this->getBaseUri($param);

        $options = $this->checkForConfigOptions($data);

        if( !empty($data) ) $options['body'] = $data;

        return self::$api->req($method, $uri, $options);
    }

    /**
     * @return array|false|object|string
     */
    public function all(array $data = []): object
    {
        return $this->req('GET', null, $data);
    }

    /**
     * @param array $data
     * @return object
     */
    public function create(array $data): object
    {
        return $this->req('POST', null, $data);
    }

    /**
     * @param string $identify
     * @param array $data
     * @return object
     */
    public function find(string $identify, array $data = []): object
    {
        return $this->req('GET', $identify, $data);
    }

    /**
     * @param array $data
     * @return object
     */
    public function update(array $data): object
    {
        $identify = $data[$this->identify];
        unset($data[$this->identify]);

        return $this->req('PUT', $identify, $data);
    }

    /**
     * @param array $data
     * @return object
     */
    public function change(array $data): object
    {
        $identify = $data[$this->identify];
        unset($data[$this->identify]);

        return $this->req('PATCH', $identify, $data);
    }

    /**
     * @param string $identify
     * @param array $data
     * @return object
     */
    public function delete(string $identify, array $data = []): object
    {
        return $this->req('DELETE', $identify, $data);
    }
}