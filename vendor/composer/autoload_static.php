<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit674ec55ddcbdba5b09a22d13b4494e9d
{
    public static $files = array (
        'ca58cc5683d74f567862141323acc8b0' => __DIR__ . '/../..' . '/Includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPTE_PM_MANAGER\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPTE_PM_MANAGER\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit674ec55ddcbdba5b09a22d13b4494e9d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit674ec55ddcbdba5b09a22d13b4494e9d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit674ec55ddcbdba5b09a22d13b4494e9d::$classMap;

        }, null, ClassLoader::class);
    }
}
