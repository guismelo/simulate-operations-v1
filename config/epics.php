<?php

return [

    /*
    |--------------------------------------------------------------------------
    | EPICS - ASSETS
    |--------------------------------------------------------------------------
    */

    'url_epics_css' => env('URL_EPICS_CSS', 'http://assets.epics/assets/build/epics.min.css'),
    'url_epics_js' => env('URL_EPICS_JS', 'http://assets.epics/assets/build/epics.min.js'),

    /*
    |--------------------------------------------------------------------------
    | Projetos - URL EPICS
    |--------------------------------------------------------------------------
    */

    'url_epics_dashboard' => env('URL_EPICS_DASHBOARD', 'http://site.epics/'),
    'url_epics_api' => env('URL_EPICS_API_V1', 'http://api.epics/'),
    'url_epics_select_client' => env('URL_EPICS_SELECT_CLIENT', 'https://select.client.epics/'),
    'url_epics_store' => env('URL_EPICS_STORE', 'https://store.epics/'),

    /*
    |--------------------------------------------------------------------------
    | Conexões - API Rest
    |--------------------------------------------------------------------------
    */

    'api_epics' => [
        'server' => env('URL_EPICS_API_V1', 'http://api.epics/'),
        'http_user' => 'EpicsUser',
        'http_pass' => 'AP13pic2--Aws0m3',
    ],

    'api_oportunidades' => [
        'server' => env('URL_API_OPORTUNIDADES', 'https://oportunidades.api.epics/'),
        'http_user' => env('OP_USER', 'OportunidadesUser'),
        'http_pass' => env('OP_PASS', '0p0rtunid@d3s-3pic2--Aws0m3'),
    ],


    /*
    |--------------------------------------------------------------------------
    | E-mail default sender
    |--------------------------------------------------------------------------
    */

    'default_epics_email_sender' => env('DONT_REPLY_EMAIL', 'nao-responda@epics.com.br'),

     /*
    |--------------------------------------------------------------------------
    | Default link to user's thumbnail
    |--------------------------------------------------------------------------
    */
    
    'default_epics_thumb_user' => env('DEFAULT_THUMB_USER', 'https://99afb09c95a375cdc2de-0a2a56423d3683c72f90a7b25309f12b.ssl.cf1.rackcdn.com/img/'),

];
