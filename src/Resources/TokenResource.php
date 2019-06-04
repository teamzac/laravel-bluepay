<?php

namespace TeamZac\BluePay\Resources;

use TeamZac\BluePay\Token;
use TeamZac\BluePay\TamperProofSeal;
use TeamZac\BluePay\Resources\Bp10emuResource;

class TokenResource extends Bp10emuResource
{
    /**
     * Create the resource
     *
     * @param   array $attributes
     * @return  $this
     */
    public function create($attributes = [])
    {
        $this->mergeParameters([
            'MERCHANT' => $this->client->getAccountID(),
            'TRANSACTION_TYPE' => 'AUTH',
            'AMOUNT' => '0.00',
        ]);

        $this->mergeParameters([
            'TAMPER_PROOF_SEAL' => TamperProofSeal::forEmulator($this->client, $this->parameters),
        ]);

        $response = $this->client->post('bp10emu', $this->parameters);

        $result = $this->parseResponseHeaders($response->getHeader('Location'));

        return Token::fromResponse($result);
    }
}
