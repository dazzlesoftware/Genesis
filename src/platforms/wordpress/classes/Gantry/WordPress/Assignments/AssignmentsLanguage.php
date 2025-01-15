<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\WordPress\Assignments;

use Gantry\Component\Assignments\AssignmentsInterface;
use Gantry\WordPress\MultiLanguage\MultiLantuageInterface;
use Gantry\WordPress\MultiLanguage\PolyLang;
use Gantry\WordPress\MultiLanguage\WordPress;
use Gantry\WordPress\MultiLanguage\Wpml;

/**
 * Class AssignmentsLanguage
 * @package Gantry\WordPress\Assignments
 */
class AssignmentsLanguage implements AssignmentsInterface
{
    /** @var string */
    public $type = 'language';
    /** @var int */
    public $priority = 1;

    /** @var MultiLantuageInterface */
    protected $adapter;

    /**
     * Returns list of rules which apply to the current page.
     *
     * @return array
     */
    public function getRules()
    {
        $code = $this->getAdapter()->getCurrentLanguage();
        $rules[$code] = $this->priority;

        return [$rules];
    }

    /**
     * List all the rules available.
     *
     * @param string $configuration
     * @return array
     */
    public function listRules($configuration)
    {
        $items = $this->getAdapter()->getLanguageOptions();

        // Get label and items for each menu
        $list = [
                'label' => 'Languages',
                'items' => $items
        ];

        return [$list];
    }

    /**
     * @return MultiLantuageInterface|PolyLang|WordPress|Wpml
     */
    protected function getAdapter()
    {
        if (!$this->adapter) {
            if (Wpml::enabled()) {
                $this->adapter = new Wpml;
            } elseif (PolyLang::enabled()) {
                $this->adapter = new PolyLang;
            } else {
                $this->adapter = new WordPress;
            }
        }

        return $this->adapter;
    }
}
