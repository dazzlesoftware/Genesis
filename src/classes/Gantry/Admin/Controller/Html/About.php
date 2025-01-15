<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Admin\Controller\Html;

use Gantry\Admin\ThemeList;
use Gantry\Component\Admin\HtmlController;

/**
 * Class About
 * @package Gantry\Admin\Controller\Html
 */
class About extends HtmlController
{
    /**
     * @return string
     */
    public function index()
    {
        // TODO: Find better way:
        $this->params['info'] = (new ThemeList)->getTheme($this->container['theme.name']);

        return $this->render('@gantry-admin/pages/about/about.html.twig', $this->params);
    }
}
