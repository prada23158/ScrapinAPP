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
        'railway_host' => env('RAILWAY_HOST', 'https://primary-production-cd85.up.railway.app'),
        // France Travail Workflows IDs
        'workflow_One_ID_FT' => env('WORKFLOW_ONE_ID_FRANCETRAVAIL'),
        'workflow_Two_ID_FT' => env('WORKFLOW_TWO_ID_FRANCETRAVAIL'),
        'workflow_Three_ID_FT' => env('WORKFLOW_THREE_ID_FRANCETRAVAIL'),
        'workflow_Four_ID_FT' => env('WORKFLOW_FOUR_ID_FRANCETRAVAIL'),
        'workflow_Tel_ID_FT' => env('WORKFLOW_TEL_ID_FRANCETRAVAIL'),
        // Indeed Workflows IDs
        'workflow_One_ID_INDEED' => env('WORKFLOW_ONE_ID_INDEED'),
        'workflow_Two_ID_INDEED' => env('WORKFLOW_TWO_ID_INDEED'),
        'workflow_Three_ID_INDEED' => env('WORKFLOW_THREE_ID_INDEED'),
        'workflow_Tel_ID_INDEED' => env('WORKFLOW_TEL_ID_INDEED'),
    ],

    'n8n-prod' => [
        // France Travail Workflows PROD
        'stepone_francetravail_prod' => env('N8N_StepOne_FRANCETRAVAIL_PROD'),
        'steptwo_francetravail_prod' => env('N8N_StepTwo_FRANCETRAVAIL_PROD'),
        'stepthree_francetravail_prod' => env('N8N_StepThree_FRANCETRAVAIL_PROD'),
        'stepfour_francetravail_prod' => env('N8N_StepFour_FRANCETRAVAIL_PROD'),
        'steptel_francetravail_prod' => env('N8N_StepTel_FRANCETRAVAIL_PROD'),
        // Indeed Workflows PROD
        'stepone_indeed_prod' => env('N8N_StepOne_INDEED_PROD'),
        'steptwo_indeed_prod' => env('N8N_StepTwo_INDEED_PROD'),
        'stepthree_indeed_prod' => env('N8N_StepThree_INDEED_PROD'),
        'steptel_indeed_prod' => env('N8N_StepTel_INDEED_PROD'),
    ],

    'n8n-test' => [
        // France Travail Workflows TEST
        'stepone_francetravail_test' => env('N8N_StepOne_FRANCETRAVAIL_TEST'),
        'steptwo_francetravail_test' => env('N8N_StepTwo_FRANCETRAVAIL_TEST'),
        'stepthree_francetravail_test' => env('N8N_StepThree_FRANCETRAVAIL_TEST'),
        'stepfour_francetravail_test' => env('N8N_StepFour_FRANCETRAVAIL_TEST'),
        'steptel_francetravail_test' => env('N8N_StepTel_FRANCETRAVAIL_TEST'),
        // Indeed Workflows TEST
        'stepone_indeed_test' => env('N8N_StepOne_INDEED_TEST'),
        'steptwo_indeed_test' => env('N8N_StepTwo_INDEED_TEST'),
        'stepthree_indeed_test' => env('N8N_StepThree_INDEED_TEST'),
        'steptel_indeed_test' => env('N8N_StepTel_INDEED_TEST'),
    ],

    'RAILWAY_HOST' => [
        'railway_host' => env('RAILWAY_HOST'),
    ],

    'apiKeys' => [
        'api_key' => env('API_KEY'),
    ],


];
