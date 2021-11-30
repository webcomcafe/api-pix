<?php

namespace Webcomcafe\Pix\Facades;

use Webcomcafe\Pix\Facade;
use Webcomcafe\Pix\Resource;

/**
 * Gerenciamento de cobranças imediatas.
 */
class Cob extends Facade
{
    public static function getInstance(): Resource
    {
        return new \Webcomcafe\Pix\Resources\Cob();
    }
}