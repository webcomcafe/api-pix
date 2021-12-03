<?php

namespace Webcomcafe\Pix;

class Payload
{
    /** @var string Globally Unique Identifier */
    const GUI = 'br.gov.bcb.pix';
    /** @var string Payload Format Indicator */
    const PAYLOAD_FORMAT_INDICATOR = '01';
    /** @var string Merchant Category Code */
    const MERCHANT_CATEGORY_CODE = '0000';
    /** @var string Transaction Currency */
    const TRANSACTION_CURRENCY = '986';
    /** @var string Country Code */
    const COUNTRY_CODE = 'BR';

    /**
     * Nome do recebedor
     *
     * @var string $merchantName
     */
    private $merchantName;

    /**
     * Cidade do recebedor
     *
     * @var string $merchantCity
     */
    private $merchantCity;

    /**
     * Chave PIX
     *
     * @var string $chave
     */
    private $chave;

    /**
     * Valor a ser pago
     *
     * @var float $amount
     */
    private $amount;


    /**
     * Nome do recebedor
     * 
     * @param string $value
     * @return $this
     */
    public function setMerchantName(string $value): Payload
    {
        $this->merchantName = $value;

        return $this;
    }

    /**
     * Cidade do recebedor
     *
     * @param string $value
     * @return $this
     */
    public function setMerchantCity(string $value): Payload
    {
        $this->merchantCity = $value;

        return $this;
    }

    /**
     * Chave Pix do recebdor
     *
     * @param string $value
     * @return $this
     */
    public function setChave(string $value): Payload
    {
        $this->chave = $value;

        return $this;
    }

    /**
     * Valor a ser apago
     *
     * @param float $value
     * @return $this
     */
    public function setAmount(float $value): Payload
    {
        $this->amount = $value;

        return $this;
    }

    /**
     * Retorna tamanho + valor
     *
     * @param string $value
     * @return string
     */
    private function getValueFrom(string $value): string
    {
        $size = strlen($value);
        $size = str_pad($size, 2, '0', STR_PAD_LEFT);

        return $size.$value;
    }

    /**
     * Retorna o código payload
     *
     * @return string
     */
    public function getPayloadCode(): string
    {
        $payload  = '000201';
        $payload .= '2658'.'00'.$this->getValueFrom(self::GUI).'01'.$this->getValueFrom($this->chave);
        $payload .= '52040000';
        $payload .= '53'.$this->getValueFrom(self::TRANSACTION_CURRENCY);
        $payload .= '58'.$this->getValueFrom(self::COUNTRY_CODE);
        $payload .= '59'.$this->getValueFrom($this->merchantName);
        $payload .= '60'.$this->getValueFrom($this->merchantCity);
        $payload .= '62'.'07'.'05'.$this->getValueFrom('***');

        return $payload;
    }
}