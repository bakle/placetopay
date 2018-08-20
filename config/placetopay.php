<?php

$seed = date('c');
return [
    'auth' => [
        'login' => env('PLACETOPAY_IDENTIFIER'),
        'tranKey' => sha1($seed . env('PLACETOPAY_TRANSKEY')),
        'seed' => $seed,
        'additional' => []
    ]
];