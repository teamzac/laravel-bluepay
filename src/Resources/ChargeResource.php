<?php

namespace TeamZac\BluePay\Resources;

use TeamZac\BluePay\Charge;
use TeamZac\BluePay\TamperProofSeal;
use TeamZac\BluePay\Resources\Bp10emuResource;

class ChargeResource extends Bp10emuResource
{
    /**
     * Set the token
     *
     * @param   string $token
     * @return  $this
     */
    public function setToken($token) 
    {
        return $this->mergeParameters([
            'RRNO' => $token,
        ]);
    }

    /**
     * Create the charge
     *
     * @param   string|double $amount
     * @return  $this
     */
    public function create($amount = 0.00)
    {
        $this->mergeParameters([
            'MERCHANT' => $this->client->getAccountID(),
            'TRANSACTION_TYPE' => 'SALE',
            'AMOUNT' => $amount,
        ]);

        $this->mergeParameters([
            'TAMPER_PROOF_SEAL' => TamperProofSeal::forEmulator($this->client, $this->parameters),
        ]);

        $response = $this->client->post('bp10emu', $this->parameters);

        $result = $this->parseResponseHeaders($response->getHeader('Location'));
        $result['AMOUNT'] = $amount;

        return Charge::fromResponse($result);
    }
}
