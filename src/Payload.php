<?php

namespace Webcomcafe\Pix;

class Payload
{
    /**
     * @var string Globally Unique Identifier
     */
    const GUI = 'br.gov.bcb.pix';
    /**
     * @var string Payload Format Indicator
     */

    const PAYLOAD_FORMAT_INDICATOR = '01';
    /**
     * @var string Point of Initiation Method
     */

    const POINT_INITIATION_METHOD = '12';
    /**
     * @var string Merchant Category Code
     */

    const MERCHANT_CATEGORY_CODE = '0000';
    /**
     * @var string Transaction Currency
     */

    const TRANSACTION_CURRENCY = '986';
    /**
     * @var string Country Code
     */

    const COUNTRY_CODE = 'BR';
    /**
     * @var array Polinômio para cálculo CRC
     */
    const CRC16 = [0xFFFF, 0x1021];

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
     * Url com informações para pagamento
     *
     * @var string $url
     */
    private $url;

    /**
     * Identificador da transação
     *
     * @var string $txid
     */
    private $txid;

    /**
     * Descrição do pagamento
     *
     * @var string $description
     */
    private $description;

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
     * Define a url de pagamento (sem protocolo)
     *
     * @param string $value
     * @return $this
     */
    public function setURLLocation(string $value): Payload
    {
        $this->url = $value;

        return $this;
    }

    /**
     * Define o identificador da transação
     *
     * @param string $value
     * @return $this
     */
    public function setTxId(string $value): Payload
    {
        $this->txid = $value;

        return $this;
    }

    /**
     * Define a descrição do pagamento
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Payload
    {
        $this->description = $description;

        return $this;
    }

    /**
     * TLV (type, length, value)
     *
     * @param string $type
     * @param string $value
     * @return string
     */
    private function setTLV(string $type, string $value): string
    {
        $length = strlen($value);
        $length = str_pad($length, 2, '0', STR_PAD_LEFT);

        return $type.$length.$value;
    }

    /**
     * Cálculo de redundância cíclica
     *
     * @param string $buffer
     * @return string
     */
    private function crc16(string $buffer): string
    {
        $result = self::CRC16[0];

        for ($offset = 0; $offset < strlen($buffer); $offset++)
        {
            $result ^= (ord($buffer[$offset]) << 8);

            for ($bitwise = 0; $bitwise < 8; $bitwise++)
            {
                if (($result <<= 1) & 0x10000)
                    $result ^= self::CRC16[1];

                $result &= self::CRC16[0];
            }
        }

        return  strtoupper(dechex($result));
    }

    /**
     * Monta e retorna o código pix pronto para ser gerado o QR Code
     *
     * @return string
     */
    public function getPayloadCode(): string
    {
        $payload  = $this->setTLV('00', self::PAYLOAD_FORMAT_INDICATOR);
        $payload .= $this->setTLV('01', self::POINT_INITIATION_METHOD);
        $payload .= $this->setTLV('26', $this->setTLV('00', self::GUI).$this->setTLV('25', $this->url));
        $payload .= $this->setTLV('52', self::MERCHANT_CATEGORY_CODE);
        $payload .= $this->setTLV('53', self::TRANSACTION_CURRENCY);
        $payload .= $this->setTLV('58', self::COUNTRY_CODE);
        $payload .= $this->setTLV('59', $this->merchantName);
        $payload .= $this->setTLV('60', $this->merchantCity);
        $payload .= $this->setTLV('62', $this->setTLV('05', $this->txid));
        $payload .= $this->setTLV('63', $this->crc16($payload.'6304'));

        return $payload;
    }
}