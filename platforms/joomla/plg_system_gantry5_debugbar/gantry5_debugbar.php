<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\DispatcherInterface;

// Quick check to prevent fatal error in unsupported Joomla admin.
if (!class_exists(CMSPlugin::class)) {
    return;
}

/**
 * Class plgSystemGantry5_Debugbar
 */
class plgSystemGantry5_Debugbar extends CMSPlugin
{
    /**
     * plgSystemGantry5_Debugbar constructor.
     * @param DispatcherInterface $subject
     * @param array $config
     */
    public function __construct(&$subject, $config = array())
    {
        require_once __DIR__ . '/Debugger.php';
        parent::__construct($subject, $config);
    }
}
