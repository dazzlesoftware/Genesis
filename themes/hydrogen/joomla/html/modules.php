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

/**
 * Gantry Specific Module Chrome
 *
 * @param object $module
 * @param object $params
 * @param string $attribs
 */
function modChrome_gantry($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8');
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class', 'g-title');
	$headerClass    = ($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8') . '"' : '';

	if (!empty ($module->content)) : ?>
		<<?php echo $moduleTag; ?> class="moduletable <?php echo htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT|ENT_SUBSTITUTE, 'UTF-8') . $moduleClass; ?>">
			<?php if ((bool) $module->showtitle) : ?>
				<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</<?php echo $moduleTag; ?>>
	<?php endif;
}
