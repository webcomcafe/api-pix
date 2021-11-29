<?php

require __DIR__.'/../vendor/autoload.php';

use Webcomcafe\Pix\Api;
use Webcomcafe\Pix\Facades\Cob;
use \Webcomcafe\Pix\Facades\Webhook;

$name = __DIR__.'/access_token.txt';

echo strtotime('now');

$api = new Api([
    'env'   => '0',
    'psp'   => \Webcomcafe\Pix\Psp::BRADESCO,
    //'cert'  => [__DIR__.'/../certs/cert.pem', __DIR__.'/../certs/key.pem'],
    'auth'  => ['cHMiG8_dQxXrmjDO9kS6mTfA', 'AlkP3zSRyl2-7nA_MHrGUudLpeRTDrWOXn7Rybx0xF_G_E1n'],
    'token' => file_exists($name) ? file_get_contents($name) : null,
]);

$api->authenticate(function($token) use ($name) {
    file_put_contents($name, $token);
});

$cob = Cob::create([]);
//$hook = Webhook::create([
//    'txid' => '',
//    'webhookUrl' => '',
//]);
//
var_dump([$cob]);