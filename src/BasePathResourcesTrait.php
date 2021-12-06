<?php

namespace Webcomcafe\Pix;

/**
 * Caminhos base de todos os recursos da api PIX
 *
 * @link https://bacen.github.io/pix-api/index.html
 */
trait BasePathResourcesTrait
{
    /**
     * Base URL
     * [0] Homologação, [1] Produção
     *
     * @var array $endpoint
     */
    protected $baseURL = [];

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
    final public function getBaseURLApi(): string
    {
        $endpoint = $this->baseURL[$this->env];

        return rtrim($endpoint,'/').'/';
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
     * @param string|null $param
     */
    public function getPayloadLocationURI(string $param = null): string
    {
        return $this->configURI('loc', $param);
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