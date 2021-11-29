<?php

namespace Webcomcafe\Pix\Resources;

use Webcomcafe\Pix\Resource;
use stdClass as object;

/**
 * Gerencia webhooks
 */
class Webhook extends Resource
{

    public function create(array $config): object
    {
        $uri = self::$api->getPsp()->getWebhookUri();

        $o = new object();
        $o->name = $uri;

        return $o;
    }

    public function find(string $identify, array $config = []): object
    {
        // TODO: Implement find() method.
    }

    public function update(string $identify, array $config): object
    {
        // TODO: Implement update() method.
    }

    public function delete(string $identify, array $config = []): object
    {
        // TODO: Implement delete() method.
    }
}