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

use Gantry\Component\Translator\Translator as BaseTranslator;
use Joomla\CMS\Language\Text;

/**
 * Class Translator
 * @package Gantry\Framework
 */
class Translator extends BaseTranslator
{
    /**
     * @param string $string
     * @return string
     */
    public function translate($string)
    {
        if (\func_num_args() === 1) {
            return Text::_($string);
        }

        $args = \func_get_args();

        return Text::sprintf(...$args);
    }
}
