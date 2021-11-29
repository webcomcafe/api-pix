<?php

namespace Webcomcafe\Pix\Psp;

use Webcomcafe\Pix\Psp;

class Bacen extends Psp
{
    /**
     * @var string $endpoint
     */
    protected $endpoint = 'https://pix.example.com/api';

    /**
     * @var string $endpoint_h
     */
    protected $endpoint_h = 'https://pix-h.example.com/api';

    /**
     * @var string $version
     */
    protected $version = 'v2';

    public function getCobUri(): string
    {
        return '/bacen/cob';
    }

    public function getWebhookUri(): string
    {
        return '/bacen/webhook';
    }
}