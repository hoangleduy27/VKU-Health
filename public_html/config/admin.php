<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default admin user
    |--------------------------------------------------------------------------
    |
    | Default user will be created at project installation/deployment
    |
    */

    'admin_username' => env('ADMIN_USERNAME', ''),
    'admin_rfid' => env('ADMIN_RFID', ''),
    'admin_fullname' => env('ADMIN_FULLNAME', ''),
    'admin_phone' => env('ADMIN_PHONE', ''),
    'admin_password' =>env('ADMIN_PASSWORD', ''),
    'admin_gender' =>env('ADMIN_GENDER', ''),
    'admin_address' =>env('ADMIN_ADDRESS', ''),
    'admin_role' =>env('ADMIN_ROLE', ''),
    'admin_id_number' =>env('ADMIN_ID_NUMBER', ''),
    'admin_mi' =>env('ADMIN_MI', ''),
    'admin_email' => env('ADMIN_EMAIL', '')
    ];