<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\WordPress;

use Timber\Pagination;

/**
 * Class PostQuery
 * @package Gantry\WordPress
 */
class PostQuery extends \Timber\PostQuery
{
    /**
     * For backwards compatibility.
     *
     * @return mixed
     */
    public function post_count()
    {
        return $this->count();
    }

    /**
     * For backwards compatibility.
     *
     * @param array $prefs
     * @return Pagination
     */
    public function get_pagination($prefs)
    {
        return $this->pagination((array)$prefs);
    }
}
