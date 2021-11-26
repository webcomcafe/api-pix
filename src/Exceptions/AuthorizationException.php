<?php

namespace Webcomcafe\Pix\Exceptions;

class AuthorizationException extends \Exception
{
    protected $message = 'Não foi possível autenticar';
}