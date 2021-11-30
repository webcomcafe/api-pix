<?php

namespace Webcomcafe\Pix;

use Webcomcafe\Pix\Psp\Bradesco;

abstract class Psp implements PspInterface
{
    use ResourceUriTrait;

    /** @var string Banco Bradesco */
    const BRADESCO = '237';

    /**
     * @var Api $api
     */
    public $api;

    /**
     * 0-Homologação, 1-Produção
     *
     * @var string $env
     */
    public $env;

    /**
     * Certificado e senha [path/to/cert.pem, password]
     *
     * @var array $cert
     */
    public $cert;

    /**
     * @var string $clientId
     */
    public $clientId;

    /**
     * @var string $clientSecret
     */
    public $clientSecret;

    /**
     * @var string $grantType
     */
    public $grantType;

    /**
     * @var string $scope
     */
    public $scope;

    /**
     * @var string $token
     */
    public $token;

    /**
     * @param Api $api
     * @return PspInterface
     */
    final public function setApi(Api $api): PspInterface
    {
        $this->api = $api;
        return $this;
    }

    /**
     * @param string $env
     * @return PspInterface
     */
    final public function setEnv(string $env): PspInterface
    {
        $this->env = $env;
        return $this;
    }

    /**
     * @param array $cert
     * @return PspInterface
     */
    final public function setCert(array $cert): PspInterface
    {
        $this->cert = $cert;
        return $this;
    }

    /**
     * @param string $clientId
     * @return $this
     */
    final public function setClientId(string $clientId): PspInterface
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param string $clientSecret
     * @return $this
     */
    final public function setClientSecret(string $clientSecret): PspInterface
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @param string $grantType
     * @return $this
     */
    final public function setGrantType(string $grantType = null): PspInterface
    {
        $this->grantType = $grantType ?? 'client_credentials';
        return $this;
    }

    /**
     * @param string $scope
     * @return $this
     */
    final public function setScope(string $scope = null): PspInterface
    {
        $this->scope = $scope ?? '';
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    final public function setToken(string $token = null): PspInterface
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Fabrica um psp
     *
     * @param string $code
     * @return PspInterface
     */
    public static function factory(string $code): PspInterface
    {
        switch ($code)
        {
            case self::BRADESCO:
                return new Bradesco();

        }
    }
}