<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9269bde5e3710937f8e2264d28405a7c
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'sf\\' => 3,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'P' => 
        array (
            'Predis\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'sf\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9269bde5e3710937f8e2264d28405a7c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9269bde5e3710937f8e2264d28405a7c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
