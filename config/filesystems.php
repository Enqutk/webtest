<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

        'heroes' => [
            'driver' => 'local',
            'root' => public_path('heros'),
            'url' => env('APP_URL').'/heros',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'services' => [
            'driver' => 'local',
            'root' => public_path('services'),
            'url' => env('APP_URL').'/services',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'teams' => [
            'driver' => 'local',
            'root' => public_path('teams'),
            'url' => env('APP_URL').'/teams',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'posts' => [
            'driver' => 'local',
            'root' => public_path('posts'),
            'url' => env('APP_URL').'/posts',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'entities' => [
            'driver' => 'local',
            'root' => public_path('entities'),
            'url' => env('APP_URL').'/entities',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
