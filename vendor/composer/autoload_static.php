<?php

namespace Composer\Autoload;

class ComposerStaticInitd6cd53dd99ec0072bd5d3254ffcfae8a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd6cd53dd99ec0072bd5d3254ffcfae8a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd6cd53dd99ec0072bd5d3254ffcfae8a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
