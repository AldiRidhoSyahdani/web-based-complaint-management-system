<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Guard
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => 'web',        // Default untuk masyarakat (pakai /login, /register)
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        // Guard untuk MASYARAKAT (pakai tabel users)
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Guard untuk ADMIN (pakai tabel admins — terpisah!)
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        // Masyarakat biasa
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        // Admin / Petugas (tabel terpisah)
        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,  // Pastikan model Admin.php ADA!
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset Password Settings
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        // Kalau admin juga mau reset password, tambahkan ini:
        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];