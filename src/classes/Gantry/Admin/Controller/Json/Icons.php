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
use Gantry\Component\Config\Config;
use Gantry\Component\Response\JsonResponse;

/**
 * Class Icons
 * @package Gantry\Admin\Controller\Json
 */
class Icons extends JsonController
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $response = [];

        $this->container['configuration'] = 'default';

        /** @var Config $config */
        $config = $this->container['config'];

        $version = $config->get('page.fontawesome.version', $config->get('page.fontawesome.default_version', 'fa4'));
        if ($version === 'fa4') {
            $list = include __DIR__ . '/Icons/FontAwesome4.php';
        } else {
            $list = include __DIR__ . '/Icons/FontAwesome5.php';
        }

        $options = [
            'fw' => 'Fixed Width',
            'spin' => 'Spinning',
            'larger' => ['' => '- Size - ', 'lg' => 'Large', '2x' => '2x', '3x' => '3x', '4x' => '4x', '5x' => '5x'],
            'rotation' => ['' => '- Rotation -', 'flip-horizontal' => 'Horizontal Flip', 'flip-vertical' => 'Vertical Flip', 'rotate-90' => 'Rotate 90°', 'rotate-180' => 'Rotate 180°', 'rotate-270' => 'Rotate 270°']
        ];

        $list = array_unique($list);
        sort($list);

        $response['html'] = $this->render('@gantry-admin/ajax/icons.html.twig', ['icons' => $list, 'options' => $options, 'total' => count($list)]);

        return new JsonResponse($response);
    }
}
