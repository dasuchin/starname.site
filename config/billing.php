<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tax Information
    |--------------------------------------------------------------------------
    |
    | The current tax rate and state for which to apply tax to orders for
    |
    */

    'tax' => [
        'rate' => env('TAX_RATE'),
        'state' => env('TAX_STATE')
    ]

];