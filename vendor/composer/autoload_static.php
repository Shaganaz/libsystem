<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit20ec6c6561004e8bb929724bc90610ad
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Src\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit20ec6c6561004e8bb929724bc90610ad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit20ec6c6561004e8bb929724bc90610ad::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit20ec6c6561004e8bb929724bc90610ad::$classMap;

        }, null, ClassLoader::class);
    }
}
