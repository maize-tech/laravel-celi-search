<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the full base url used to perform update and destroy
    | requests to the Celi Search backoffice.
    |
    */

    'base_url' => env('CELI_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Search base url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the full base url used to perform search queries.
    |
    */

    'search_base_url' => env('CELI_SEARCH_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Project name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the name of the project defined in Celi Search.
    |
    */

    'project' => env('CELI_PROJECT'),

    /*
    |--------------------------------------------------------------------------
    | Searchable models
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of fully qualified class names of
    | searchable models.
    |
    */

    'searchables' => [
        // \App\Models\User::class,
    ],

];
