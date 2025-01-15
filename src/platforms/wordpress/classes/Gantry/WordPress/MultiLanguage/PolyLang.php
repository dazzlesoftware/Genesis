<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\WordPress\MultiLanguage;

/**
 * Class PolyLang
 * @package Gantry\WordPress\MultiLanguage
 */
class PolyLang extends WordPress
{
    /**
     * @return bool
     */
    public static function enabled()
    {
        return function_exists('pll_current_language') && function_exists('pll_the_languages');
    }

    /*
    public function getCurrentLanguage()
    {
        return pll_current_language('slug');
    }

    public function getLanguageOptions()
    {
        $languages = pll_the_languages(['raw' => 1]);

        $items = [];
        foreach ($languages as $item) {
            $items[] = [
                'name' => $item['slug'],
                'label' => $item['name'],
            ];
        }

        return $items;
    }
    */
}
