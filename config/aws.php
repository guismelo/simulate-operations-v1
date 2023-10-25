<?php

return [

    /*
    |--------------------------------------------------------------------------
    | S3 - SQS
    |--------------------------------------------------------------------------
    |
    | Configurações de SQS da AWS
    |
    */

    /*
     * Dados de conexão do S3 - Buckets
     */
    's3' => [
        'account_default' => env('AWS_DEFAULT_ACCOUNT'),
        'region_default' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'use_accelerate_endpoint' => env('AWS_S3_ACCELERATE', false)
    ],

    /*
     * Dados de configuração do SQS de solicitação de download
     */
    'sqs_select_dispatch' => [
        'account_default' => env('AWS_DEFAULT_ACCOUNT'),
        'region_default' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'queue' => env('AWS_SQS_SELECT_DISPATCH'),
        'prefix' => "https://sqs.".env('AWS_DEFAULT_REGION', 'us-east-1').".amazonaws.com/"
            .env('AWS_DEFAULT_ACCOUNT')."/"
    ],

    /*
     * Dados de configuração do SQS de solicitação de download depois de todas as fotos prontas
     */
    'sqs_select_zip_create' => [
        'account_default' => env('AWS_DEFAULT_ACCOUNT'),
        'region_default' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'queue' => env('AWS_SQS_SELECT_SQS_ZIP'),
        'prefix' => "https://sqs.".env('AWS_DEFAULT_REGION', 'us-east-1').".amazonaws.com/"
            .env('AWS_DEFAULT_ACCOUNT')."/"
    ],

    /*
     * Dados de configuração do SQS de solicitação de download depois de todas as fotos prontas
     */
    'sqs_select_photo_process' => [
        'account_default' => env('AWS_DEFAULT_ACCOUNT'),
        'region_default' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'queue' => env('AWS_SQS_SELECT_PHOTO_PROCESS'),
        'prefix' => "https://sqs.".env('AWS_DEFAULT_REGION', 'us-east-1').".amazonaws.com/"
            .env('AWS_DEFAULT_ACCOUNT')."/"
    ]
    
];
