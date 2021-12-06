<?php

namespace Webcomcafe\Pix\Facades;

use Webcomcafe\Pix\Facade;
use Webcomcafe\Pix\Resource;

/**
 * Reúne endpoints destinados a lidar com gerenciamento de cobranças imediatas.
 */
class Cob extends Facade
{
    protected static function getInstance(): Resource
    {
        return new \Webcomcafe\Pix\Resources\Cob();
    }
}