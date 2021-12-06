<?php

namespace Webcomcafe\Pix\Facades;

use Webcomcafe\Pix\Facade;
use Webcomcafe\Pix\Resource;

/**
 * Reúne endpoints para gerenciamento de notificações por parte do PSP recebedor ao usuário recebedor.
 */
class Webhook extends Facade
{
    public static function getInstance(): Resource
    {
        return new \Webcomcafe\Pix\Resources\Webhook();
    }
}