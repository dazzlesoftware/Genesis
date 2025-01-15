<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Position;

use Gantry\Component\File\CompiledYamlFile;
use Gantry\Framework\Gantry;
use DazzleSoftware\Toolbox\ArrayTraits\Export;
use DazzleSoftware\Toolbox\ArrayTraits\NestedArrayAccessWithGetters;
use DazzleSoftware\Toolbox\ResourceLocator\UniformResourceLocator;

/**
 * Class Module
 * @package Gantry\Component\Position
 */
class Module implements \ArrayAccess
{
    use NestedArrayAccessWithGetters, Export;

    /** @var string */
    public $name;
    /** @var string|null */
    public $position;
    /** @var string */
    public $assigned;

    /** @var array */
    protected $items;

    /**
     * Module constructor.
     *
     * @param string $name
     * @param string $position
     * @param array $data
     */
    public function __construct($name, $position = null, array $data = null)
    {
        $this->name = $name;
        $this->position = $position;

        if ($data) {
            $this->init($data);
        } else {
            $this->load();
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function update(array $data)
    {
        $this->init($data);

        return $this;
    }

    /**
     * Save module.
     *
     * @param string $position
     * @param string $name
     * @return $this
     */
    public function save($name = null, $position = null)
    {
        $this->name = $name ?: $this->name;
        $this->position = $position ?: $this->position;

        $items = $this->toArray();
        unset($items['position'], $items['id']);

        $file = $this->file(true);
        $file->save($items);

        return $this;
    }

    /**
     * Delete module.
     *
     * @return $this
     */
    public function delete()
    {
        $file = $this->file(true);
        if ($file->exists()) {
            $file->delete();
        }

        return $this;
    }

    /**
     * Return true if module exists.
     *
     * @return bool
     */
    public function exists()
    {
        return $this->name ? $this->file()->exists() : false;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return  ['position' => $this->position, 'id' => $this->name] + $this->items;
    }

    protected function load()
    {
        $file = $this->file();
        $this->init((array)$file->content());
        $file->free();
    }

    /**
     * @param array $data
     */
    protected function init($data)
    {
        unset($data['id'], $data['position']);

        $this->items = $data;

        if (isset($this->items['assignments'])) {
            $assignments = $this->items['assignments'];
            if (is_array($assignments)) {
                $this->assigned = 'some';
            } elseif ($assignments !== 'all') {
                $this->assigned = 'none';
            } else {
                $this->assigned = 'all';
            }
        } else {
            $this->assigned = 'all';
        }
    }

    /**
     * @param bool $save
     * @return CompiledYamlFile
     */
    protected function file($save = false)
    {
        $position = $this->position ?: '_unassigned_';

        $this->name = $this->name ?: ($save ? $this->findFreeName() : null);
        $name = $this->name ?: '_untitled_';

        /** @var UniformResourceLocator $locator */
        $locator = Gantry::instance()['locator'];

        return CompiledYamlFile::instance($locator->findResource("gantry-positions://{$position}/{$name}.yaml", true, $save));
    }

    /**
     * Find unused name with number appended.
     */
    protected function findFreeName()
    {
        $position = $this->position ?: '_unassigned_';
        $name = $this->get('type');
        $name = $name === 'particle' ? $this->get('options.type') : $name;

        /** @var UniformResourceLocator $locator */
        $locator = Gantry::instance()['locator'];

        if (!file_exists($locator->findResource("gantry-positions://{$position}/{$name}.yaml", true, true))) {
            return $name;
        }

        $count = 1;

        do {
            $count++;
        } while (file_exists($locator->findResource("gantry-positions://{$position}/{$name}_{$count}.yaml", true, true)));

        return "{$name}_{$count}";
    }
}
