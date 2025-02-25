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

use Gantry\Admin\Router;
use Gantry\Framework\Gantry;
use Gantry5\Loader;
use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/** @var AdministratorApplication $app */
$app = Factory::getApplication();
$user = $app->getIdentity();

// ACL for Gantry admin access.
if (!$user || (
    !$user->authorise('core.manage', 'com_gantry5')
    && !$user->authorise('core.manage', 'com_templates')
    // Editing particle module makes AJAX call to Gantry component, but has restricted access to json only.
    && !($user->authorise('core.manage', 'com_modules') && strtolower($app->input->getCmd('format', 'html')) === 'json')
)) {
    $app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');

    return false;
}

if (!defined('GANTRYADMIN_PATH')) {
    define('GANTRYADMIN_PATH', JPATH_COMPONENT_ADMINISTRATOR);
}

// Detect Gantry Framework or fail gracefully.
if (!class_exists('Gantry5\Loader')) {
    $app->enqueueMessage(
        Text::sprintf('COM_GANTRY5_PLUGIN_MISSING', Text::_('COM_GANTRY5')),
        'error'
    );
    return;
}

// Initialize administrator or fail gracefully.
try {
    Loader::setup();

    $gantry = Gantry::instance();
    $gantry['router'] = function ($c) {
        return new Router($c);
    };

} catch (Exception $e) {
    $app->enqueueMessage(Text::sprintf($e->getMessage()), 'error');

    return;
}

// Dispatch to the controller.
/** @var Router $router */
$router = $gantry['router'];
$router->dispatch();
