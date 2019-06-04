<?php

namespace TeamZac\BluePay\Queries;

use Illuminate\Support\Arr;

class SingleTransactionQuery extends Query
{
    public function run($params = [])
    {
        $params['ACCOUNT_ID'] = $this->client->getAccountId();
        $params['TAMPER_PROOF_SEAL'] = $this->calculateTamperProofSeal($params);
        $params['EXCLUDE_ERRORS'] = 1;
        dd($params);
        $response = $this->client->post('stq', $params);
        dd($response->getHeaders());
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function calculateTamperProofSeal($params)
    {
        $tamperProofString = sprintf(
            '%s%s%s%s',
            $this->client->getSecretKey(),
            $this->client->getAccountId(),
            Arr::get($params, 'REPORT_START_DATE'),
            Arr::get($params, 'REPORT_END_DATE')
        );
        return bin2hex(md5($tamperProofString, true));
    }
}
