<?php

namespace Webcomcafe\Pix;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use stdClass as object;
use Webcomcafe\Pix\Exceptions\AuthorizationException;
use Throwable;

/**
 * Gerenciar requisições para api pix
 *
 * @Api
 *
 */
class Api
{
    /**
     * Prestador de serviço de pagamento
     *
     * @var Psp $psp
     */
    private $psp;

    /**
     * Api de produção
     *
     * @var Client $http
     */
    private $http;

    /**
     * Callback a ser chamado após um processo de autenticação
     *
     * @var callable $authenticateCallback
     */
    private $authenticateCallback;

    /**
     * Configurações de acesso à api pix do PSP
     *
     * @var array $config
     */
    private $config;

    /**
     * Iniciando
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setPspInstance($this->config = $config);

        $this->setHttpClient();

        $this->setAsGlobal();
    }

    /**
     * @return void
     * @param array $conf
     */
    private function setPspInstance(array $conf)
    {
        $conf['auth'][2] = $conf['auth'][2] ?? 'client_credentials';
        $conf['auth'][3] = $conf['auth'][3] ?? '';

        list($id, $secret, $grant, $scope) = $conf['auth'];

        $this->psp = Psp::factory($conf['psp'])
            ->setEnv($conf['env'])
            ->setClientId($id)
            ->setClientSecret($secret)
            ->setCert($conf['cert'])
            ->setToken($conf['token'])
            ->setGrantType($grant)
            ->setScope($scope);
    }

    /**
     * Cria objeto de requisições http
     *
     * @return void
     */
    private function setHttpClient()
    {
        $options = [
            'base_uri' => $this->psp->getBaseURLApi(),
            'timeout'  => 60,
            'headers'  => [
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/json',
            ]
        ];

        if( $this->psp->cert ) $options['cert'] = $this->psp->cert;

        $this->http = new Client($options);

        $this->psp->setApi($this);
    }

    /**
     * Define a instância acessível globalmente
     *
     * @return void
     */
    private function setAsGlobal()
    {
        Resource::setApi($this);
    }

    /**
     * Cria requisições http à api
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return false|object|string
     */
    final public function req(string $method, string $uri, array $options = [])
    {
        $object = new object();

        if( $this->psp->token ) {
            $options['headers']['Authorization'] = $this->getAccessToken();
        }

        if( isset($options['body']) ) {
            $options['body'] = json_encode($options['body']);
        }

        try {

            $args = [$method, $uri];
            if( !empty($options) ) $args[] = $options;
            $res = $this->http->request(...$args);
            if( $res = $this->normalizeResponse ($res)) {
                $object = $res;
            }

            $object->success = true;

        } catch (Throwable $e) {

            if( $e instanceof RequestException && ($res=$e->getResponse())) {
                if( $res = $this->normalizeResponse($res) ) {
                    $object = $res;
                }
            }

            $object->detail = $e->getMessage();
        }

        return $object;
    }

    /**
     * Converte resposta json para objeto
     *
     * @param Response $response
     * @return false|string
     */
    private function normalizeResponse(Response $response)
    {
        $contents = $response->getBody()->getContents();

        return json_decode($contents);
    }

    /**
     * Define callback de autenticação
     *
     * @param callable $callback
     * @throws AuthorizationException
     */
    public function authenticate(callable $callback)
    {
        $this->authenticateCallback = $callback;

        if( $this->invalidAccessToken() ) {
            $this->makeAuth();
        }
    }

    /**
     * Verifica se há um token válido
     *
     * @return bool
     */
    private function invalidAccessToken(): bool
    {
        return null==$this->psp->token || $this->tokenExpired($this->psp->token);
    }

    /**
     * Realiza processo de autenticação
     *
     * @throws AuthorizationException
     */
    private function makeAuth()
    {
        $token = base64_encode($this->psp->clientId.':'.$this->psp->clientSecret);

        $res = $this->req('POST', $this->psp->getAuthURI(), [
            'headers' => [
                'Authorization' => 'Basic '.$token,
            ],
            'form_params' => [
                'grant_type'    => $this->psp->grantType,
                'scope'         => $this->psp->scope,
            ]
        ]);

        if( isset($res->error) || isset($res->detail) ) {
            throw new AuthorizationException($res->error_description ?? $res->detail);
        }

        // Montando token
        $now = new \DateTime;
        $now->modify('-10 seconds');
        $token = $now->getTimestamp().'.'.$res->expires_in.' '.$res->token_type.' '.$res->access_token;

        $this->psp->setToken($token);
        $this->setAsGlobal();

        ($this->authenticateCallback)($token);
    }

    /**
     * Verifica se um token expirou
     *
     * @param string $accessToken
     * @return bool
     */
    private function tokenExpired(string $accessToken): bool
    {
        list($timer) = explode(' ', $accessToken);
        list($created_at, $expire_at) = explode('.', $timer);

        $now = new \DateTime;
        $end = new \DateTime;
        $end->setTimestamp($created_at);
        $end->modify('+ '.$expire_at.' seconds');

        return $now >= $end;
    }

    /**
     * Retorna o access token pronto para ser usado
     *
     * @return string
     */
    private function getAccessToken(): string
    {
        list(, $type, $token) = explode(' ', $this->psp->token);
        return $type.' '.$token;
    }

    /**
     * Retorna o psp definido
     *
     * @return Psp
     */
    public function getPsp(): Psp
    {
        return $this->psp;
    }
}