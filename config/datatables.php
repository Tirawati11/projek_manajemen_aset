<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DataTables Options
    |--------------------------------------------------------------------------
    |
    | These options define the global behavior of the DataTables library and
    | the behaviour of each table using the library.
    |
    */

    'options' => [
        'processing' => true,
        'serverSide' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | DataTables Templates
    |--------------------------------------------------------------------------
    |
    | Templates allow you to fully configure DataTables and re-use those settings
    | across all tables in your application.
    |
    */

    'templates' => [
        'global_template' => [
            'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
            'order' => [0, 'asc'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | DataTables Asset Pipeline
    |--------------------------------------------------------------------------
    |
    | DataTables library asset pipeline configuration. These configuration options
    | determine what JavaScript and CSS files are included in your application
    | when using DataTables.
    |
    */

    'assets' => [
        'jquery' => [
            'cdn' => true,
            'url' => '//code.jquery.com/jquery-3.5.1.min.js',
        ],
        'dataTables' => [
            'cdn' => true,
            'url' => '//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js',
        ],
        'dataTablesCss' => [
            'cdn' => true,
            'url' => '//cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css',
        ],
    ],

];
