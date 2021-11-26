<?php

require __DIR__.'/../vendor/autoload.php';

use Webcomcafe\Pix\Api;

$name = __DIR__.'/access_token.txt';

$file = file_exists($name);

Api::config([
    'env' => '0',
    'api' => 'https://qrpix.bradesco.com.br',
    'api_h' => 'https://qrpix-h.bradesco.com.br',
    'version' => 'v2',
    //'cert' => ['/path/to/cert', 'pwd'],
    'auth' => [
        'client_id'     => '',
        'client_secret' => '',
        'grant_type'    => '',
        'scope'         => '',
        'token'         => $file ? file_get_contents($name) : null //'1637897802.36000 Bearer XDdSdolfef5514wee',
    ],
]);

Api::authenticate(function($token) use ($name) {
    file_put_contents($name, $token);
});

$cob = Api::createCob([
    'data' => [
        'txid' => 'XDJ5HE45FLK45R',
    ]
]);
