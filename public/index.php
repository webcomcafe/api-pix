<?php

require __DIR__.'/../vendor/autoload.php';

use Webcomcafe\Pix\Api;

Api::config([
    'env' => '0',
    'api' => 'https://qrpix.bradesco.com.br',
    'api_h' => 'https://qrpix-h.bradesco.com.br',
    'version' => 'v2',
    'cert' => ['/path/to/cert', 'pwd'],
    'auth' => [
        'client_id'     => '',
        'client_secret' => '',
        'grant_type'    => '',
        'scope'         => '',
        'token'         => null //'1637897802.36000 Bearer XDdSdolfef5514wee',
    ],
]);

Api::authenticate(function($token) {
    return '1637897802.36000 Bearer XDdSdolfef5514wee';
});

Api::createCob([]);