<?php

namespace Webcomcafe\Pix;

/**
 * @method static object all(array $data = []) Consulta todos
 * @method static object create(array $data) Cria um recurso
 * @method static object find(string $identify,  array $data = []) Consulta um item
 * @method static object update(array $data) Atualiza um recurso
 * @method static object change(array $data) Revisar um recurso
 * @method static object delete(string $identify, array $data = []) Remove um recurso
 *
 */
abstract class Facade
{
    /**
     * @return Resource
     */
    abstract protected static function getInstance(): Resource;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    final public static function __callStatic($name, $arguments)
    {
        $instance = static::getInstance();

        return $instance->{$name}(...$arguments);
    }
}