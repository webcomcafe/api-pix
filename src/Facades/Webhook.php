<?php

namespace Webcomcafe\Pix\Facades;

use Webcomcafe\Pix\Facade;
use Webcomcafe\Pix\Resource;

class Webhook extends Facade
{
    public static function getInstance(): Resource
    {
        return new \Webcomcafe\Pix\Resources\Webhook();
    }
}