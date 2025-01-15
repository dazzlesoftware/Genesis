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

/**
 * Class Page
 * @package Gantry\Framework
 */
class Page extends Base\Page
{
    /** @var string */
    public $home;
    /** @var string */
    public $outline;
    /** @var string */
    public $language;
    /** @var string */
    public $direction;

    /**
     * Page constructor.
     * @param Gantry $container
     */
    public function __construct($container)
    {
        parent::__construct($container);

        $site = Gantry::instance()['site'];

        $this->home = \is_front_page();
        $this->outline = $container['configuration'];
        $this->language = str_replace('_', '-', (string)$site->language);
        $this->direction = function_exists('is_rtl') && is_rtl() ? 'rtl' : 'ltr';
    }

    /**
     * @param array $args
     * @return string
     */
    public function url(array $args = [])
    {
        return \home_url(\add_query_arg($args, $GLOBALS['wp']->request));
    }

    /**
     * @return string
     */
    public function htmlAttributes()
    {
        $attributes = [
                'lang' => $this->language,
                'dir' => $this->direction
              ]
              + (array) $this->config->get('page.html', []);

        return $this->getAttributes($attributes);
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function bodyAttributes($attributes = [])
    {
        // TODO: we might need something like
        // class="{{body_class}}" data-template="{{ twigTemplate|default('base.twig') }}"

        $body_classes = \apply_filters('gantry5_body_classes', [
                'site',
                'outline-' . Gantry::instance()['configuration'],
                'dir-' . $this->direction
            ]);

        $wp_body_class = \get_body_class($body_classes);

        if(is_array($wp_body_class) && !empty($wp_body_class)) {
            $attributes['class'] = array_merge_recursive($attributes['class'], $wp_body_class);
        }

        return $this->getAttributes((array) $this->config->get('page.body.attribs'), $attributes);
    }
}
