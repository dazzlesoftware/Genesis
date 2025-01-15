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

use Timber\Timber;

/*
 * The Template for displaying sidebar
 */

Timber::render(['partials/sidebar.html.twig'], isset($context) ? $context : []);
