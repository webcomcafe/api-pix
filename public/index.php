<?php

require __DIR__.'/../vendor/autoload.php';

//use Webcomcafe\Pix\Api;
//
//$name = __DIR__.'/access_token.txt';
//
//use \Webcomcafe\Pix\Facades\Cob;
//
//$api = new Api([
//    'env'   => '0',
//    'psp'   => \Webcomcafe\Pix\Psp::BRADESCO,
//    'cert'  => [__DIR__.'/../certs/cert.pem', __DIR__.'/../certs/key.pem'],
//    'auth'  => ['fw6wZj4rrLkM_F0eSEETppOPz58a', '9bmZUsTHlQLTiq19BkhIriNzuEMa'],
//    'token' => file_exists($name) ? file_get_contents($name) : null,
//]);
//
//$api->authenticate(function($token) use ($name) {
//    file_put_contents($name, strtotime('now').'.3600');
//});
//
//$cob = Cob::create([
//
//]);
//
//var_dump($cob);

$payload = (new Webcomcafe\Pix\Payload)
    ->setTxId('***')
    ->setURLLocation('pix.example.com/8b3da2f39a4140d1a91abd93113bd441')
    ->setMerchantName('Fulano de Tal')
    ->setMerchantCity('BRASILIA');

$code = $payload->getPayloadCode();

$qrCode = new \Mpdf\QrCode\QrCode($code);

$image = (new \Mpdf\QrCode\Output\Png)->output($qrCode, 300);

?>

<h1>PIX</h1>

<p><img src="data:image/png;base64,<?=base64_encode($image)?>" alt="PIX" style="border: 1px solid #333;"></p>

<p><strong>Código copia e cola:</strong>: <br> <?=$code?></p>
