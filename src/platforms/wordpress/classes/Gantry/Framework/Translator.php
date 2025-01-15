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
        static $textdomain;
        static $enginedomain;

        /** @var Theme $theme */
        $theme = Gantry::instance()['theme'];

        if (null === $textdomain) {
            $textdomain = $theme->details()->get('configuration.theme.textdomain', false);
            $enginedomain = $theme->details()->get('configuration.gantry.engine', 'nucleus');
        }

        $translated = $textdomain ? \__($string, $textdomain) : $string;

        if ($translated === $string) {
            $translated = \__($string, $enginedomain);
        }

        if ($translated === $string) {
            $translated = \__($string, 'gantry5');
        }

        if ($translated === $string) {
            // Create WP compatible translation string.
            $string = parent::translate($string);

            $translated = $textdomain ? \__($string, $textdomain) : $string;
            if ($translated === $string) {
                $translated = \__($string, 'gantry5');
            }
        }

        if (\func_num_args() === 1) {
            return $translated;
        }

        $args = \func_get_args();
        $args[0] = $translated;

        return sprintf(...$args);
    }
}
