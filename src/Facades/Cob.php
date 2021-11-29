<?php

namespace Webcomcafe\Pix\Facades;

use Webcomcafe\Pix\Facade;
use Webcomcafe\Pix\Resource;

/**
 * @method static object create(array $config) Cria uma cobrança
 */
class Cob extends Facade
{
    public static function getInstance(): Resource
    {
        return new \Webcomcafe\Pix\Resources\Cob();
    }
}