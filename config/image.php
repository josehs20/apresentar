<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports multiple image drivers. By default, the
    | GD driver is used, which is bundled with PHP. If you prefer to use
    | the Imagick driver, you may set the value below to "imagick".
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => env('IMAGE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | Default Configuration Options
    |--------------------------------------------------------------------------
    |
    | These options are passed to the ImageManager's Config object and are
    | used as defaults for image processing. You can override these at
    | runtime by passing options to the manager's boot() method.
    |
    */

    'options' => [
        'autoOrientation' => true,
        'decodeAnimation' => true,
        'blendingColor'   => 'ffffff',
        'strip'           => false,
    ],

];
