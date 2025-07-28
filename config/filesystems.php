<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | The default disk used by the application. You can change it to any
    | defined disk below, including cloud drivers like s3 or ftp.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Configure your storage "disks" here. You can add multiple disks with
    | the same or different drivers. Default supported: "local", "ftp",
    | "sftp", "s3", and more via third-party packages.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'visibility' => 'private',
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'private',
            'throw' => false,
            'report' => false,
        ],

        // Optional: Temporary or testing-specific disk
        'temp' => [
            'driver' => 'local',
            'root' => storage_path('app/temp'),
            'visibility' => 'private',
            'throw' => false,
            'report' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | These symbolic links will be created by the `storage:link` Artisan command.
    | You can map more folders here if needed for custom public access.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
