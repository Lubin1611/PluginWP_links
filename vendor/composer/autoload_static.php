<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdeae385e8018a07ad74c657955d1e724
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Youshido\\GraphQL\\' => 17,
        ),
        'T' => 
        array (
            'Twig\\' => 5,
            'Tests\\Datatourisme\\Api\\' => 23,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Yaml\\' => 23,
        ),
        'D' => 
        array (
            'Datatourisme\\Api\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Youshido\\GraphQL\\' => 
        array (
            0 => __DIR__ . '/..' . '/youshido/graphql/src',
        ),
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Tests\\Datatourisme\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/datatourisme/api/tests',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Datatourisme\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/datatourisme/api/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'E' => 
        array (
            'EasyRdf_' => 
            array (
                0 => __DIR__ . '/..' . '/easyrdf/easyrdf/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdeae385e8018a07ad74c657955d1e724::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdeae385e8018a07ad74c657955d1e724::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitdeae385e8018a07ad74c657955d1e724::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
