<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5fd52cff0762dae437e24050bb5511e8
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5fd52cff0762dae437e24050bb5511e8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5fd52cff0762dae437e24050bb5511e8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5fd52cff0762dae437e24050bb5511e8::$classMap;

        }, null, ClassLoader::class);
    }
}
