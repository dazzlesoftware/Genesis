<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Admin;

use Gantry\Component\Filesystem\Folder;
use Gantry\Component\Theme\ThemeDetails;
use Gantry\Framework\Gantry;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;

/**
 * Class ThemeList
 * @package Gantry\Admin
 */
class ThemeList
{
    protected static $items;

    /**
     * @return array
     */
    public static function getThemes()
    {
        if (!is_array(static::$items)) {
            static::loadThemes();
        }

        return static::$items;
    }

    /**
     * @param string $name
     * @return ThemeDetails|null
     */
    public static function getTheme($name)
    {
        if (!is_array(static::$items)) {
            static::loadThemes();
        }

        return isset(static::$items[$name]) ? static::$items[$name] : null;
    }

    protected static function loadThemes()
    {
        $gantry = Gantry::instance();

        /** @var UniformResourceLocator $locator */
        $locator = $gantry['locator'];

        /** @var array|ThemeDetails[] $list */
        $list = [];

        $files = Folder::all('gantry-themes://', ['recursive' => false, 'files' => false]);
        natsort($files);

        foreach ($files as $theme) {
            try {
                if ($locator('gantry-themes://' . $theme . '/gantry/theme.yaml')) {
                    $details = new ThemeDetails($theme);
                    $details->addStreams();

                    $details['name'] = $theme;
                    $details['title'] = $details['details.name'];
                    $details['preview_url'] = $gantry['platform']->getThemePreviewUrl($theme);
                    $details['admin_url'] = $gantry['platform']->getThemeAdminUrl($theme);
                    $details['params'] = [];

                    $list[$details->name] = $details;
                }
            } catch (\Exception $e) {
                // Do not add broken themes into the list.
                continue;
            }
        }

        // Add Thumbnails links after adding all the paths to the locator.
        foreach ($list as $details) {
            $details['thumbnail'] = $details->getUrl("details.images.thumbnail");
        }

        static::$items = $list;
    }
}
