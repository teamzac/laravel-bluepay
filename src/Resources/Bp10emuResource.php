<?php

namespace TeamZac\BluePay\Resources;

use TeamZac\BluePay\Client;

class Bp10emuResource
{
    /** @var TeamZac/BluePay/Client */
    protected $client;

    /** @var array */
    protected $parameters = [];

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->parameters = [
            'MERCHANT' => null,
            'TRANSACTION_TYPE' => null,
            'PAYMENT_TYPE' => null,
            'AMOUNT' => 0,
            'NAME1' => null,
            'NAME2' => null,
            'ADDR1' => null,
            'ADDR2' => null,
            'CITY' => null,
            'STATE' => null,
            'ZIPCODE' => null,
            'PHONE' => null,
            'EMAIL' => null,
            'COUNTRY' => null,
            'RRNO' => null,
            'CUSTOM_ID' => null,
            'CUSTOM_ID2' => null,
            'INVOICE_ID' => null,
            'ORDER_ID' => null,
            'AMOUNT_TIP' => null,
            'AMOUNT_TAX' => null,
            'AMOUNT_FOOD' => null,
            'AMOUNT_MISC' => null,
            'COMMENT' => null,
            'CC_NUM' => null,
            'CC_EXPIRES' => null,
            'CVCVV2' => null,
            'ACH_ROUTING' => null,
            'ACH_ACCOUNT' => null,
            'ACH_ACCOUNT_TYPE' => null,
            'DOC_TYPE' => null,
            'REBILLING' => null,
            'REB_FIRST_DATE' => null,
            'REB_EXPR' => null,
            'REB_CYCLES' => null,
            'REB_AMOUNT' => null,
            'SWIPE' => null,
            'TAMPER_PROOF_SEAL' => null,
            'TPS_HASH_TYPE' => 'SHA512',
            'REMOTE_IP' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null,
            'RESPONSEVERSION' => 6,
        ];
    }
    
    /**
     * Set the customer information
     *
     * @param   array $attributes
     * @return  $this
     */
    public function setCustomer($attributes = [])
    {
        return $this->mergeParameters($attributes);
    }

    /**
     * Set the CC information
     *
     * @param   array $attributes
     * @return  $this
     */
    public function setCard($attributes = [])
    {
        return $this->mergeParameters($attributes)
            ->mergeParameters([
                'PAYMENT_TYPE' => 'CREDIT'
            ]);
    }

    /**
     * Set the ACH information
     *
     * @param   array $attributes
     * @return  $this
     */
    public function setACH($attributes = [])
    {
        return $this->mergeParameters($attributes)
            ->mergeParameters([
                'PAYMENT_TYPE' => 'ACH'
            ]);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function mergeParameters($override = [])
    {
        $this->parameters = array_merge($this->parameters, $override);
        return $this;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function parseResponseHeaders($header)
    {
        $text = $header[0];
        $result = null;
        parse_str(substr($text, strpos($text, '?') + 1), $result);
        return $result;
    }
    
}