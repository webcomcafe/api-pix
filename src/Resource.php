<?php

namespace Webcomcafe\Pix;

abstract class Resource implements ResourceInterface
{
    /**
     * @var Api $api
     */
    private static $globalApi;

    /**
     * @var Api $api;
     */
    protected $api;

    /**
     * @var Psp $psp
     */
    protected $psp;

    /**
     * __construct
     */
    final public function __construct()
    {
        $this->api = self::$globalApi;
        $this->psp = $this->api->getPsp();
    }

    /**
     * @param Api $api
     * @return void;
     */
    final public static function setApi(Api $api)
    {
        self::$globalApi = $api;
    }
}