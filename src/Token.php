<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;

class Token
{
    public static function fromResponse($attributes = [])
    {
        return new static($attributes);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function __construct($attributes)
    {
        $this->attributes = $this->mapResponseToSensibleAlternatives($attributes);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function mapResponseToSensibleAlternatives($values)
    {
        $attributes = [
            'id' => Arr::get($values, 'RRNO'),
            'result' => Arr::get($values, 'Result'),
        ];

        if (Arr::get($values, 'PAYMENT_TYPE') === 'CREDIT') {
            $attributes['card'] = new Card($values);
        }

        if (Arr::get($values, 'PAYMENT_TYPE') === 'ACH') {
            $attributes['ach'] = new ACH($values);
        }

        return $attributes;
    }

    public function get($key) 
    {
        return Arr::get($this->attributes, $key);
    }
}
