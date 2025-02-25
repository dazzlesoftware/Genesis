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
use Gantry\Framework\Platform;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;

/**
 * @package Gantry\Admin
 */
class ThemeList
{
    /** @var ThemeDetails[] */
    protected static $items;

    /** @var array */
    protected static $styles;

    /**
     * @return array
     */
    public static function getThemes()
    {
        if (!\is_array(static::$items)) {
            static::loadThemes();
        }

        $list = [];
        foreach (static::$items as $item) {
            $details = static::getTheme($item['name']);
            if ($details) {
                $list[$item['name']] = $details;
            }
        }

        return $list;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function getTheme($name)
    {
        $styles = static::getStyles($name);

        return reset($styles);
    }

    /**
     * @param string $template
     * @return array
     */
    public static function getStyles($template = null, $force = false)
    {
        if ($force || !\is_array(static::$styles)) {
            static::loadStyles();
        }

        if ($template) {
            return isset(static::$styles[$template]) ? static::$styles[$template] : [];
        }

        $list = [];
        foreach (static::$styles as $styles) {
            $list += $styles;
        }

        ksort($list);

        return $list;
    }

    /**
     *
     */
    protected static function loadThemes()
    {
        $gantry = Gantry::instance();

        /** @var Platform $platform */
        $platform = $gantry['platform'];

        /** @var UniformResourceLocator $locator */
        $locator = $gantry['locator'];

        /** @var ThemeDetails[] $list */
        $list = [];

        $files = Folder::all('gantry-themes://', ['recursive' => false, 'files' => false]);
        natsort($files);

        foreach ($files as $theme) {
            if ($locator('gantry-themes://' . $theme . '/gantry/theme.yaml')) {
                $details = new ThemeDetails($theme);
                $details->addStreams();

                $details['name'] = $theme;
                $details['title'] = $details['details.name'];
                $details['preview_url'] = null;
                $details['admin_url'] = $platform->getThemeAdminUrl($theme);
                $details['params'] = [];

                $list[$details->name] = $details;

            }
        }

        // Add Thumbnails links after adding all the paths to the locator.
        foreach ($list as $details) {
            $details['thumbnail'] = $details->getUrl('details.images.thumbnail');
        }

        static::$items = $list;
    }

    /**
     *
     */
    protected static function loadStyles()
    {
        $gantry = Gantry::instance();

        /** @var Platform $platform */
        $platform = $gantry['platform'];

        $db = Factory::getDbo();

        $query = $db
            ->getQuery(true)
            ->select('s.id, e.extension_id, s.template AS name, s.title, s.params')
            ->from('#__template_styles AS s')
            ->where('s.client_id = 0')
            ->where('e.enabled = 1')
            ->where('e.state = 0')
            ->leftJoin('#__extensions AS e ON e.element=s.template AND e.type='
                . $db->quote('template') . ' AND e.client_id=s.client_id')
            ->order('s.id');

        $db->setQuery($query);

        $styles = (array) $db->loadObjectList();

        if (!\is_array(static::$items)) {
            static::loadThemes();
        }

        /** @var ThemeDetails[] $list */
        $list = [];

        foreach ($styles as $style)
        {
            $details = isset(static::$items[$style->name]) ? static::$items[$style->name] : null;
            if (!$details) {
                continue;
            }

            $params = new Registry($style->params);

            $details = clone $details;
            $details['id'] = $style->id;
            $details['extension_id'] = $style->extension_id;
            $details['style'] = $style->title;
            $details['preview_url'] = $platform->getThemePreviewUrl($style->id);
            $details['params'] = $params->toArray();

            $list[$style->name][$style->id] = $details;
        }

        static::$styles = $list;
    }
}
