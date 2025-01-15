<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

use Gantry\Framework\ThemeInstaller;

defined('ABSPATH') or die;

/**
 * Class G5_HeliumInstallerScript
 */
class G5_HeliumInstallerScript
{
    /**
     * Called by TemplateInstaller to customize post-installation.
     *
     * @param ThemeInstaller $installer
     */
    public function installDefaults(ThemeInstaller $installer)
    {
        // Create default outlines etc.
        $installer->createDefaults();
    }

    /**
     * Called by TemplateInstaller to customize sample data creation.
     *
     * @param ThemeInstaller $installer
     */
    public function installSampleData(ThemeInstaller $installer)
    {
        // Create sample data.
        $installer->createSampleData();
    }
}
