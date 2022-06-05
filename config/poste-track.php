<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tries
    |--------------------------------------------------------------------------
    |
    | This value is the number of times the request will be retried
    | with a sleep time of 1 second between tries. This is needed
    | to pass the reCAPTCHA validation.
    |
    */

    'tries' => env('POSTE_TRACK_TRIES', 3),

    'timeout' => env('POSTE_TRACK_TIMEOUT', 30),

];
