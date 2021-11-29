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
    public function setGrantType(string $grantType): PspInterface;

    /**
     * @param string $scope
     * @return PspInterface
     */
    public function setScope(string $scope): PspInterface;

    /**
     * @param string|null $token
     * @return PspInterface
     */
    public function setToken(string $token = null): PspInterface;

    /**
     * @return string
     */
    public function getEndPointApi(): string;

    /**
     * @return string
     */
    public function getCobUri(): string;

    /**
     * @return string
     */
    public function getWebhookUri(): string;
}