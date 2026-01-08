<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports “GD Library” and “Imagick” to process images
    | internally. Depending on your PHP setup, you can choose one of them.
    |
    | Included options:
    |   - \Intervention\Image\Drivers\Gd\Driver::class
    |   - \Intervention\Image\Drivers\Imagick\Driver::class
    |
    */

    'driver' => \Intervention\Image\Drivers\Gd\Driver::class,

    /*
    |--------------------------------------------------------------------------
    | Configuration Options
    |--------------------------------------------------------------------------
    |
    | These options control the behavior of Intervention Image.
    |
    | - "autoOrientation" controls whether an imported image should be
    |    automatically rotated according to any existing Exif data.
    |
    | - "decodeAnimation" decides whether a possibly animated image is
    |    decoded as such or whether the animation is discarded.
    |
    | - "blendingColor" Defines the default blending color.
    |
    | - "strip" controls if meta data like exif tags should be removed when
    |    encoding images.
    */

    'options' => [
        'autoOrientation' => true,
        'decodeAnimation' => true,
        'blendingColor' => 'ffffff',
        'strip' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Animals Image Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for animal image uploads and variants
    |
    */

    'animals' => [
        'disk' => 'animals',
        'original' => [
            'path' => 'originals',
            'format' => 'webp',
            'quality' => 90,
        ],
        'variants' => [
            'thumbnail' => [
                'path' => 'thumbnails',
                'width' => 150,
                'height' => 150,
                'format' => 'webp',
                'quality' => 85,
            ],
            'medium' => [
                'path' => 'medium',
                'width' => 500,
                'height' => 500,
                'format' => 'webp',
                'quality' => 85,
            ],
        ],
    ],
];
