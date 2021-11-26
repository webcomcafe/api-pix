<?php

namespace Webcomcafe\Pix;

use GuzzleHttp\Client;
use stdClass;

/**
 * Gerenciar requisições para api pix
 *
 * @method static object authenticate(callable $callbackAccessToken) Autentica e obtém token de acesso
 * @method static void setAccessToken($type, $token) Define um token de acesso
 * @method static object createCob(array $data) Cria uma cobrança pix
 *
 */
class Api
{
    /**
     * @var Client $api
     */
    private $api;

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
     * Iniciando
     */
    public function __construct()
    {
        $this->setHttpClient();
    }

    /**
     * Cria uma instância da classe
     *
     * @return Api|static
     */
    private static function instance(): Api
    {
        return self::$instance ?? new static();
    }

    /**
     * Cria objeto de requisições http
     *
     * @return void
     */
    private function setHttpClient()
    {
        $this->api = new Client([

        ]);
    }

    /**
     * Autenticação e obtenção de token de acesso
     *
     * @return void
     */
    public function _authenticate(callable $callback)
    {
        $token = $this->get('auth')['token'] ?? null;

    }

    /**
     * Define configurações de acesso à api
     *
     * @param array $conf
     * @return void
     */
    public static function config(array $conf)
    {
        Api::$config = (object) $conf;
    }

    /**
     * Retorna um valor de configuração
     *
     * @param string $name
     * @return null
     */
    private function get(string $name)
    {
        return Api::$config->$name ?? null;
    }

    /**
     * Cria uma cobrança
     *
     * @param array $data
     */
    public function _createCob(array $data)
    {
        //
    }

    /**
     * @param $name
     * @param $arguments
     * @return false|mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::instance(), '_'.$name], $arguments);
    }
}