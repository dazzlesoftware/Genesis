<?php
/**
 * Plugin Name: Genesis Debug Bar
 * Plugin URI: https://www.dazzlesoftware.org
 * Description: Debug Bar for Genesis
 * Version: @version@
 * Author: Dazzle Software, LLC
 * Author URI: https://www.dazzlesoftware.org
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: genesis_debugbar
 * Domain Path: /admin/languages
 */

defined('ABSPATH') or die;

// NOTE: This file needs to be PHP 5.2 compatible.

// Fail safe version check for PHP <5.6.20.
if (version_compare(PHP_VERSION, '5.6.20', '<')) {
    if (is_admin()) {
        add_action('admin_notices', 'gantry5_debugbar_php_version_warning');
    }
    return;
}

require_once dirname(__FILE__) . '/Debugger.php';

function gantry5_debugbar_php_version_warning()
{
    echo '<div class="error"><p>';
    echo sprintf("You are running <b>PHP %s</b>, but <b>Gantry 5 DebugBar</b> needs at least <b>PHP 5.6.20</b> to run.", PHP_VERSION);
    echo '</p></div>';
}
