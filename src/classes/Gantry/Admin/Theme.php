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

use Gantry\Admin\Events\InitThemeEvent;
use Gantry\Component\Config\CompiledConfig;
use Gantry\Component\Config\ConfigFileFinder;
use Gantry\Component\Filesystem\Folder;
use Gantry\Component\Theme\AbstractTheme;
use Gantry\Framework\Platform;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

/**
 * Class Theme
 * @package Gantry\Admin
 */
class Theme extends AbstractTheme
{
    /**
     * @see AbstractTheme::init()
     */
    protected function init()
    {
        $gantry = static::gantry();

        // Add particles, styles and defaults into DI.

        $gantry['particles'] = function ($c) {
            return new Particles($c);
        };

        $gantry['styles'] = function ($c) {
            return new Styles($c);
        };

        $gantry['page'] = function ($c) {
            return new Page($c);
        };

        $gantry['defaults'] = function($c) {
            /** @var UniformResourceLocator $locator */
            $locator = $c['locator'];

            $cache = $locator->findResource('gantry-cache://theme/compiled/config', true, true);
            $paths = $locator->findResources('gantry-config://default');

            $files = (new ConfigFileFinder)->locateFiles($paths);

            $config = new CompiledConfig($cache, $files, GANTRY5_ROOT);
            $config->setBlueprints(function() use ($c) {
                return $c['blueprints'];
            });

            return $config->load(true);
        };

        // Initialize admin streams.

        /** @var Platform $patform */
        $patform = $gantry['platform'];

        /** @var UniformResourceLocator $locator */
        $locator = $gantry['locator'];

        $nucleus = $patform->getEnginePaths('nucleus')[''];
        if (strpos($this->path, '://')) {
            $relpath = $this->path;
        } else {
            $relpath = Folder::getRelativePath($this->path);
        }
        $patform->set(
            'streams.gantry-admin.prefixes', [
                ''        => ['gantry-theme://admin', $relpath, $relpath . '/common', 'gantry-engine://admin'],
                'assets/' => array_merge([$relpath, $relpath . '/common'], $nucleus, ['gantry-assets://'])
            ]
        );

        // Add admin paths.
        foreach ($patform->get('streams.gantry-admin.prefixes') as $prefix => $paths) {
            $locator->addPath('gantry-admin', $prefix, $paths);
        }

        // Fire admin init event.
        $event = new InitThemeEvent();
        $event->gantry = $gantry;
        $event->theme = $this;

        $gantry->fireEvent('admin.init.theme', $event);
    }

    /**
     * @see AbstractTheme::getCachePath()
     *
     * @param string $path
     * @return string
     */
    protected function getCachePath($path = '')
    {
        $gantry = static::gantry();

        /** @var Platform $patform */
        $patform = $gantry['platform'];

        // Initialize theme cache stream.
        return $patform->getCachePath() . '/admin' . ($path ? '/' . $path : '');
    }

    /**
     * @see AbstractTheme::setTwigLoaderPaths()
     *
     * @param LoaderInterface $loader
     */
    protected function setTwigLoaderPaths(LoaderInterface $loader)
    {
        if (!($loader instanceof FilesystemLoader)) {
            return null;
        }

        $gantry = static::gantry();

        /** @var UniformResourceLocator $locator */
        $locator = $gantry['locator'];

        $loader->setPaths($locator->findResources('gantry-admin://templates'));
        $loader->setPaths($locator->findResources('gantry-admin://templates'), 'gantry-admin');

        return $loader;
    }
}
