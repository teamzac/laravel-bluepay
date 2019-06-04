<?php

namespace TeamZac\BluePay\Reports;

use TeamZac\BluePay\Client;
use TeamZac\BluePay\TamperProofSeal;

class SettlementReport
{
    /** @var Client */
    protected $client;

    /** @var array */
    protected $parameters;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->parameters = [
            'ACCOUNT_ID' => $this->client->getAccountID(),
            'MODE' => $this->client->getMode(),
            'REPORT_START_DATE' => null,
            'REPORT_END_DATE' => null,
            'QUERY_BY_SETTLEMENT' => 1,
            'DO_NOT_ESCAPE' => 0,
            'EXCLUDE_ERRORS' => 1,
            'QUERY_BY_HIERARCHY' => 1,
            'TAMPER_PROOF_SEAL' => null,
        ];
    }

    public function setDateRange($start, $end)
    {
        return $this->mergeParameters([
            'REPORT_START_DATE' => $start,
            'REPORT_END_DATE' => $end,
        ]);
    }

    public function run()
    {
        $this->mergeParameters([
            'TAMPER_PROOF_SEAL' => TamperProofSeal::forReport($this->client, $this->parameters),
        ]);

        $result = $this->client->post('bpdailyreport2', $this->parameters);
        
        return $this->parseResponse((string)$result->getBody());
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function parseResponse($csvString)
    {
        list($headers, $data) = collect(explode("\r\n", $csvString))->map(function($row) {
            return str_getcsv($row);
        })->filter(function($row) {
            // ignore the last row, which is empty
            return count($row) > 1;
        })->partition(function($row, $index) {
            return $index == 0;
        });

        return $data->map(function($row) use ($headers) {
            try {
                return array_combine($headers->first(), $row);
            } catch (\Exception $e) {
                dd($headers->count(), count($row));
            }
        })->dd();
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
}