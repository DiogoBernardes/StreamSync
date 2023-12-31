<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit89e8ab349ace1e3c8dd42f9404ef23dc
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit89e8ab349ace1e3c8dd42f9404ef23dc', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit89e8ab349ace1e3c8dd42f9404ef23dc', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit89e8ab349ace1e3c8dd42f9404ef23dc::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
