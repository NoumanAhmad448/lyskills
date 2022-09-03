<?php 
return [ 
    'client_id' => env('PAYPAL_LIVE_CLIENT_ID',''),
    'secret' => env('PAYPAL_LIVE_CLIENT_SECRET',''),
    'settings' => array(
        'mode' => env('PAYPAL_MODE','sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];