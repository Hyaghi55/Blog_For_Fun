<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc38333cf77502f154c7addabb7f753e1
{
    public static $files = array (
        'ac6a9caec7ab8118fed95b74709e2464' => __DIR__ . '/../..' . '/Helpers/Redirect.php',
        '716fab8fb4c27667e0018367f96c6823' => __DIR__ . '/../..' . '/Helpers/View.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Services\\' => 9,
        ),
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'H' => 
        array (
            'Helpers\\' => 8,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Services',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Models',
        ),
        'Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Helpers',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc38333cf77502f154c7addabb7f753e1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc38333cf77502f154c7addabb7f753e1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc38333cf77502f154c7addabb7f753e1::$classMap;

        }, null, ClassLoader::class);
    }
}
