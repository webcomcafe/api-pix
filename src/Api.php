<?php

namespace Webcomcafe\Pix;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use stdClass;
use Webcomcafe\Pix\Exceptions\AuthorizationException;

/**
 * Gerenciar requisições para api pix
 *
 * @method static object authenticate(callable $callbackAccessToken) Autentica e obtém token de acesso
 * @method static void setAccessToken($type, $token) Define um token de acesso
 * @method static object createCob(array $config) Cria uma cobrança pix
 *
 */
class Api
{
    /**
     * Ambiente de execução (0-Homologação, 1=Produção)
     *
     * @var string $env
     */
    private $env = '0';

    /**
     * Api de produção
     *
     * @var Client $http
     */
    private $http;

    /**
     * Api de produção
     *
     * @var string $api
     */
    private $api;

    /**
     * Api de homologação
     *
     * @var string $api_h
     */
    private $api_h;

    /**
     * Versão da api
     *
     * @var string $version
     */
    private $version;

    /**
     * Certificado e senha [path/to/cert.pem, pwd]
     *
     * @var array $cert
     */
    private $cert;

    /**
     * Informações de autenticação para obter token de acesso
     *
     * @var array $auth
     */
    private $auth = [];

    /**
     * Configurações da api
     *
     * @var stdClass $config
     */
    private static $config;

    /**
     * Instância da Api
     *
     * @var Api $instance
     */
    private static $instance;

    /**
     * Callback a ser chamado após um processo de autenticação
     *
     * @var callable $authenticateCallback
     */
    private $authenticateCallback;

    /**
     * Iniciando
     */
    public function __construct()
    {
        $this->makeConfig();
        $this->setHttpClient();
    }

    /**
     * Cria uma instância da classe
     *
     * @return Api|static
     */
    private static function instance(): Api
    {
        if( !self::$instance ) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Define configurações de acesso à api
     *
     * @param array $conf
     * @return void
     */
    final public static function config(array $conf)
    {
        Api::$config = (object) $conf;
    }

    /**
     * Define valores de configuração às suas respectivas propriedades
     *
     * @return void
     */
    private function makeConfig()
    {
        foreach (Api::$config as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * Cria objeto de requisições http
     *
     * @return void
     */
    private function setHttpClient()
    {
        $this->http = new Client([
            //'cert'     => $this->cert,
            'base_uri' => $this->getEndpointApi(),
            'timeout'  => 60,
            'headers'  => [
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/json',
            ]
        ]);
    }

    /**
     * Retorna a api adequada conforme o ambiente
     *
     * @return string
     */
    private function getEndpointApi(): string
    {
        $endpoint = ['0'=>$this->api_h, '1'=>$this->api][$this->env];

        if( $version = $this->version ) {
            $endpoint .= '/'.$version;
        }

        return $endpoint;
    }

    /**
     * Cria requisições http à api
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return false|stdClass|string
     */
    private function req(string $method, string $uri, array $options = [])
    {
        $result = new stdClass();

        if( $this->auth['token'] ) {
            $options['headers']['Authorization'] = $this->getAccessToken();
        }

        if( isset($options['data']) ) {
            $options['body'] = json_encode($options['data']);
            unset($options['data']);
        }

        try {

            $args = [$method, $uri];
            if( $options ) $args[] = $options;

            $result = $this->normalizeResponse (
                $this->http->request(...$args)
            );
        } catch (\Throwable $e) {
            $result->detail = $e->getMessage();
            if( $e instanceof RequestException ) {
                $result = $this->normalizeResponse($e->getResponse());
            }
        }

        return $result;
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
     * Realiza processo de autenticação
     *
     * @throws AuthorizationException
     */
    private function makeAuth()
    {
        $token = $this->auth['token'];

        if( !$token || $this->tokenExpired($token) ) {

            $now = new \DateTime;
            $auth = base64_encode($this->auth['client_id'].':'.$this->auth['client_secret']);

            $res = $this->req('POST', '/auth/server/oauth/token', [
                'headers' => [
                    'Authorization' => 'Basic '.$auth,
                ],
                'form_params' => [
                    'grant_type'    => $this->auth['grant_type'],
                    'scope'         => $this->auth['scope'],
                ]
            ]);

            if( isset($res->error) ) {
                throw new AuthorizationException($res->error_description);
            }

            // Montando token
            $this->auth['token'] = $now->getTimestamp().'.'.$res->expires_in.' '.$res->token_type.' '.$res->access_token;

            self::$instance = $this;

            // chamando callback
            ($this->authenticateCallback)($this->auth['token']);
        }
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
        list(, $type, $token) = explode(' ', $this->auth['token']);
        return $type.' '.$token;
    }

    /**
     * Define callback de autenticação
     *
     * @param callable $callback
     * @throws AuthorizationException
     */
    final public function _authenticate(callable $callback)
    {
        $this->authenticateCallback = $callback;

        $this->makeAuth();
    }

    /**
     * Cria uma cobrança
     *
     * @param array $data
     * @return false|stdClass|string
     */
    final public function _createCob(array $data)
    {
        $txId = $data['txid'];
        unset($data['txid']);

        return $this->req('PUT', "/cob/$txId", $data);
    }

    /**
     * @param $name
     * @param $arguments
     * @return false|mixed
     */
    final public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::instance(), '_'.$name], $arguments);
    }
}