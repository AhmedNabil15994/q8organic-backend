<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    "sms" => [
        "default" => env("SMS_DEFAULT", "sms_box"),
        "sms_box" => [
            "username" => env("SMS_BOX_USERNAME", "conckw"),
            "password" => env("SMS_BOX_PASSWORD", "56551040"),
            "customerId" => env("SMS_BOX_CUSTOMER_ID", "2924"),
            "senderText" => env("SMS_BOX_SENDER_TEXT", "SMSBOX.COM"),
            "defdate" => env("SMS_BOX_DEF_DATE", ""),
            "isBlink" => env("SMS_BOX_IS_BLINK", "false"),
            "isFlash" => env("SMS_BOX_IS_FLASH", "false"),
        ]
    ],

];
