<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Framework;

use Gantry\Component\Theme\ThemeInstaller as AbstractInstaller;

/**
 * Class ThemeInstaller
 * @package Gantry\Framework
 */
class ThemeInstaller extends AbstractInstaller
{
    /** @var bool */
    public $initialized = true;

    /**
     * @return string
     */
    public function getPath()
    {
        return \get_theme_root() . '/' . $this->name;
    }

    public function createSampleData()
    {
        // TODO: Create menus etc.
    }
}
