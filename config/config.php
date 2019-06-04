<?php

return [
    'account_id' => env('BLUEPAY_ACCOUNT_ID', ''),
    'secret' => env('BLUEPAY_SECRET', ''),
    'api_signature' => env('BLUEPAY_API_SIGNATURE', ''),
    'mode' => env('BLUEPAY_MODE', 'TEST'),
    'debug' => env('BLUEPAY_DEBUG', false)
];
