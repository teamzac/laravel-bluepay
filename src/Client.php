<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;
use GuzzleHttp\Client as Guzzle;
use TeamZac\BluePay\Resources\TokenResource;
use TeamZac\BluePay\Resources\ChargeResource;
use TeamZac\BluePay\Reports\TransactionReport;

class Client
{
    /** @var GuzzleHttp/Client */
    protected $guzzle;

    /** @var string */
    protected $accountId;

    /** @var string */
    protected $secretKey;

    /** @var string <LIVE/TEST> */
    protected $mode;

    /** @var boolean */
    protected $debug;

    /**
     * @param   string $accountId
     * @param   string $secretKey
     * @param   string $mode
     */
    public function __construct($accountId, $secretKey, $mode, $debug = false)
    {
        $this->accountId = $accountId;
        $this->secretKey = $secretKey;
        $this->mode = $mode;
        $this->debug = $debug;

        $this->guzzle = new Guzzle([
            'base_uri' => 'https://secure.bluepay.com/interfaces/',
            'timeout' => 10.0,
            'debug' => $this->debug,
        ]);
    }

    public function getAccountID() 
    {
        return $this->accountId;
    }

    public function getMode() 
    {
        return $this->mode;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function tokens() 
    {
        return new TokenResource($this);
    }

    public function charges() 
    {
        return new ChargeResource($this);
    }

    public function transactionReport()
    {
        return new TransactionReport($this);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function post($endpoint, $params)
    {
        $params['MODE'] = $this->mode;
        if (!isset($params['TAMPER_PROOF_SEAL'])) {
            throw new \Exception('No tamper proof seal was provided');
        }

        $response = $this->guzzle->post($endpoint, [
            'form_params' => $params,
            'allow_redirects' => false,
            'headers' => [
                'User-Agent' => 'BluePay PHP Client',
            ]
        ]);
        
        return $response;
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    // public function calculateTamperProofSeal($parameters = [])
    // {
    //     $tamperProofString = sprintf(
    //         '%s%s%s%s%s%s%s%s%s%s%s',
    //         $this->secretKey,
    //         $this->accountId,
    //         Arr::get($parameters, 'TRANSACTION_TYPE'),
    //         Arr::get($parameters, 'AMOUNT'),
    //         Arr::get($parameters, 'REBILLING'),
    //         Arr::get($parameters, 'REB_FIRST_DATE'),
    //         Arr::get($parameters, 'REB_EXPR'),
    //         Arr::get($parameters, 'REB_CYCLES'),
    //         Arr::get($parameters, 'REB_AMOUNT'),
    //         Arr::get($parameters, 'RRNO'),
    //         $this->mode
    //     );
        
    //     return bin2hex(hash('sha512', $tamperProofString, true));
    // }
}
