<?php

namespace Webcomcafe\Pix\Facades;

use Webcomcafe\Pix\Facade;
use Webcomcafe\Pix\Resource;

/**
 * @method static object create(array $data) Registra um webhook
 */
class Webhook extends Facade
{
    public static function getInstance(): Resource
    {
        return new \Webcomcafe\Pix\Resources\Webhook();
    }
}