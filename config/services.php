<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'n8n' => [
        'api_key' => env('API_KEY'),
        'workflow_One_ID_FT' => env('WORKFLOW_ONE_ID_FRANCETRAVAIL'),
        'railway_host' => env('RAILWAY_HOST', 'https://primary-production-cd85.up.railway.app'),
    ],

    'n8n-prod' => [
        'stepone_francetravail_prod' => env('N8N_StepOne_FRANCETRAVAIL_PROD'),
    ],

    'n8n-test' => [
        'stepone_francetravail_test' => env('N8N_StepOne_FRANCETRAVAIL_TEST'),
    ],

    'RAILWAY_HOST' => [
        'railway_host' => env('RAILWAY_HOST'),
    ],

    'apiKeys' => [
        'api_key' => env('API_KEY'),
    ],


];
