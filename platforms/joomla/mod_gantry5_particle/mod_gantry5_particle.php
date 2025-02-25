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

use Gantry\Component\Content\Block\HtmlBlock;
use Gantry\Framework\Document;
use Gantry\Framework\Gantry;
use Gantry\Debugger;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

// Detect Gantry Framework or fail gracefully.
if (!class_exists('Gantry\Framework\Gantry')) {
    $app = Factory::getApplication();
    $app->enqueueMessage(
        Text::sprintf('MOD_GANTRY5_PARTICLE_NOT_INITIALIZED', Text::_('MOD_GANTRY5_PARTICLE')),
        'warning'
    );
    return;
}

include_once __DIR__ . '/helper.php';

/** @var object $params */
/** @var object $module */

$gantry = Gantry::instance();

if (\GANTRY_DEBUGGER) {
    Debugger::startTimer("module-{$module->id}", "Rendering Particle Module #{$module->id}");
}

// Set up caching.
$cacheid = md5($module->id);

$cacheparams = (object) [
    'cachemode'    => 'id',
    'class'        => 'ModGantry5ParticleHelper',
    'method'       => 'cache',
    'methodparams' => [$module, $params],
    'modeparams'   => $cacheid
];

/** @var HtmlBlock $block */
$block = ModGantry5ParticleHelper::moduleCache($module, $params, $cacheparams);
if (null === $block) {
    $block = ModGantry5ParticleHelper::render($module, $params);
}

/** @var Document $document */
$document = $gantry['document'];
$document->addBlock($block);

echo $block->toString();

if (\GANTRY_DEBUGGER) {
    Debugger::stopTimer("module-{$module->id}");
}
