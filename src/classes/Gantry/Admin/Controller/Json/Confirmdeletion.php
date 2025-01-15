<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Admin\Controller\Json;

use Gantry\Component\Admin\JsonController;
use Gantry\Component\Response\JsonResponse;

/**
 * Class Confirmdeletion
 * @package Gantry\Admin\Controller\Json
 */
class Confirmdeletion extends JsonController
{
    /** @var array */
    protected $httpVerbs = [
        'GET' => [
            '/' => 'index'
        ]
    ];

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $pageType = $this->request->get->get('page_type', 'OUTLINE');
        $response = ['html' => $this->render('@gantry-admin/ajax/confirm-deletion.html.twig', ['page_type' => $pageType])];

        return new JsonResponse($response);
    }
}
