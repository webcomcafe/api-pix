<?php

namespace Webcomcafe\Pix\Resources;

use Webcomcafe\Pix\Resource;
use stdClass as object;

class LoteCobV extends Resource
{
    public function create(array $data): object
    {
        $uri = $this->psp->getLoteCobVURI();
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