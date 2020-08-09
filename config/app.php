<?php

return [
    'debug' => (bool) env('APP_DEBUG', false),
    'fallback_locale' => 'en',
    'aliases' => [
        'Route' => Illuminate\Support\Facades\Route::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
    ]
];
