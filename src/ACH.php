<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;

class ACH
{
    protected $attributes = [];

    public function __construct($attributes)
    {
        $this->attributes = [
            'number' => substr(Arr::get($attributes, 'PAYMENT_ACCOUNT'), -4),
            'type' => substr(Arr::get($attributes, 'PAYMENT_ACCOUNT'), 0, 1),
            'bank' => Arr::get($attributes, 'BANK_NAME'),
        ];
    }

    public function get($key)
    {
        return Arr::get($this->attributes, $key);
    }
}
