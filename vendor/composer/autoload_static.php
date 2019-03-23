<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit65839adecf91b2b787da90f0e8eff16d
{
    public static $files = array (
        'e40631d46120a9c38ea139981f8dab26' => __DIR__ . '/..' . '/ircmaxell/password-compat/lib/password.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slim\\Middleware\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slim\\Middleware\\' => 
        array (
            0 => __DIR__ . '/..' . '/tuupola/slim-basic-auth/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit65839adecf91b2b787da90f0e8eff16d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit65839adecf91b2b787da90f0e8eff16d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit65839adecf91b2b787da90f0e8eff16d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}