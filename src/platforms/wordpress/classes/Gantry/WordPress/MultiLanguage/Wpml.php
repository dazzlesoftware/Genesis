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
 * Class Wpml
 * @package Gantry\WordPress\MultiLanguage
 */
class Wpml extends WordPress
{
    /**
     * @return bool
     */
    public static function enabled()
    {
        return \apply_filters('wpml_current_language', null) !== null;
    }

    /*
    public function getCurrentLanguage()
    {
        return apply_filters('wpml_current_language', null);
    }

    public function getLanguageOptions()
    {
        $languages = (array) apply_filters('wpml_active_languages', null);

        $items = [];
        foreach ($languages as $language) {
            $items[] = [
                'name' => $language['language_code'],
                'label' => $language['translated_name'],
            ];
        }

        return $items;
    }
    */
}
