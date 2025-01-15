<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/**
 * Class JFormFieldWarning
 */
class JFormFieldWarning extends JFormField
{
    /** @var string */
    protected $type = 'Warning';

    /**
     * @return string
     * @throws Exception
     */
    protected function getInput()
    {
        $app = Factory::getApplication();
        if ($app->isClient('administrator')) {
            $app->enqueueMessage(Text::_('GANTRY5_THEME_INSTALL_GANTRY'), 'error');
        } else {
            $app->enqueueMessage(Text::_('GANTRY5_THEME_FRONTEND_SETTINGS_DISABLED'), 'warning');
        }

        return '';
    }
}
