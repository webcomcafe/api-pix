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
     * @param string $uri
     * @param string $param
     * @return string
     */
    protected function configURI(string $uri, string $param = null): string
    {
        return $uri.($param ? '/'.$param : '');
    }

    /**
     * @return string
     */
    final public function getVersionURI(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    final public function getEndPointApi(): string
    {
        $endpoint = [$this->endpoint_h, $this->endpoint][$this->env];

        if( $version = $this->getVersionURI() ) {
            $endpoint .= '/'.$version.'/';
        }

        return $endpoint;
    }

    /**
     * @param string $param
     * @return string
     */
    public function getAuthURI(string $param = null): string
    {
        return $this->configURI('auth', $param);
    }

    /**
     * @param string $param
     * @return string
     */
    public function getCobURI(string $param = null): string
    {
        return $this->configURI('cob', $param);
    }

    /**
     * @param string $param
     * @return string
     */
    public function getCobVURI(string $param = null): string
    {
        return $this->configURI('cobv', $param);
    }

    /**
     * @param string $param
     * @return string
     */
    public function getLoteCobVURI(string $param = null): string
    {
        return $this->configURI('lotecobv', $param);
    }

    /**
     *
     * @param string $param
     * @return string
     */
    public function getPixURI(string $param = null): string
    {
        return $this->configURI('pix', $param);
    }

    /**
     * @param string $param
     * @return string
     */
    public function getWebhookURI(string $param = null): string
    {
        return $this->configURI('webhook', $param);
    }
}