<?php

namespace Webcomcafe\Pix\Psp;

use Webcomcafe\Pix\Psp;

class Bradesco extends Psp
{
    /**
     * @var string $version
     */
    protected $version = '';

    /**
     * @var string $endpoint
     */
    protected $endpoint = 'https://qrpix.bradesco.com.br/api';

    /**
     * @var string $endpoint_h
     */
    protected $endpoint_h = 'https://qrpix-h.bradesco.com.br/api';

    /**
     * @param string|null $param
     * @return string
     */
    public function getAuthURI(string $param = null): string
    {
        return 'auth/server/oauth/token';
    }
}