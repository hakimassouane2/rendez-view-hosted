<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit34ae4a5d30f4283576d82f307f461f6e
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

        spl_autoload_register(array('ComposerAutoloaderInit34ae4a5d30f4283576d82f307f461f6e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit34ae4a5d30f4283576d82f307f461f6e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit34ae4a5d30f4283576d82f307f461f6e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
