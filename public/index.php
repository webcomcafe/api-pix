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
$samp1 = '00020101021226700014br.gov.bcb.pix2548pix.example.com/8b3da2f39a4140d1a91abd93113bd4415204000053039865802BR5913Fulano de Tal6008BRASILIA62070503***630464E4';
echo '00020101021226770014BR.GOV.BCB.PIX2555api.itau/pix/qr/v2/3ea1b5e2-55b8-4da6-b6e6-1c965f769f485204000053039865802BR5925IFOOD.COM AGENCIA DE REST6009SAO PAULO62070503***63047EAD';
echo '<br>';
echo($code);
echo '<br>';
echo $samp1;
var_dump($code === $samp1);