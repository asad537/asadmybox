<?php 
return [ 
    'client_id' => env('PAYPAL_CLIENT_ID','AcxbxwVtzO-jrLr8QppTCVFccbjQ4aN2Se34MgJ1tZGZJXP6xE2KvDmh8c0RPnJ-09NrZbMG3rtxUCrd'),
    'secret' => env('PAYPAL_SECRET','EM5iFJ3xCwCOjwquHYNSVuWId4VhC4yQ1s4Ms36XlrfejXJnnUJB9dH7RYDXNQ6vSo0Y4NzhcqDt9GJq'),
    'settings' => array(
        'mode' => env('PAYPAL_MODE','live'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];