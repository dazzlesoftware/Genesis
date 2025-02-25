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
use Gantry\Component\Filesystem\Folder;
use Gantry\Framework\Importer;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Import
 * @package Gantry\Admin\Controller\Html
 */
class Import extends HtmlController
{
    protected $httpVerbs = [
        'GET' => [
            '/'                 => 'index',
        ],
        'POST' => [
            '/'                 => 'import',
        ]
    ];

    /**
     * @return string
     */
    public function index()
    {
        return $this->render('@gantry-admin/pages/import/import.html.twig', $this->params);
    }

    /**
     * @return string
     */
    public function import()
    {
        if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
            throw new \RuntimeException('No file sent', 400);
        }

        // Check $_FILES['file']['error'] value.
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \RuntimeException('No file sent', 400);
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \RuntimeException('Exceeded filesize limit.', 400);
            default:
                throw new \RuntimeException('Unkown errors', 400);
        }

        $filename = $_FILES['file']['tmp_name'];

        if (!is_uploaded_file($filename)) {
            throw new \RuntimeException('No file sent', 400);
        }

        $zip = new \ZipArchive;
        if ($zip->open($filename) !== true || !($export = Yaml::parse($zip->getFromName('export.yaml'))) || !isset($export['gantry'])) {
            throw new \RuntimeException('Uploaded file is not Gantry 5 export file', 400);
        }

        /** @var UniformResourceLocator $locator */
        $locator = $this->container['locator'];

        $folder = $locator->findResource('gantry-cache://import', true, true);
        if (is_dir($folder)) Folder::delete($folder);
        $zip->extractTo($folder);
        $zip->close();

        $importer = new Importer($folder);
        $importer->all();

        if (is_dir($folder)) Folder::delete($folder);

        $this->params['success'] = true;

        return $this->render('@gantry-admin/pages/import/import.html.twig', $this->params);
    }
}
