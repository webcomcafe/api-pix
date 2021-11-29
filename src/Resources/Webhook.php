<?php

namespace Webcomcafe\Pix\Resources;

use Webcomcafe\Pix\Resource;
use stdClass as object;

/**
 * Gerencia webhooks
 */
class Webhook extends Resource
{

    public function create(array $data): object
    {
        $uri = $this->psp->getWebhookURI();

        $o = new object();
        $o->name = $uri;

        return $o;
    }

    public function find(string $identify, array $data = []): object
    {
        // TODO: Implement find() method.
    }

    public function update(string $identify, array $data): object
    {
        // TODO: Implement update() method.
    }

    public function delete(string $identify, array $data = []): object
    {
        // TODO: Implement delete() method.
    }
}