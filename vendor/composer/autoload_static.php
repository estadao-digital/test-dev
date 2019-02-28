<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6bf76553fdd809dcbe679cec0b2c8693
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Frame\\' => 6,
        ),
        'A' => 
        array (
            'Api\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Frame\\' => 
        array (
            0 => __DIR__ . '/..' . '/Frame',
        ),
        'Api\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Api',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6bf76553fdd809dcbe679cec0b2c8693::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6bf76553fdd809dcbe679cec0b2c8693::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
