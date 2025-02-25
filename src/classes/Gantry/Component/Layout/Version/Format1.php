<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Layout\Version;

/**
 * Read layout from simplified yaml file.
 */
class Format1
{
    /** @var array */
    protected $scopes = [0 => 'grid', 1 => 'block'];
    /** @var array */
    protected $data;
    /** @var array */
    protected $keys = [];

    /**
     * Format1 constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function load()
    {
        $data = &$this->data;

        // Check if we have preset.
        $preset = [];
        if (isset($data['preset']) && is_array($data['preset']) && isset($data['layout']) && is_array($data['layout'])) {
            $preset = $data['preset'];
            $data = $data['layout'];
        }

        // We have user entered file; let's build the layout.

        // Two last items are always offcanvas and atoms.
        $offcanvas = isset($data['offcanvas']) ? $data['offcanvas'] : [];
        $atoms = isset($data['atoms']) ? $data['atoms'] : [];

        unset($data['offcanvas'], $data['atoms']);

        $data['offcanvas'] = $offcanvas;
        if ($atoms) {
            $data['atoms'] = $atoms;
        }

        $result = [];
        foreach ($data as $field => $params) {
            $child = $this->parse($field, (array) $params, 0);
            unset($child->size);

            $result[] = $child;
        }

        return ['preset' => $preset] + $result;
    }

    /**
     * @param array $preset
     * @param array $structure
     * @return array
     */
    public function store(array $preset, array $structure)
    {
        return ['preset' => $preset, 'children' => $structure];
    }

    /**
     * @param \stdClass $item
     * @param bool $container
     */
    protected function normalize(&$item, $container = false)
    {
        if ($item->type === 'pagecontent') {
            // Update pagecontent to match the new standards.
            $item->type = 'system';
            if (!$item->subtype || $item->subtype === 'pagecontent') {
                $item->subtype = 'content';
                $item->title = 'Page Content';
            } else {
                $item->subtype ='messages';
                $item->title = 'System Messages';
            }
        }

        if ($item->type === 'section') {
            // Update section to match the new standards.
            $section = strtolower($item->title);
            $item->id = $section;
            $item->subtype = (in_array($section, ['aside', 'nav', 'article', 'header', 'footer', 'main']) ? $section : 'section');
        } elseif ($item->type === 'offcanvas') {
            $item->id = $item->subtype = $item->type;
            unset ($item->attributes->name, $item->attributes->boxed);

            return;
        } else {
            // Update all ids to match the new standards.
            $item->id = $this->id($item->type, $item->subtype);
        }

        if (!empty($item->attributes->extra)) {
            /** @var \stdClass $attributes */
            $attributes = $item->attributes;
            foreach ($attributes->extra as $i => $extra) {
                $v = reset($extra);
                $k = key($extra);
                if ($k === 'id') {
                    $item->id = preg_replace('/^g-/', '', $v);
                    $attributes->id = $v;
                    unset ($attributes->extra[$i]);
                }
            }
            if (empty($item->attributes->extra)) {
                unset ($item->attributes->extra);
            }
        }

        $item->subtype = $item->subtype ?: $item->type;
        $item->layout = in_array($item->type, ['container', 'section', 'grid', 'block', 'offcanvas']);

        if (isset($item->attributes->boxed)) {
            // Boxed already set, just change boxed=0 to boxed='' to use default settings.
            $item->attributes->boxed = $item->attributes->boxed ?: '';

            return;
        }

        if (!$container) {
            return;
        }

        // Update boxed model to match the new standards.
        if (isset($item->children) && count($item->children) === 1) {
            $child = reset($item->children);
            if ($item->type === 'container') {
                // Remove parent container only if the only child is a section.
                if ($child->type === 'section') {
                    $child->attributes->boxed = 1;
                    $item = $child;
                }
                $item->attributes->boxed = '';
            } elseif ($child->type === 'container') {
                // Remove child container.
                $item->attributes->boxed = '';
                $item->children = $child->children;
            }
        }
    }

    /**
     * @param int|string $field
     * @param array $content
     * @param int $scope
     * @param bool|null $container
     * @return object
     */
    protected function parse($field, array $content, $scope, $container = true)
    {
        if (is_numeric($field))  {
            // Row or block
            $type = $this->scopes[$scope];
            $result = (object) ['id' => null, 'type' => $type, 'subtype' => $type, 'layout' => true, 'attributes' => (object) []];
            $scope = ($scope + 1) % 2;
        } elseif (strpos($field, 'container') === 0) {
            // Container
            $type = 'container';
            $result = (object) ['id' => null, 'type' => $type, 'subtype' => $type, 'layout' => true, 'attributes' => (object) []];
            $id = substr($field, 10) ?: null;
            if ($id !== null) {
                $result->attributes->id = $id;
            }
        } else {
            // Section
            $list = explode(' ', $field, 2);
            $field = array_shift($list);
            $size = ((float) array_shift($list)) ?: null;
            $type = in_array($field, ['atoms', 'offcanvas']) ? $field : 'section';
            $subtype = in_array($field, ['aside', 'nav', 'article', 'header', 'footer', 'main']) ? $field : 'section';

            $result = (object) [
                'id' => null,
                'type' => $type,
                'subtype' => $subtype,
                'layout' => true,
                'title' => ucfirst($field),
                'attributes' => (object) ['id' => 'g-' . $field]
            ];

            if ($size) {
                $result->size = $size;
            }
        }

        if (!empty($content)) {
            $result->children = [];
            foreach ($content as $child => $params) {
                if (is_array($params)) {
                    $child = $this->parse($child, $params, $scope, false);
                } else {
                    $child = $this->resolve($params, $scope);
                }
                if (!empty($child->size)) {
                    $result->attributes->size = $child->size;
                }
                unset($child->size);
                $result->children[] = $child;
            }
        }

        $this->normalize($result, $container);

        return $result;
    }

    /**
     * @param string $field
     * @param int $scope
     * @return object
     */
    protected function resolve($field, $scope)
    {
        $list = explode(' ', $field, 2);
        $list2 = explode('-', array_shift($list), 2);
        $size = ((float) array_shift($list)) ?: null;
        $type = array_shift($list2);
        $subtype = array_shift($list2) ?: false;
        $title = ucfirst($subtype ?: $type);

        $attributes = new \stdClass;

        $attributes->enabled = 1;

        if ($subtype && $type === 'position') {
            $attributes->key = $subtype;
            $subtype = false;
        }

        $result = (object) ['id' => $this->id($type, $subtype), 'title' => $title, 'type' => $type, 'subtype' => $subtype, 'attributes' => $attributes];
        $this->normalize($result);

        if ($scope > 1) {
            if ($size) {
                $result->attributes->size = $size;
            }
        } elseif ($scope === 1) {
            $result = (object) ['id' => $this->id('block'), 'type' => 'block', 'subtype' => 'block', 'layout' => true, 'children' => [$result], 'attributes' => new \stdClass];
            if ($size) {
                $result->attributes->size = $size;
            }
        } elseif ($scope === 0) {
            $result = (object) ['id' => $this->id('grid'), 'type' => 'grid', 'subtype' => 'grid', 'layout' => true, 'children' => [$result], 'attributes' => new \stdClass];
        }

        return $result;
    }


    /**
     * @param string $type
     * @param string|null $subtype
     * @return string
     */
    protected function id($type, $subtype = null)
    {
        if ($type === 'atoms') {
            return $type;
        }

        $result = [];
        if ($type !== 'particle' && $type !== 'atom') {
            $result[] = $type;
        }
        if ($subtype && $subtype !== $type) {
            $result[] = $subtype;
        }
        $key = implode('-', $result);

        do {
            $id = mt_rand(1000, 9999);
            if (!isset($this->keys[$key][$id])) {
                break;
            }
        } while (true);

        $this->keys[$key][$id] = true;

        return $key . '-'. $id;
    }
}
