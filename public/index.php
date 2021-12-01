<?php

require __DIR__.'/../vendor/autoload.php';

use Webcomcafe\Pix\Api;

$name = __DIR__.'/access_token.txt';

use \Webcomcafe\Pix\Facades\Cob;

$api = new Api([
    'env'   => '0',
    'psp'   => \Webcomcafe\Pix\Psp::BRADESCO,
    //'cert'  => [__DIR__.'/../certs/cert.pem', __DIR__.'/../certs/key.pem'],
    'auth'  => ['fw6wZj4rrLkM_F0eSEETppOPz58a', '9bmZUsTHlQLTiq19BkhIriNzuEMa'],
    'token' => file_exists($name) ? file_get_contents($name) : null,
]);

$api->authenticate(function($token) use ($name) {
    file_put_contents($name, strtotime('now').'.3600');
});

$cob = Cob::create([

]);

var_dump($cob);