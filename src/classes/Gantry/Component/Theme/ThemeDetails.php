<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Theme;

use Gantry\Component\File\CompiledYamlFile;
use Gantry\Component\Filesystem\Streams;
use Gantry\Framework\Gantry;
use DazzleSoftware\Toolbox\ArrayTraits\Export;
use DazzleSoftware\Toolbox\ArrayTraits\NestedArrayAccessWithGetters;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;

/**
 * Class ThemeDetails
 * @package Gantry\Component\Theme
 *
 * @property string $name
 */
class ThemeDetails implements \ArrayAccess
{
    use NestedArrayAccessWithGetters, Export;

    protected $items;
    protected $parent;

    /**
     * Create new theme details.
     *
     * @param string $theme
     */
    public function __construct($theme)
    {
        $gantry = Gantry::instance();

        /** @var UniformResourceLocator $locator */
        $locator = $gantry['locator'];

        $filename = $locator->findResource("gantry-themes://{$theme}/custom/gantry/theme.yaml") ?: $locator->findResource("gantry-themes://{$theme}/gantry/theme.yaml");
        if (!$filename) {
            throw new \RuntimeException(sprintf('Theme %s not found', $theme), 404);
        }

        /** @var string $cache */
        $cache = $locator->findResource("gantry-cache://{$theme}/compiled/yaml", true, true);

        $file = CompiledYamlFile::instance($filename);
        $this->items = (array)$file->setCachePath($cache)->content();
        $file->free();

        $this->offsetSet('name', $theme);

        $parent = (string) $this->get('configuration.theme.parent', $theme);
        $parent = $parent !== $theme ? $parent : null;

        $this->offsetSet('parent', $parent);
    }

    /**
     * @return string
     */
    public function addStreams()
    {
        $gantry = Gantry::instance();

        // Initialize theme stream.
        $streamName = $this->addStream($this->offsetGet('name'), $this->getPaths());

        // Initialize parent theme streams.
        $loaded = [$this->offsetGet('name')];
        $details = $this;

        while (($details = $details->parent())) {
            if (in_array($details->name, $loaded, true)) {
                break;
            }
            $this->addStream($details->name, $details->getPaths(false));
            $loaded[] = $details->name;
        }

        /** @var Streams $streams */
        $streams = $gantry['streams'];
        $streams->register();

        return $streamName;
    }

    /**
     * Get parent theme details if theme has a parent.
     *
     * @return ThemeDetails|null
     * @throws \RuntimeException
     */
    public function parent()
    {
        $parent = $this->offsetGet('parent');

        if (!$this->parent && $parent) {
            try {
                $this->parent = new ThemeDetails($parent);
            } catch (\RuntimeException $e) {
                throw new \RuntimeException(sprintf('Parent theme %s not found', $parent), 404);
            }
        }

        return $this->parent;
    }

    /**
     * Get all possible paths to the theme.
     *
     * @return array
     */
    public function getPaths($overrides = true)
    {
        $paths = array_merge(
            $overrides ? (array) $this->get('configuration.theme.overrides', 'gantry-theme://custom') : [],
            ['gantry-theme://'],
            (array) $this->get('configuration.theme.base', 'gantry-theme://common')
        );

        $parent = $this->offsetGet('parent');
        if ($parent) {
            // Stream needs to be valid URL.
            $streamName = 'gantry-themes-' . preg_replace('|[^a-z\d+.-]|ui', '-', $parent);
            $paths[] = "{$streamName}://";
        }

        return $this->parsePaths($paths);
    }

    /**
     * Convert theme path into stream URI.
     *
     * @param string $path
     * @return string
     */
    public function getUrl($path)
    {
        $uri = (string) $this->offsetGet($path);

        if (strpos($uri, 'gantry-theme://') === 0) {
            list (, $uri) = explode('://', $uri, 2);
        }
        if (!strpos($uri, '://')) {
            $name = $this->offsetGet('name');

            // Stream needs to be valid URL.
            $streamName = 'gantry-themes-' . preg_replace('|[^a-z\d+.-]|ui', '-', $name);
            $uri = "{$streamName}://{$uri}";
        }

        return $uri;
    }

    /**
     * Turn list of theme paths to be universal, so they can be used outside of the theme.
     *
     * @param array $items
     * @return array
     */
    public function parsePaths(array $items)
    {
        foreach ($items as &$item) {
            $item = $this->parsePath($item);
        }

        return $items;
    }

    /**
     * Convert theme paths to be universal, so they can be used outside of the theme.
     *
     * @param string $path
     * @return string
     */
    public function parsePath($path)
    {
        if (strpos($path, 'gantry-theme://') === 0) {
            list (, $path) = explode('://', $path, 2);
        }
        if (!strpos($path, '://')) {
            $name = $this->offsetGet('name');
            $path = "gantry-themes://{$name}/{$path}";
        }

        return $path;
    }

    /**
     * @return string|null
     * @deprecated 5.1.5
     */
    public function getParent()
    {
        return $this->offsetGet('parent');
    }

    /**
     * @param string $name
     * @param array $paths
     * @return string|null
     */
    protected function addStream($name, $paths)
    {
        $gantry = Gantry::instance();

        /** @var UniformResourceLocator $locator */
        $locator = $gantry['locator'];

        /** @var Streams $streams */
        $streams = $gantry['streams'];

        // Add theme stream.
        $streamName = 'gantry-themes-' . preg_replace('|[^a-z\d+.-]|ui', '-', $name);
        if (!$locator->schemeExists($streamName)) {
            $streams->add([$streamName => ['paths' => $paths]]);
        }

        return $streamName;
    }
}
