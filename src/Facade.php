<?php

namespace Webcomcafe\Pix;

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