<?php

namespace Webcomcafe\Pix;

interface PspInterface
{
    /**
     * Banco Central
     *
     * @var string
     */
    const BACEN = '000';

    /**
     * Bradesco
     *
     * @var string
     */
    const BRADESCO = '237';

    /**
     * @param Api $api
     * @return mixed
     */
    public function setApi(Api $api): PspInterface;

    /**
     * @param string $env
     * @return PspInterface
     */
    public function setEnv(string $env): PspInterface;

    /**
     * @param array $cert
     * @return PspInterface
     */
    public function setCert(array $cert): PspInterface;

    /**
     * @param string $clientId
     * @return PspInterface
     */
    public function setClientId(string $clientId): PspInterface;

    /**
     * @param string $clientSecret
     * @return PspInterface
     */
    public function setClientSecret(string $clientSecret): PspInterface;

    /**
     * @param string $grantType
     * @return PspInterface
     */
    public function setGrantType(string $grantType = null): PspInterface;

    /**
     * @param string $scope
     * @return PspInterface
     */
    public function setScope(string $scope = null): PspInterface;

    /**
     * @param string|null $token
     * @return PspInterface
     */
    public function setToken(string $token = null): PspInterface;

    /**
     * @return string
     */
    public function getVersionURI(): string;

    /**
     * @return string
     */
    public function getEndPointApi(): string;

    /**
     * @param string $param
     * @return string
     */
    public function getAuthURI(string $param = null): string;

    /**
     * @param string $param
     * @return string
     */
    public function getCobURI(string $param = null): string;

    /**
     * @param string $param
     * @return string
     */
    public function getCobVURI(string $param = null): string;

    /**
     * @param string $param
     * @return string
     */
    public function getLoteCobVURI(string $param = null): string;

    /**
     * @param string $param
     * @return string
     */
    public function getPixURI(string $param = null): string;

    /**
     * @param string $param
     * @return string
     */
    public function getWebhookURI(string $param = null): string;
}