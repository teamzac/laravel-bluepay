<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;

class TamperProofSeal
{
    public static function forEmulator(Client $client, $parameters)
    {
        $tamperProofString = sprintf(
            '%s%s%s%s%s%s%s%s%s%s%s',
            $client->getSecretKey(),
            $client->getAccountID(),
            Arr::get($parameters, 'TRANSACTION_TYPE'),
            Arr::get($parameters, 'AMOUNT'),
            Arr::get($parameters, 'REBILLING'),
            Arr::get($parameters, 'REB_FIRST_DATE'),
            Arr::get($parameters, 'REB_EXPR'),
            Arr::get($parameters, 'REB_CYCLES'),
            Arr::get($parameters, 'REB_AMOUNT'),
            Arr::get($parameters, 'RRNO'),
            $client->getMode()
        );
        
        return bin2hex(hash('sha512', $tamperProofString, true));
    }

    public static function forReport(Client $client, $parameters)
    {
        $tamperProofString = sprintf(
            '%s%s%s',
            $client->getAccountID(),
            Arr::get($parameters, 'REPORT_START_DATE'),
            Arr::get($parameters, 'REPORT_END_DATE')
        );

        return bin2hex(hash_hmac('sha512', $tamperProofString, $client->getSecretKey(), true));
    }
}
