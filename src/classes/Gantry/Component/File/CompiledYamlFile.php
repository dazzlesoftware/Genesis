<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\File;

use DazzleSoftware\Toolbox\File\YamlFile;

/**
 * Class CompiledYamlFile
 * @package Gantry\Component\File
 */
class CompiledYamlFile extends YamlFile
{
    use CompiledFile;

    static public $defaultCachePath;
    static public $defaultCaching = true;

    protected function __construct()
    {
        parent::__construct();

        $this->caching(static::$defaultCaching);

        if (static::$defaultCachePath) {
            $this->setCachePath(static::$defaultCachePath);
        }
    }
}
