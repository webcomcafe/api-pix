<?php

namespace Webcomcafe\Pix\Psp;

use Webcomcafe\Pix\Psp;

class Bradesco extends Psp
{
    /**
     * @var string $version
     */
    protected $version = 'v2';

    /**
     * @var string $endpoint
     */
    protected $endpoint = 'https://qrpix.bradesco.com.br';

    /**
     * @var string $endpoint_h
     */
    protected $endpoint_h = 'https://qrpix-h.bradesco.com.br';

    /**
     * @var string $endpointAuth
     */
    protected $uriAuth = '/auth/server/oauth/token';

    /**
     * @return string
     */
    public function getCobUri(): string
    {
        return '/bradesco/cob';
    }

    public function getWebhookUri(): string
    {
        return '/bradesco/webhook';
    }
}