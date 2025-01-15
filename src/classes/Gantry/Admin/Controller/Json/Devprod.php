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

use Gantry\Admin\Events\Event;
use Gantry\Component\Admin\JsonController;
use Gantry\Component\Response\JsonResponse;

/**
 * Class Devprod
 * @package Gantry\Admin\Controller\Json
 */
class Devprod extends JsonController
{
    /**
     * @return JsonResponse
     */
    public function store()
    {
        $production = (int)(bool)$this->request->post['mode'];

        // Fire save event.
        $event = new Event();
        $event->gantry = $this->container;
        $event->controller = $this;
        $event->data = ['production' => $production];

        $this->container->fireEvent('admin.global.save', $event);

        $response = [
            'mode' => $production,
            'title' => $production ? 'Production' : 'Development',
            'html' => $production ? 'Production mode enabled' : 'Development mode enabled',
        ];

        return new JsonResponse($response);
    }
}
