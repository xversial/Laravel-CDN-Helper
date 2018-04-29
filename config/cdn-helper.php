<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Toggle CDN Usage
    |--------------------------------------------------------------------------
    |
    | The cdn helper is disabled by default
    |
    */

    'enable' => env('CDN_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | CDN Domain
    |--------------------------------------------------------------------------
    |
    | The domain of the CDN.
    | For example cdn.example.com
    |
    */

    'domain' => env('CDN_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Use Same Scheme
    |--------------------------------------------------------------------------
    |
    | Set to true to use '//' in-front of all full URI's
    | For example, a value of true would write //cdn.example.com/js/app.js
    |
    */

    'scheme_crossover' => env('CDN_SCHEME_CROSSOVER', true),

    /*
    |--------------------------------------------------------------------------
    | Enforce SSL
    |--------------------------------------------------------------------------
    |
    | Setting true will enforce all URIs to only write https for the scheme.
    |
    */

    'enforce_ssl' => env('CDN_FORCE_SSL', false),
);
