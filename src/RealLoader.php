<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry5;

use Composer\Autoload\ClassLoader;

/**
 * Use \Gantry5\Loader::setup() or \Gantry5\Loader::get() instead.
 *
 * This class separates Loader logic from the \Gantry5\Loader class. By adding this extra class we are able to upgrade
 * Gantry5 and initializing the new version during a single request -- as long as Gantry5 has not been initialized.
 *
 * @internal
 */
abstract class RealLoader
{
    /** @var string */
    protected static $errorMessagePhpMin = 'You are running PHP %s, but Gantry 5 Framework needs at least PHP %s to run.';
    /** @var string */
    protected static $errorMessageGantryLoaded = 'Attempting to load Gantry 5 Framework multiple times.';

    /**
     * Initializes Gantry5 and returns Composer ClassLoader.
     *
     * @return \Composer\Autoload\ClassLoader
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public static function getClassLoader()
    {
        // Fail safe version check for PHP <5.6.20.
        if (version_compare($phpVersion = PHP_VERSION, '5.6.20', '<')) {
            throw new \RuntimeException(sprintf(self::$errorMessagePhpMin, $phpVersion, '5.6.20'));
        }

        if (defined('GANTRY5_VERSION')) {
            throw new \LogicException(self::$errorMessageGantryLoaded);
        }

        define('GANTRY5_VERSION', '@version@');
        define('GANTRY5_VERSION_DATE', '@versiondate@');

        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }

        define('GANTRY_DEBUGGER', class_exists('Gantry\\Debugger'));

        return self::autoload();
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     * @throws \LogicException
     * @internal
     */
    protected static function autoload()
    {
        // Register platform specific overrides.
        if (defined('JVERSION') && defined('JPATH_ROOT')) {
            define('GANTRY5_PLATFORM', 'joomla');
            define('GANTRY5_ROOT', JPATH_ROOT);
            define('GANTRY5_LIBRARY', JPATH_ROOT . '/libraries/gantry5');
        } elseif (defined('WP_DEBUG') && defined('ABSPATH') && defined('WP_CONTENT_DIR')) {
            define('GANTRY5_PLATFORM', 'wordpress');
            if (defined('CONTENT_DIR') && class_exists('Env')) {
                // Bedrock support.
                define('GANTRY5_ROOT', preg_replace('|' . preg_quote(CONTENT_DIR, '|'). '$|', '', WP_CONTENT_DIR));
            } else {
                // Plain WP support.
                define('GANTRY5_ROOT', dirname(WP_CONTENT_DIR));
            }
            define('GANTRY5_LIBRARY', WP_CONTENT_DIR . '/plugins/gantry5');
        } else {
            throw new \RuntimeException('Gantry: CMS not detected!');
        }

        $lib = GANTRY5_LIBRARY;
        $autoload = "{$lib}/vendor/autoload.php";

        // Initialize auto-loading.
        if (!file_exists($autoload)) {
            throw new \LogicException('Please run composer in Gantry 5 Library!');
        }

        // In PHP >=7.2.5 we need to use newer version of ctype library.
        $useNewLibraries = \PHP_VERSION_ID >= 70205 && GANTRY5_PLATFORM !== 'grav';
        if ($useNewLibraries) {
            /** @var ClassLoader $loader */
            $loader = require "{$lib}/compat/vendor/autoload.php";
            $loader->unregister();
        }

        /** @var ClassLoader $loader */
        $loader = require $autoload;

        // In PHP >=7.2.5 we need to use newer version of Pimple and Twig.
        if ($useNewLibraries) {
            $loader->setPsr4('Twig\\', "{$lib}/compat/vendor/twig/twig/src");
            $loader->set('Twig_', "{$lib}/compat/vendor/twig/twig/lib");
            $loader->set('Pimple', "{$lib}/compat/vendor/pimple/pimple/src");
        }

        // Skip registering SCSS compiler until it's needed.
        $loader->setPsr4('ScssPhp\\ScssPhp\\', '');
        $loader->setPsr4('Leafo\\ScssPhp\\', '');

        // Support for development environments.
        if (file_exists($lib . '/src/platforms')) {
            $loader->addPsr4('Gantry\\', "{$lib}/src/platforms/" . GANTRY5_PLATFORM . '/classes/Gantry', true);
        }

        return $loader;
    }
}
