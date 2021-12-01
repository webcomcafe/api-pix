<?php

namespace Webcomcafe\Pix\Psp;

use Webcomcafe\Pix\Psp;

class Bradesco extends Psp
{
    /**
     * [0]-Homologação, [1]-Produção
     *
     * @var array $endpoint
     */
    protected $baseURL = ['https://qrpix-h.bradesco.com.br/v2', 'https://qrpix.bradesco.com.br/v2'];

    /**
     * @return string
     */
    public function getAuthURI(): string
    {
        return '/auth/server/oauth/token';
    }
}