<?php

namespace Webcomcafe\Pix;

use stdClass;

/**
 * Gerenciar requisições para api pix
 *
 * @method static object setAccessToken(string $token) Define o token de acesso
 * @method static object createCob(array $data) Cria uma cobrança pix
 *
 */
class Api
{
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
        $this->authenticate();
    }

    /**
     * Instancia classe
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
     * Autenticação e obtenção de token de acesso
     *
     * @return void
     */
    private function authenticate()
    {
        echo '<pre>';
        print_r(static::$config->api_h);
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

    public function _createCob(array $data)
    {

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