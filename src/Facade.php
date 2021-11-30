<?php

namespace Webcomcafe\Pix;

/**
 * @method static object all(array $query = [], array $options = []) Consulta todos
 * @method static object create(array $data, array $options = []) Cria um recurso
 * @method static object find(string $identify,  array $query = [], array $options = []) Consulta um item
 * @method static object update(string $identify, array $data, array $options = []) Atualiza um recurso
 * @method static object change(string $identify, array $data, array $options = []) Revisar um recurso
 * @method static object delete(string $identify, array $options = []) Remove um recurso
 *
 */
abstract class Facade implements FacadeInterface
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $instance = static::getInstance();

        return $instance->{$name}(...$arguments);
    }
}