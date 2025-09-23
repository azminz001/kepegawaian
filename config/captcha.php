<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),
    'characters' => '0123456789ABCDEFG', // Hanya angka
    // 'default' => [
    //     'length' => 0, // Jangan tampilkan karakter
    //     'width' => 0,
    //     'height' => 0,
    // ],
    'default' => [
        'length' => 5, // Kurangi jumlah karakter menjadi 5
        'width' => 120, // Lebih kecil agar lebih mudah dibaca
        'height' => 36,
        'quality' => 90,
        'lines' => 3, // Kurangi garis acak agar lebih jelas
        'bgImage' => false,
        'bgColor' => '#ffffff',
        'fontColors' => ['#2c3e50', '#16a085', '#303f9f'], // Warna lebih kontras
        'contrast' => -5, // Kurangi efek kontras agar lebih jelas
        'cache' => true, // Aktifkan caching CAPTCHA
        // 'expire' => 300, // Berlaku selama 5 menit
    ],
    'sindikat' => [
        'length' => 5, // Kurangi jumlah karakter menjadi 5
        'width' => 120, // Lebih kecil agar lebih mudah dibaca
        'height' => 36,
        'quality' => 90,
        'lines' => 3, // Kurangi garis acak agar lebih jelas
        'bgImage' => false,
        'bgColor' => '#ffffff',
        'fontColors' => ['#2c3e50', '#16a085', '#303f9f'], // Warna lebih kontras
        'contrast' => -5, // Kurangi efek kontras agar lebih jelas
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],

    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
