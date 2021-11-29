<?php

namespace Webcomcafe\Pix;

trait ResourceUriTrait
{
    /**
     * Endpoint da api de produção
     *
     * @var string $endpoint
     */
    protected $endpoint;

    /**
     * Endpoint da api de homologação
     *
     * @var string $endpoint_h
     */
    protected $endpoint_h;

    /**
     * Versão da api
     *
     * @var string $version
     */
    protected $version;

    /**
     * Autenticação
     *
     * @var string $endpointAuth
     */
    protected $uriAuth = '/auth';

    /**
     * @return string
     */
    final public function getEndPointApi(): string
    {
        $endpoint = [$this->endpoint_h, $this->endpoint][$this->env];

        if( $this->version ) {
            $endpoint .= '/'.$this->version;
        }

        return $endpoint;
    }

    /**
     * @return string
     */
    final public function getUriAuth(): string
    {
        return $this->uriAuth;
    }

    /**
     * @return string
     */
    public function getCobUri(): string
    {
        return '/cob';
    }

    /**
     * @return string
     */
    public function getWebhookUri(): string
    {
        return '/webhook';
    }
}