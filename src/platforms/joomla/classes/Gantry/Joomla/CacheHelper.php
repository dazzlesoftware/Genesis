<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Joomla;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Cache\Exception\CacheExceptionInterface;
use Joomla\CMS\Factory;

/**
 * Class CacheHelper
 * @package Gantry\Joomla
 */
class CacheHelper
{
    public static function cleanTemplates()
    {
        static::cleanSystem();
        self::cleanByType('com_templates', 0);
        self::cleanByType('com_templates', 1);
    }

    public static function cleanModules()
    {
        static::cleanSystem();
        self::cleanByType('com_modules', 0);
    }

    public static function cleanMenu()
    {
        static::cleanSystem();
        self::cleanByType('mod_menu', 0);
        self::cleanByType('com_menus', 0);
        self::cleanByType('com_menus', 1);
    }

    public static function cleanPlugin()
    {
        static::cleanSystem();
        self::cleanByType('com_plugins', 0);
        self::cleanByType('com_plugins', 1);
    }

    public static function cleanSystem()
    {
        self::cleanByType('_system', 0);
        self::cleanByType('_system', 1);
    }

    /**
     * @param string|null $group
     * @param int $client_id
     * @param string $event
     */
    private static function cleanByType($group = null, $client_id = 0, $event = 'onContentCleanCache')
    {
        $config = Factory::getConfig();

        $options = [
            'defaultgroup' => $group,
            'cachebase' => $client_id ? JPATH_ADMINISTRATOR . '/cache' : $config->get('cache_path', JPATH_SITE . '/cache'),
            'result' => true
        ];

        try {
            /** @var Cache $cache */
            $cache = Cache::getInstance('callback', $options);
            $cache->clean();
        } catch (CacheExceptionInterface $e) {
            $options['result'] = false;
        }

        /** @var CMSApplication $application */
        $application = Factory::getApplication();

        // Trigger the onContentCleanCache event.
        $application->triggerEvent($event, $options);
    }
}
