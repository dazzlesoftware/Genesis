<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Controller;

use Gantry\Component\Response\HtmlResponse;
use Gantry\Component\Response\Response;

/**
 * Class HtmlController
 * @package Gantry\Component\Controller
 */
abstract class HtmlController extends BaseController
{
    /**
     * Execute controller and returns Response object, defaulting to HtmlResponse.
     *
     * @param string $method
     * @param array $path
     * @param array $params
     * @return Response
     * @throws \RuntimeException
     */
    public function execute($method, array $path, array $params)
    {
        $response = parent::execute($method, $path, $params);

        if (!$response instanceof Response) {
            $response = new HtmlResponse($response);
        }

        return $response;
    }
}
