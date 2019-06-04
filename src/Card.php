<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;

class Card
{
    /** @var array */
    protected $attributes = [];

    public function __construct($attributes)
    {
        $this->attributes = [
            'type' => Arr::get($attributes, 'CARD_TYPE'),
            'number' => substr(Arr::get($attributes, 'PAYMENT_ACCOUNT'), -4),
            'expiration' => Arr::get($attributes, 'CARD_EXPIRE'),
        ];
    }

    public function get($key)
    {
        return Arr::get($this->attributes, $key);
    }
}
