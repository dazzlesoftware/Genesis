<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Filesystem;

use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;
use DazzleSoftware\Toolbox\StreamWrapper\ReadOnlyStream;
use DazzleSoftware\Toolbox\StreamWrapper\Stream;

/**
 * Class Streams
 * @package Gantry\Component\Filesystem
 */
class Streams
{
    /** @var array */
    protected $schemes = [];

    /** @var array */
    protected $registered;

    /** @var UniformResourceLocator */
    protected $locator;

    /**
     * Streams constructor.
     * @param UniformResourceLocator|null $locator
     */
    public function __construct(UniformResourceLocator $locator = null)
    {
        if ($locator) {
            $this->setLocator($locator);
        }
    }

    /**
     * @param UniformResourceLocator $locator
     */
    public function setLocator(UniformResourceLocator $locator)
    {
        $this->locator = $locator;

        // Set locator to both streams.
        Stream::setLocator($locator);
        ReadOnlyStream::setLocator($locator);
    }

    /**
     * @return UniformResourceLocator
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * @param array $schemes
     */
    public function add(array $schemes)
    {
        foreach ($schemes as $scheme => $config) {
            $force = !empty($config['force']);

            if (isset($config['paths'])) {
                $this->locator->addPath($scheme, '', $config['paths'], false, $force);
            }
            if (isset($config['prefixes'])) {
                foreach ($config['prefixes'] as $prefix => $paths) {
                    $this->locator->addPath($scheme, $prefix, $paths, false, $force);
                }
            }
            $type = !empty($config['type']) ? $config['type'] : 'ReadOnlyStream';
            if ($type[0] !== '\\') {
                $type = '\\DazzleSoftware\\Toolbox\\StreamWrapper\\' . $type;
            }
            $this->schemes[$scheme] = $type;

            if (isset($this->registered)) {
                $this->doRegister($scheme, $type);
            }
        }
    }

    public function register()
    {
        $this->registered = stream_get_wrappers();

        foreach ($this->schemes as $scheme => $type) {
            $this->doRegister($scheme, $type);
        }
    }

    /**
     * @param string $scheme
     * @param string $type
     */
    protected function doRegister($scheme, $type)
    {
        if (in_array($scheme, $this->registered, true)) {
            stream_wrapper_unregister($scheme);
        }

        if (!stream_wrapper_register($scheme, $type)) {
            throw new \InvalidArgumentException("Stream `{$scheme}` ({$type}) could not be initialized.");
        }
    }
}
