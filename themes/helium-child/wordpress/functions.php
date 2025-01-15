<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

defined('ABSPATH') or die;

\add_action('wp_enqueue_scripts', static function() {
    \wp_enqueue_style('parent-style', \get_template_directory_uri() . '/style.css');
});
