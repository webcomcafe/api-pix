<?php

namespace Webcomcafe\Pix\Resources;

use Webcomcafe\Pix\Resource;
use stdClass as object;

/**
 * Gerencia cobranças imediatas
 */
class Cob extends Resource
{
    public function create(array $data): object
    {
        $txid = $data['txid'] ?? null;
        $uri = $this->psp->getCobURI($txid);

        $method = $txid ? 'PUT' : 'POST';

        return $this->api->req($method, $uri, $data);
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