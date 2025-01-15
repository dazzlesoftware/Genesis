<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Framework;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Document\HtmlDocument;
use Joomla\CMS\Factory;

/**
 * Class Site
 * @package Gantry\Framework
 */
class Site
{
    /** @var string */
    public $theme;
    /** @var string */
    public $url;
    /** @var string */
    public $title;
    /** @var string */
    public $description;

    public function __construct()
    {
        /** @var CMSApplication $application */
        $application = Factory::getApplication();
        $document = $application->getDocument();

        if ($document instanceof HtmlDocument) {
            $this->theme = $document->template;
            $this->url = $document->baseurl;
            $this->title = $document->title;
            $this->description = $document->description;
        }
    }
}
