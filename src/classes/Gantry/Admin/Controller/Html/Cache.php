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

use Gantry\Component\Admin\HtmlController;
use Gantry\Component\Response\JsonResponse;
use Gantry\Component\Filesystem\Folder;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;

/**
 * Class Cache
 * @package Gantry\Admin\Controller\Html
 */
class Cache extends HtmlController
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        /** @var UniformResourceLocator $locator */
        $locator = $this->container['locator'];

        Folder::delete($locator('gantry-cache://theme'), false);
        Folder::delete($locator('gantry-cache://admin'), false);

        // Make sure that PHP has the latest data of the files.
        clearstatcache();

        return new JsonResponse(['html' => 'Cache was successfully cleared', 'title' => 'Cache Cleared']);
    }
}
