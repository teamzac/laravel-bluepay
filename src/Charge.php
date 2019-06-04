<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;

class Charge
{
    const APPROVED = 'APPROVED';
    const DECLINED = 'DECLINED';
    const DUPLICATE = 'DUPLICATE';
    const MISSING = 'MISSING';

    /** @var array */
    protected $attributes = [];

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
            'amount' => Arr::get($values, 'AMOUNT'),
            'result' => Arr::get($values, 'Result'),
            'message' => Arr::get($values, 'MESSAGE'),
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

    /**
     * Was the charge successful?
     * 
     * @return  boolean
     */
    public function wasSuccessful()
    {
        return $this->get('result') == static::APPROVED;
            // && $this->get('message') != static::DUPLICATE;
    }

    /**
     * Did the charge fail?
     * 
     * @return  boolean
     */
    public function failed()
    {
        return ! $this->wasSuccessful();
    }

    /**
     * Get the error type
     * 
     * @return  BluePayError constant
     */
    public function error()
    {
        if ($this->wasSuccessful()) {
            return BluePayError::None;
        }

        if ($this->get('result') == static::MISSING) {
            return BluePayError::InvalidToken;
        } else if ($this->get('message') == static::DECLINED) {
            return BluePayError::Declined;
        }
        return BluePayError::None;
    }
}