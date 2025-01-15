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
 * Interface MultiLantuageInterface
 * @package Gantry\WordPress\MultiLanguage
 */
interface MultiLantuageInterface
{
    /**
     * @return bool
     */
    public static function enabled();

    /**
     * @return string
     */
    public function getCurrentLanguage();

    /**
     * @return array
     */
    public function getLanguageOptions();
}
