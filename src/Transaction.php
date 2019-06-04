<?php

namespace TeamZac\BluePay;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Transaction
{
    /** @var array */
    protected $attributes = [];

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function __construct($attributes)
    {
        $this->attributes = array_map(function($value) {
            return $value == '' ? null : $value;
        }, $attributes);
    }

    /**
     * Get a human readable value for the result
     * 
     * @return  string
     */
    public function result()
    {
        switch (Arr::get($this->attributes, 'status')) {
            case '1':
                return 'approved';
                break;
            case '0':
                return 'declined';
                break;
            case 'E': 
                return 'error';
                break;
        }
        return 'unknown';
    }

    /**
     * Was the transaction approved?
     * 
     * @return  boolean
     */
    public function approved()
    {
        return $this->status == '1';
    }

    /**
     * Was the transaction declined?
     * 
     * @return  boolean
     */
    public function declined()
    {
        return $this->status == '0';
    }

    /**
     * Did the transaction have an error?
     * 
     * @return  boolean
     */
    public function error()
    {
        return $this->status == 'E';
    }

    /**
     * Has this transaction been settled?
     * 
     * @return  boolean
     */
    public function isSettled()
    {
        return ! is_null($this->settle_date);
    }

    /**
     * 
     * 
     * @param   
     * @return  
     */
    public function __get($key)
    {
        if (method_exists($this, $method = sprintf('get%sAttribute', Str::studly($key)))) {
            return $this->$method;
        }
        return Arr::get($this->attributes, $key);
    }
}
