<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'Laravel'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'Laravel'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'Laravel'),
    'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),
    'isSanitized' => true,
    'is3ds' => true,
];
