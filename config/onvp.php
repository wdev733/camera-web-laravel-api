<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Office IP Addresses
    |--------------------------------------------------------------------------
    |
    | A list of IP addresses which are associated with the RNL offices.
    | Some API calls are protected and can only be called from the office.
    |
    */

   'office_ips' => [
       '192.168.0.1',
       '10.100.0.0/24',
       '172.16.0.0/16',
   ],

    /*
    |--------------------------------------------------------------------------
    | Server API Secret Key
    |--------------------------------------------------------------------------
    |
    | The /server-api/ endpoints are protected using a preshared secret key.
    | It needs to be defined here.
    |
    */

    'serverapi_secret_key' => env('SERVERAPI_SECRET_KEY', 'password123!'),
    'proxy_encryption_key' => env('PROXY_ENCRYPTION_KEY', 'password123!'),

];
